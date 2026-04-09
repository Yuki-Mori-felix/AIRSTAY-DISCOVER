<?php
/* Template Name: イベント投稿作成ページ */
require TEMPLATEPATH . '/inc/my_variables.php';
require_once get_template_directory() . '/inc/access-control.php';

// 投稿化処理ファイル読み込み
require_once get_template_directory() . '/inc/create_post_handler.php';

// 投稿処理を実行
handle_frontend_post_create([
  'post_type'     => 'event',
  'title_field'   => 'event_title',
  'text_field'    => 'event_text',
  'image_field'   => 'event_img',

  // ▼ 追加したカスタムフィールドを保存するための meta_key を追加
  'meta_fields' => [
    'event_text',
    'event_time_schedule',
    'time_required',
    'event_price',
    'event_price_detail',
    'word_from_airstay',
    'event_url',
    'capacity',
    'english_supported',
    'kid_friendly',
    'group_booking',
    'except_tokyo',
  ],
]);

get_header();
?>

<main>
  <?php get_template_part('partials/parts', 'header'); ?>
  <!--================= END OF HEADER ===============-->
  <section>
    <div class="wrap">
      <h2 class="page-title">イベント情報を作成</h2>

      <form class="editor-mode" method="post" enctype="multipart/form-data">

        <div class="form-item">
          <label>タイトル</label>
          <input type="text" name="event_title" required>
        </div>

        <div class="form-item">
          <label>
            <input type="checkbox" name="featured_experience" value="1">
            Featured Experiences に設定する
          </label>
        </div>

        <div class="form-item">
          <label>URL（スラッグ）</label>
          <input type="text" name="event_slug" placeholder="例：my-event-url">
        </div>

        <div class="form-item">
          <label>エリア</label>

          <select name="event_area_select">
            <option value="">選択してください</option>
            <?php
            $areas = get_terms([
              'taxonomy'   => 'area',
              'hide_empty' => false,
            ]);
            if (!empty($areas) && !is_wp_error($areas)) {
              foreach ($areas as $area) {
                echo '<option value="' . esc_attr($area->term_id) . '">' . esc_html($area->name) . '</option>';
              }
            }
            ?>
          </select>

          <div style="margin-top:10px;">
            <label>新しいエリアを追加</label>
            <input type="text" name="event_area_new" placeholder="例：Tokyo">
          </div>
        </div>

        <div class="form-item">
          <label>体験種類</label>

          <select name="event_type_select">
            <option value="">選択してください</option>
            <?php
            $types = get_terms([
              'taxonomy'   => 'type',
              'hide_empty' => false,
            ]);
            if (!empty($types) && !is_wp_error($types)) {
              foreach ($types as $type) {
                echo '<option value="' . esc_attr($type->term_id) . '">' . esc_html($type->name) . '</option>';
              }
            }
            ?>
          </select>

          <div style="margin-top:10px;">
            <label>新しい体験種類を追加</label>
            <input type="text" name="event_type_new" placeholder="例：Cultural Experiences">
          </div>
        </div>

        <div class="form-item">
          <label>定員</label>
          <input type="number" name="capacity" min="1" step="1" placeholder="例：4">
        </div>

        <div class="form-item">
          <label>
            <input type="checkbox" name="english_supported" value="1">
            英語対応
          </label>
        </div>

        <div class="form-item">
          <label>
            <input type="checkbox" name="kid_friendly" value="1">
            子連れ可
          </label>
        </div>

        <div class="form-item">
          <label>
            <input type="checkbox" name="group_booking" value="1">
            グループ貸切可
          </label>
        </div>

        <div class="form-item">
          <label>
            <input type="checkbox" name="except_tokyo" value="1">
            東京以外の体験
          </label>
        </div>

        <?php
        $img_fields = [
          'event_img'    => '画像1',
          'event_img_02' => '画像2',
          'event_img_03' => '画像3',
          'event_img_04' => '画像4',
        ];

        foreach ($img_fields as $meta_key => $label):
          $input_id = $meta_key . '_input';
          $preview_id = $meta_key . '_preview';
          $upload_area_id = $meta_key . '_upload_area';
        ?>
          <div class="form-item">
            <label><?= $label ?></label>

            <div class="upload-area" id="<?= $upload_area_id ?>">
              <p>ここに画像をドラッグ＆ドロップ<br>またはクリックして選択</p>
              <input type="file" id="<?= $input_id ?>" name="<?= $meta_key ?>" accept="image/*" hidden>
            </div>

            <div class="img-preview-wrap">
              <img id="<?= $preview_id ?>" class="img-preview"
                src=""
                alt=""
                style="max-width:300px; display:none; margin-top:10px;">
            </div>
          </div>
        <?php endforeach; ?>


        <!-- ▼ 名称変更：本文 → イベント詳細文 -->
        <div class="form-item">
          <label>イベント詳細文</label>
          <textarea name="event_text" rows="15" required></textarea>
        </div>

        <div class="form-item">
          <label>所要時間（分）</label>
          <input type="number" name="time_required" min="1" step="1" placeholder="例：120">
        </div>

        <!-- ▼ 追加項目：タイムスケジュール -->
        <div class="form-item" style="display: none;">
          <label>タイムスケジュール</label>
          <textarea name="event_time_schedule" rows="10"></textarea>
        </div>

        <!-- ▼ 追加項目：イベント価格 -->
        <div class="form-item">
          <label>イベント価格</label>
          <input type="text" name="event_price" placeholder="例：15,000">
        </div>

        <!-- ▼ 追加項目：イベント価格詳細 -->
        <div class="form-item">
          <label>イベント価格詳細</label>
          <textarea name="event_price_detail" rows="10"></textarea>
        </div>

        <div class="form-item">
          <label>AIRSTAYからひとこと</label>
          <textarea name="word_from_airstay" rows="3"></textarea>
        </div>

        <div class="form-item">
          <label>運営者ページURL</label>
          <input type="url" name="event_url" placeholder="https://">
        </div>


        <button type="submit">投稿する</button>
        <a href="<?= $home_url ?>/editor-home/" class="back-button">戻る</a>
      </form>
    </div>
  </section>
</main>

<?php get_footer(); ?>