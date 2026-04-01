<?php
require TEMPLATEPATH . '/inc/my_variables.php';
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php get_header(); ?>
</head>

<body>
  <?php get_template_part('partials/parts', 'header'); ?>
  <!--================= END OF HEADER ===============-->
  <main>
    <?php my_breadcrumb(); ?>

    <?php
    // 編集権限チェック
    $is_editor = current_user_can('editor') || current_user_can('administrator');

    // 編集フォーム送信時の処理
    if ($is_editor && $_SERVER['REQUEST_METHOD'] === 'POST') {

      $post_id = get_the_ID();

      // タイトル更新
      $new_title = sanitize_text_field($_POST['event_title']);
      wp_update_post([
        'ID'         => $post_id,
        'post_title' => $new_title
      ]);

      if (isset($_POST['featured_experience'])) {
        update_post_meta($post_id, 'featured_experience', 1);
      } else {
        update_post_meta($post_id, 'featured_experience', 0);
      }

      if (isset($_POST['event_slug'])) {
        $new_slug = sanitize_title($_POST['event_slug']);
        wp_update_post([
          'ID'        => $post_id,
          'post_name' => $new_slug,
        ]);
      }

      // ▼ エリア（area）タクソノミー更新
      $selected_area = !empty($_POST['event_area_select']) ? intval($_POST['event_area_select']) : null;
      $new_area_name = !empty($_POST['event_area_new']) ? sanitize_text_field($_POST['event_area_new']) : null;

      if ($new_area_name) {
        $new_term = wp_insert_term($new_area_name, 'area');
        if (!is_wp_error($new_term)) {
          wp_set_post_terms($post_id, [$new_term['term_id']], 'area', false);
        }
      } elseif ($selected_area) {
        wp_set_post_terms($post_id, [$selected_area], 'area', false);
      } else {
        wp_set_post_terms($post_id, [], 'area', false);
      }

      // ▼ 体験種類（type）タクソノミー更新
      $selected_type = !empty($_POST['event_type_select']) ? intval($_POST['event_type_select']) : null;
      $new_type_name = !empty($_POST['event_type_new']) ? sanitize_text_field($_POST['event_type_new']) : null;

      if ($new_type_name) {
        $new_type_term = wp_insert_term($new_type_name, 'type');
        if (!is_wp_error($new_type_term)) {
          wp_set_post_terms($post_id, [$new_type_term['term_id']], 'type', false);
        }
      } elseif ($selected_type) {
        wp_set_post_terms($post_id, [$selected_type], 'type', false);
      } else {
        wp_set_post_terms($post_id, [], 'type', false);
      }

      // ▼ 画像更新/削除
      $img_fields = ['event_img', 'event_img_02', 'event_img_03', 'event_img_04'];
      foreach ($img_fields as $field) {

        // 削除処理
        if (!empty($_POST["delete_{$field}"])) {
          $old_id = get_post_meta($post_id, $field, true);
          if ($old_id) wp_delete_attachment($old_id, true);
          update_post_meta($post_id, $field, '');
        }

        // アップロード処理
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

      // ▼ カスタムフィールド更新
      if (!empty($_POST['event_text'])) {
        update_post_meta($post_id, 'event_text', sanitize_textarea_field($_POST['event_text']));
      }

      if (isset($_POST['time_required'])) {
        update_post_meta($post_id, 'time_required', intval($_POST['time_required']));
      }

      if (!empty($_POST['event_time_schedule'])) {
        update_post_meta($post_id, 'event_time_schedule', sanitize_textarea_field($_POST['event_time_schedule']));
      }

      if (!empty($_POST['event_price'])) {
        update_post_meta($post_id, 'event_price', sanitize_text_field($_POST['event_price']));
      }

      if (!empty($_POST['event_price_detail'])) {
        update_post_meta($post_id, 'event_price_detail', sanitize_textarea_field($_POST['event_price_detail']));
      }

      if (isset($_POST['review_01'])) {
        update_post_meta($post_id, 'review_01', sanitize_textarea_field($_POST['review_01']));
      }

      if (isset($_POST['review_02'])) {
        update_post_meta($post_id, 'review_02', sanitize_textarea_field($_POST['review_02']));
      }

      // 更新後にリロード
      wp_redirect(get_permalink($post_id) . '?updated=1');
      exit;
    }
    ?>

    <section class="sec-post">
      <div class="wrap">
        <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
          <div class="update-popup">更新が完了しました</div>
        <?php endif; ?>

        <?php if ($is_editor): ?>
          <!-- 編集モード -->
          <h2 class="post-title">イベント情報を編集</h2>

          <form method="post" enctype="multipart/form-data">

            <div class="form-item">
              <label>タイトル</label>
              <input type="text" name="event_title" value="<?php echo esc_attr(get_the_title()); ?>" required>
            </div>

            <?php $featured = get_post_meta(get_the_ID(), 'featured_experience', true); ?>

            <div class="form-item">
              <label>
                <input type="checkbox" name="featured_experience" value="1"
                  <?= $featured ? 'checked' : '' ?>>
                Featured Experiences に設定する
              </label>
            </div>

            <div class="form-item">
              <label>URL（スラッグ）</label>
              <input type="text" name="event_slug"
                value="<?= esc_attr(get_post_field('post_name', get_the_ID())); ?>">
            </div>

            <div class="form-item">
              <label>エリア</label>
              <select name="event_area_select">
                <option value="">選択してください</option>
                <?php
                $current_terms = wp_get_post_terms(get_the_ID(), 'area', ['fields' => 'ids']);
                $areas = get_terms(['taxonomy' => 'area', 'hide_empty' => false]);
                foreach ($areas as $area) {
                  $selected = in_array($area->term_id, $current_terms) ? 'selected' : '';
                  echo '<option value="' . esc_attr($area->term_id) . '" ' . $selected . '>' . esc_html($area->name) . '</option>';
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
                $current_type_terms = wp_get_post_terms(get_the_ID(), 'type', ['fields' => 'ids']);
                $types = get_terms(['taxonomy' => 'type', 'hide_empty' => false]);
                foreach ($types as $type) {
                  $selected = in_array($type->term_id, $current_type_terms) ? 'selected' : '';
                  echo '<option value="' . esc_attr($type->term_id) . '" ' . $selected . '>' . esc_html($type->name) . '</option>';
                }
                ?>
              </select>

              <div style="margin-top:10px;">
                <label>新しい体験種類を追加</label>
                <input type="text" name="event_type_new" placeholder="例：Cultural Experiences">
              </div>
            </div>

            <?php
            $img_fields = [
              'event_img'    => '画像1',
              'event_img_02' => '画像2',
              'event_img_03' => '画像3',
              'event_img_04' => '画像4',
            ];

            foreach ($img_fields as $meta_key => $label):

              $img_id  = get_post_meta(get_the_ID(), $meta_key, true);
              $img_url = $img_id ? wp_get_attachment_url($img_id) : '';
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
                  <img id="<?= $preview_id ?>"
                    class="img-preview"
                    src="<?= esc_url($img_url); ?>"
                    style="max-width:300px; <?= $img_id ? 'display:block;' : 'display:none;' ?> margin-top:10px;">
                </div>

                <?php if ($img_id): ?>
                  <label style="display:block; margin-top:10px;">
                    <input type="checkbox" name="delete_<?= $meta_key ?>" value="1">
                    この画像を削除する
                  </label>
                <?php endif; ?>
              </div>

            <?php endforeach; ?>

            <div class="form-item">
              <label>イベント詳細文</label>
              <textarea name="event_text" rows="15" required><?= esc_textarea(get_post_meta(get_the_ID(), 'event_text', true)); ?></textarea>
            </div>

            <div class="form-item">
              <label>所要時間（分）</label>
              <input type="number" name="time_required" min="1" step="1" placeholder="例：120"
                value="<?= esc_attr(get_post_meta(get_the_ID(), 'time_required', true)); ?>">
            </div>

            <div class="form-item">
              <label>タイムスケジュール</label>
              <textarea name="event_time_schedule" rows="10"><?= esc_textarea(get_post_meta(get_the_ID(), 'event_time_schedule', true)); ?></textarea>
            </div>

            <div class="form-item">
              <label>イベント価格</label>
              <input type="text" name="event_price" value="<?= esc_attr(get_post_meta(get_the_ID(), 'event_price', true)); ?>">
            </div>

            <div class="form-item">
              <label>イベント価格詳細</label>
              <textarea name="event_price_detail" rows="10"><?= esc_textarea(get_post_meta(get_the_ID(), 'event_price_detail', true)); ?></textarea>
            </div>

            <div class="form-item">
              <label>レビュー 1</label>
              <textarea name="review_01" rows="5"><?= esc_textarea(get_post_meta(get_the_ID(), 'review_01', true)); ?></textarea>
            </div>

            <div class="form-item">
              <label>レビュー 2</label>
              <textarea name="review_02" rows="5"><?= esc_textarea(get_post_meta(get_the_ID(), 'review_02', true)); ?></textarea>
            </div>

            <button type="submit">更新する</button>
          </form>

          <!-- <?php echo do_shortcode('[site_reviews_form hide="rating, email, name, terms" assign_to="post_id"]'); ?>

          <?php echo do_shortcode('[site_reviews hide="title, rating, date, author, assigned_links" assigned_posts="post_id" display="2"]'); ?> -->

        <?php else: ?>
          <!-- 表示モード（一般ユーザー） -->
          <h2 class="post-title"><?php the_title(); ?></h2>
          <?php
          // ▼ エリア（area）
          $areas = wp_get_post_terms(get_the_ID(), 'area');
          $area_name = (!empty($areas) && !is_wp_error($areas)) ? $areas[0]->name : '';

          // ▼ 体験種類（type）
          $types = wp_get_post_terms(get_the_ID(), 'type');
          $type_name = (!empty($types) && !is_wp_error($types)) ? $types[0]->name : '';

          // ▼ 表示形式： エリア / 体験種類
          if ($area_name || $type_name):
          ?>
            <div class="event-taxonomy">
              <?= esc_html($area_name); ?><?= ($area_name && $type_name) ? ' / ' : ''; ?><?= esc_html($type_name); ?>
            </div>
          <?php endif; ?>

          <div class="post-detail">

            <?php
            $img_ids = [
              get_post_meta(get_the_ID(), 'event_img', true),
              get_post_meta(get_the_ID(), 'event_img_02', true),
              get_post_meta(get_the_ID(), 'event_img_03', true),
              get_post_meta(get_the_ID(), 'event_img_04', true),
            ];

            $img_urls = array_map(fn($id) => $id ? wp_get_attachment_url($id) : null, $img_ids);

            ?>

            <div class="img-area">

              <div id="main-carousel" class="splide" aria-label="main slider">
                <div class="splide__track">
                  <ul class="splide__list">
                    <?php foreach ($img_urls as $url): ?>
                      <?php if ($url): ?>
                        <li class="splide__slide"><img src="<?= esc_url($url); ?>"></li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>

              <div id="thumbnail-carousel" class="splide" aria-label="thumbnail">
                <div class="splide__track">
                  <ul class="splide__list">
                    <?php foreach ($img_urls as $url): ?>
                      <?php if ($url): ?>
                        <li class="splide__slide"><img src="<?= esc_url($url); ?>"></li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>

            </div>

            <div class="text-area">
              <?php $time = get_field('time_required'); ?>
              <p class="duration">所要時間：<?= esc_html($time); ?> 分</p>

              <?php
              $text = get_post_meta(get_the_ID(), 'event_text', true);
              if (!empty($text)):
              ?>
                <div class="event_text">
                  <?= nl2br(auto_link_text($text)); ?>
                </div>
              <?php endif; ?>

              <?php
              $schedule = get_post_meta(get_the_ID(), 'event_time_schedule', true);
              if (!empty($schedule)):
              ?>
                <div class="event_time_schedule">
                  <?= nl2br(auto_link_text($schedule)); ?>
                </div>
              <?php endif; ?>

            </div>

            <div class="price-area">
              <?php
              $price = get_post_meta(get_the_ID(), 'event_price', true);
              if (!empty($price)):
              ?>
                <div class="event_price">
                  <p><?= esc_html($price); ?>JPY</p>
                </div>
              <?php endif; ?>

              <?php
              $price_detail = get_post_meta(get_the_ID(), 'event_price_detail', true);
              if (!empty($price_detail)):
              ?>
                <div class="event_price_detail">
                  <?= nl2br(auto_link_text($price_detail)); ?>
                </div>
              <?php endif; ?>
            </div>

            <?php
            $review_01 = get_field('review_01');
            $review_02 = get_field('review_02');
            ?>

            <?php if ($review_01 || $review_02): ?>
              <div class="review-area">
                <h4>Customer reviews</h4>

                <ul class="review-list">

                  <?php if ($review_01): ?>
                    <li class="review-item">
                      <p><?= esc_html($review_01); ?></p>
                    </li>
                  <?php endif; ?>

                  <?php if ($review_02): ?>
                    <li class="review-item">
                      <p><?= esc_html($review_02); ?></p>
                    </li>
                  <?php endif; ?>

                </ul>
              </div>
            <?php endif; ?>


            <!-- <?php echo do_shortcode('[site_reviews hide="title, rating, date, author, assigned_links" assigned_posts="post_id" display="2"]'); ?> -->

          </div>

          <a style="display: none;" href="<?php echo home_url('/contact/?event_id=' . get_the_ID() . '&event_title=' . urlencode(get_the_title())); ?>" class="common-button">
            <span class="text">Apply Now</span>
          </a>

      </div>

    <?php endif; ?>

    <a href="<?= $home_url ?>/event/" class="back-link">Back to All Experiences</a>
    </div>
    </section>

    <?php get_footer(); ?>
  </main>
  <?php wp_footer() ?>
</body>

</html>