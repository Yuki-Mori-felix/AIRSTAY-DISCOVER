<?php
/* -----------------------------------
  編デフォルト投稿タイプ「投稿」を非表示
----------------------------------- */
function remove_default_post_type()
{
  remove_menu_page('edit.php');
}
add_action('admin_menu', 'remove_default_post_type');

/* -----------------------------------
  カスタム投稿登録
----------------------------------- */
function add_custom_post()
{
  /* イベント情報 */
  register_post_type(
    'event',
    array(
      'label' => 'イベント情報',
      'public' => true,
      'has_archive' => true,
      'show_in_rest' => true,
      'menu_position' => 5,
      'supports' => array(
        'title',
        'thumbnail',
        'custom-fields',
      ),
      'rewrite' => array(
        'slug' => 'experiences',
      )
    )
  );

  /* エリア分類（カテゴリ） */
  register_taxonomy(
    'area', // タクソノミー名
    'event', // 紐づける投稿タイプ
    array(
      'label' => 'エリア',
      'hierarchical' => true, // true でカテゴリ型、false でタグ型
      'public' => true,
      'show_in_rest' => true, // Gutenberg / REST API 対応
    )
  );

  /* エリア分類（カテゴリ） */
  register_taxonomy(
    'type', // タクソノミー名
    'event', // 紐づける投稿タイプ
    array(
      'label' => '体験種類',
      'hierarchical' => true, // true でカテゴリ型、false でタグ型
      'public' => true,
      'show_in_rest' => true, // Gutenberg / REST API 対応
    )
  );
}
add_action('init', 'add_custom_post');


/* -----------------------------------
  編集者ログイン リダイレクト処理
----------------------------------- */
function redirect_editor_after_login($redirect_to, $request, $user)
{
  if (isset($user->roles) && in_array('editor', $user->roles)) {
    return home_url('/editor-home');
  }
  return $redirect_to;
}
add_filter('login_redirect', 'redirect_editor_after_login', 10, 3);

/* -----------------------------------
  フロントエンドから投稿ステータス変更
----------------------------------- */
function handle_frontend_post_status()
{

  // action が無ければ何もしない
  if (!isset($_GET['action'])) {
    return;
  }

  // 投稿IDとnonceが無ければ終了
  if (!isset($_GET['id']) || !isset($_GET['nonce'])) {
    return;
  }

  $post_id = intval($_GET['id']);
  $nonce   = $_GET['nonce'];
  $action  = $_GET['action'];

  // 権限チェック
  if (!current_user_can('editor') && !current_user_can('administrator')) {
    wp_die('権限がありません。');
  }

  /* ----------------------------------------------------
    投稿削除処理
  ---------------------------------------------------- */
  if ($action === 'delete_post') {

    if (!wp_verify_nonce($nonce, 'delete_post_' . $post_id)) {
      wp_die('不正なアクセスです。');
    }

    $post_type = get_post_type($post_id);

    // カスタムフィールドに保存されている画像を削除
    $img_id = get_post_meta($post_id, 'event_img', true);
    if ($img_id) {
      wp_delete_attachment($img_id, true); // メディアからも削除
    }

    // 投稿削除
    wp_delete_post($post_id, true);

    // リダイレクト
    if ($post_type === 'event') {
      wp_redirect(home_url('/event/'));
    } else {
      wp_redirect(home_url('/'));
    }
    exit;
  }

  /* ----------------------------------------------------
    公開/非公開切り替え処理
  ---------------------------------------------------- */
  if ($action === 'toggle_status') {

    if (!wp_verify_nonce($nonce, 'toggle_status_' . $post_id)) {
      wp_die('不正なアクセスです。');
    }

    $current_status = get_post_status($post_id);
    $new_status = ($current_status === 'publish') ? 'private' : 'publish';

    wp_update_post([
      'ID'          => $post_id,
      'post_status' => $new_status
    ]);

    // リダイレクト（一覧へ戻す）
    $post_type = get_post_type($post_id);
    if ($post_type === 'event') {
      wp_redirect(home_url('/event/'));
    } else {
      wp_redirect(home_url('/'));
    }
    exit;
  }
}
add_action('init', 'handle_frontend_post_status');

/* -----------------------------------
  投稿（非公開）の編集時設定
----------------------------------- */
function remove_private_prefix($data, $postarr)
{
  // 投稿タイトルに「非公開: 」が付いていたら削除
  if (! empty($data['post_title'])) {
    $data['post_title'] = preg_replace('/^非公開[:：]\s*/u', '', $data['post_title']);
  }

  return $data;
}
add_filter('wp_insert_post_data', 'remove_private_prefix', 10, 2);

