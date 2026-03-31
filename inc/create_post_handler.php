<?php
// カスタム投稿タイプ event 投稿化処理
function handle_frontend_post_create($args)
{
  $post_type      = $args['post_type'];
  $title_field    = $args['title_field'];

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return;
  }

  // タイトル・本文
  $title = sanitize_text_field($_POST[$title_field]);

  $slug = !empty($_POST['event_slug'])
  ? sanitize_title($_POST['event_slug'])
  : sanitize_title($title); // 空ならタイトルから自動生成

  // 投稿作成
  $post_id = wp_insert_post([
    'post_title'   => $title,
    'post_name'    => $slug,
    'post_type'    => $post_type,
    'post_status'  => 'publish',
  ]);


  if (!$post_id) return;

  // ▼▼▼ エリア（area）タクソノミー保存 ▼▼▼
  // 既存エリアの選択
  $selected_area = !empty($_POST['event_area_select']) ? intval($_POST['event_area_select']) : null;

  // 新規エリア名
  $new_area_name = !empty($_POST['event_area_new']) ? sanitize_text_field($_POST['event_area_new']) : null;

  if ($new_area_name) {

    // 新規エリア追加
    $new_term = wp_insert_term($new_area_name, 'area');

    if (!is_wp_error($new_term)) {
      $area_term_id = $new_term['term_id'];
      wp_set_post_terms($post_id, [$area_term_id], 'area', false);
    }
  } elseif ($selected_area) {

    // 既存エリアをセット
    wp_set_post_terms($post_id, [$selected_area], 'area', false);
  } else {

    // ▼ どちらも空 → タクソノミーを未選択に戻す
    wp_set_post_terms($post_id, [], 'area', false);
  }
  // ▲▲▲ エリア保存ここまで ▲▲▲

  // ▼▼▼ 体験種類（type）タクソノミー保存 ▼▼▼
  // 既存 type の選択
  $selected_type = !empty($_POST['event_type_select']) ? intval($_POST['event_type_select']) : null;

  // 新規 type の追加
  $new_type_name = !empty($_POST['event_type_new']) ? sanitize_text_field($_POST['event_type_new']) : null;

  if ($new_type_name) {

    // 新規 term 追加
    $new_type_term = wp_insert_term($new_type_name, 'type');

    if (!is_wp_error($new_type_term)) {
      $type_term_id = $new_type_term['term_id'];
      wp_set_post_terms($post_id, [$type_term_id], 'type', false);
    }
  } elseif ($selected_type) {

    // 既存 term をセット
    wp_set_post_terms($post_id, [$selected_type], 'type', false);
  } else {

    // ▼ どちらも空 → タクソノミーを未選択に戻す
    wp_set_post_terms($post_id, [], 'type', false);
  }
  // ▲▲▲ type 保存ここまで ▲▲▲

  // ▼ 複数のカスタムフィールドを保存
  // if (!empty($args['meta_fields'])) {
  //   foreach ($args['meta_fields'] as $meta_key) {
  //     if (!empty($_POST[$meta_key])) {
  //       update_post_meta($post_id, $meta_key, sanitize_textarea_field($_POST[$meta_key]));
  //     }
  //   }
  // }

  foreach ($args['meta_fields'] as $meta_key) {
  if (isset($_POST[$meta_key])) {
    update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$meta_key]));
  } else {
    // チェックが外された場合は 0 を保存
    update_post_meta($post_id, $meta_key, 0);
  }
}


  // 画像アップロード
  $img_fields = ['event_img', 'event_img_02', 'event_img_03', 'event_img_04'];

  foreach ($img_fields as $field) {
    if (!empty($_FILES[$field]['name'])) {

      require_once(ABSPATH . 'wp-admin/includes/file.php');
      require_once(ABSPATH . 'wp-admin/includes/image.php');

      $file = wp_handle_upload($_FILES[$field], ['test_form' => false]);

      if (!isset($file['error'])) {
        $file_path = $file['file'];
        $file_name = basename($file_path);
        $file_type = $file['type'];

        $attachment = [
          'post_mime_type' => $file_type,
          'post_title'     => sanitize_file_name($file_name),
          'post_content'   => '',
          'post_status'    => 'inherit'
        ];

        $attach_id = wp_insert_attachment($attachment, $file_path, $post_id);
        $attach_data = wp_generate_attachment_metadata($attach_id, $file_path);
        wp_update_attachment_metadata($attach_id, $attach_data);

        update_post_meta($post_id, $field, $attach_id);
      }
    }
  }


  // 投稿タイプごとに一覧ページへリダイレクト
  if ($post_type === 'event') {
    wp_redirect(home_url('/event/'));
  } else {
    wp_redirect(get_permalink($post_id));
  }
  exit;
}