/* -----------------------------------
  投稿本文のURLをリンク化
----------------------------------- */
function auto_link_text($text)
{
  $text = make_clickable($text);
  $text = preg_replace('/<a /', '<a target="_blank" rel="noopener noreferrer" ', $text);
  return $text;
}

/* -----------------------------------
  投稿検索の対象をイベント投稿に限定
----------------------------------- */
// function search_only_event($query)
// {
//   if (!is_admin() && $query->is_search()) {
//     $query->set('post_type', 'event');
//     $query->set('posts_per_page', -1);
//   }
// }
// add_action('pre_get_posts', 'search_only_event');


/* ============================================================
  event 検索時に area / type のタクソノミー名も検索対象に含める
============================================================ */
function event_search_include_taxonomies($where, $query)
{
  global $wpdb;

  // 管理画面 or 検索以外 or event 以外 → 何もしない
  if (is_admin() || !$query->is_search() || $query->get('post_type') !== 'event') {
    return $where;
  }

  $keyword = $query->get('s');
  if (!$keyword) return $where;

  // LIKE 用にエスケープ
  $like = '%' . $wpdb->esc_like($keyword) . '%';

  // タクソノミー名検索を SQL に追加
  $where .= $wpdb->prepare(
    " OR {$wpdb->posts}.ID IN (
            SELECT object_id FROM {$wpdb->term_relationships}
            INNER JOIN {$wpdb->term_taxonomy}
                ON {$wpdb->term_relationships}.term_taxonomy_id = {$wpdb->term_taxonomy}.term_taxonomy_id
            INNER JOIN {$wpdb->terms}
                ON {$wpdb->term_taxonomy}.term_id = {$wpdb->terms}.term_id
            WHERE {$wpdb->terms}.name LIKE %s
              AND {$wpdb->term_taxonomy}.taxonomy IN ('area', 'type')
        )",
    $like
  );

  return $where;
}
add_filter('posts_where', 'event_search_include_taxonomies', 10, 2);


/* ============================================================
  event のみ検索対象にする
============================================================ */
function search_only_event($query)
{
  if (!is_admin() && $query->is_search()) {
    $query->set('post_type', 'event');
    $query->set('posts_per_page', -1);
  }
}
add_action('pre_get_posts', 'search_only_event');


/* ============================================================
  パンくずリスト
============================================================ */
function my_breadcrumb()
{

  // ホームでは表示しない
  if (is_front_page()) return;

  echo '<div class="breadcrumb-area">';
  echo '<nav class="breadcrumb">';
  echo '<a href="' . home_url() . '">Home</a> &gt; ';

  // ▼ event アーカイブページ
  if (is_post_type_archive('event')) {

    echo '<span>Experiences</span>';

    // ▼ event 詳細ページ
  } elseif (is_singular('event')) {

    // 投稿名を取得
    $title = get_the_title();

    // 25文字以上なら省略
    if (mb_strlen($title) > 25) {
      $title = mb_substr($title, 0, 25) . '...';
    }

    echo '<a href="' . get_post_type_archive_link('event') . '">Experiences</a> &gt; ';
    echo '<span>' . esc_html($title) . '</span>';

    // ▼ 通常のアーカイブページ
  } elseif (is_archive()) {

    echo '<span>' . post_type_archive_title('', false) . '</span>';

    // ▼ 通常投稿（post）の詳細ページ
  } elseif (is_singular('post')) {

    $cat = get_the_category();
    if (!empty($cat)) {
      $cat_link = get_category_link($cat[0]->term_id);
      echo '<a href="' . $cat_link . '">' . $cat[0]->name . '</a> &gt; ';
    }

    // 投稿名を取得
    $title = get_the_title();

    // 25文字以上なら省略
    if (mb_strlen($title) > 25) {
      $title = mb_substr($title, 0, 25) . '...';
    }

    echo '<span>' . esc_html($title) . '</span>';

    // ▼ 固定ページ
  } elseif (is_page()) {

    $title = get_the_title();

    if (mb_strlen($title) > 25) {
      $title = mb_substr($title, 0, 25) . '...';
    }

    echo '<span>' . esc_html($title) . '</span>';

    // ▼ 検索結果
  } elseif (is_search()) {
    echo '<span>Search Results</span>';

    // ▼ 404
  } elseif (is_404()) {
    echo '<span>Page Not Found</span>';
  }

  echo '</nav>';
  echo '</div>';
}
