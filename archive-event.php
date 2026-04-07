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


    <section class="sec-event-list">
      <div class="wrap">
        <h2 class="page-title">Experiences</h2>

        <?php
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;

        $allowed_sorts = ['new', 'price', 'time'];
        $sort = isset($_GET['sort']) && in_array($_GET['sort'], $allowed_sorts, true) ? sanitize_text_field($_GET['sort']) : 'new';

        $selected_types = isset($_GET['filter_type']) ? array_map('intval', (array) $_GET['filter_type']) : [];
        $type_terms = get_terms([
          'taxonomy'   => 'type',
          'hide_empty' => false,
        ]);

        $sort_labels = [
          'new'   => '新着順',
          'price' => '安い順',
          'time'  => '所要時間の短い順',
        ];

        $current_filter_args = [];
        if (!empty($selected_types)) {
          $current_filter_args['filter_type'] = $selected_types;
        }
        ?>

        <div class="filter-area">
          <form method="get" action="<?php echo esc_url(remove_query_arg('paged')); ?>">
            <div class="filter-heading">カテゴリ</div>
            <?php if (!empty($type_terms) && !is_wp_error($type_terms)): ?>
              <div class="filter-checkboxes">
                <?php foreach ($type_terms as $term): ?>
                  <label class="filter-option">
                    <input type="checkbox" name="filter_type[]" value="<?php echo esc_attr($term->term_id); ?>"
                      <?php echo in_array($term->term_id, $selected_types, true) ? 'checked' : ''; ?> />
                    <span class="filter-option-text"><?php echo esc_html($term->name); ?></span>
                  </label>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <input type="hidden" name="sort" value="<?php echo esc_attr($sort); ?>" />
            <button type="submit" class="filter-button">検索結果を表示</button>
          </form>
        </div>

        <div class="sort-area">
          <?php foreach ($sort_labels as $sort_key => $sort_label): ?>
            <a class="sort-link<?php echo $sort === $sort_key ? ' current' : ''; ?>"
              href="<?php echo esc_url(add_query_arg(array_merge(['sort' => $sort_key, 'paged' => 1], $current_filter_args))); ?>">
              <?php echo esc_html($sort_label); ?>
            </a>
            <?php if ($sort_key !== array_key_last($sort_labels)): ?>
              <span class="sort-sep">|</span>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>

        <?php
        $args = [
          'post_type'      => 'event',
          'posts_per_page' => 15,   // ← ★ここで1ページあたりの表示数を自由に変更
          'paged'          => $paged,
        ];

        if (!empty($selected_types)) {
          $args['tax_query'] = [
            [
              'taxonomy' => 'type',
              'field'    => 'term_id',
              'terms'    => $selected_types,
            ],
          ];
        }

        switch ($sort) {
          case 'price':
            $args['meta_key'] = 'event_price';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'ASC';
            break;

          case 'time':
            $args['meta_key'] = 'time_required';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'ASC';
            break;

          case 'new':
          default:
            $args['orderby'] = 'date';
            $args['order']   = 'DESC';
            break;
        }

        $query = new WP_Query($args);
        ?>

        <?php if ($query->have_posts()): ?>
          <ul class="event-list">

            <?php while ($query->have_posts()): $query->the_post(); ?>

              <li class="list-item">
                <a href="<?= the_permalink(); ?>" class="post-link">
                  <?php
                  $img_id = get_post_meta(get_the_ID(), 'event_img', true);
                  $img_url = wp_get_attachment_url($img_id);
                  if ($img_id):
                  ?>
                    <div class="main-img">
                      <img src="<?php echo esc_url($img_url); ?>" alt="">
                    </div>
                  <?php endif; ?>
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

                  <div class="list-title">
                    <?= the_title(); ?>
                  </div>
                  <?php
                  $event_text = get_field('event_text');
                  $text_limit = 140;

                  if (mb_strlen($event_text) > $text_limit) {
                    $event_text = mb_substr($event_text, 0, $text_limit) . '...';
                  }
                  ?>
                  <div class="list-text"><?= wp_kses($event_text, array('br' => array())); ?></div>
                  <div class="list-price"><?= the_field('event_price'); ?>JPY</div>
                  <ul class="filter-list">
                    <?php if (get_post_meta(get_the_ID(), 'capacity', true)): ?>
                      <li class="filter-item"><?= get_post_meta(get_the_ID(), 'capacity', true); ?> 人</li>
                    <?php endif; ?>
                    <?php if (get_post_meta(get_the_ID(), 'time_required', true)): ?>
                      <li class="filter-item"><?= get_post_meta(get_the_ID(), 'time_required', true); ?> 分</li>
                    <?php endif; ?>
                    <?php if (get_post_meta(get_the_ID(), 'english_supported', true) == 1): ?>
                      <li class="filter-item">英語対応</li>
                    <?php endif; ?>
                    <?php if (get_post_meta(get_the_ID(), 'kid_friendly', true) == 1): ?>
                      <li class="filter-item">子連れ可</li>
                    <?php endif; ?>
                    <?php if (get_post_meta(get_the_ID(), 'group_booking', true) == 1): ?>
                      <li class="filter-item">グループ貸切可</li>
                    <?php endif; ?>
                    <?php if (get_post_meta(get_the_ID(), 'except_tokyo', true) == 1): ?>
                      <li class="filter-item">東京以外</li>
                    <?php endif; ?>
                  </ul>
                </a>

                <?php get_template_part('partials/post-status', null, ['post_id' => get_the_ID()]); ?>

              </li>

            <?php endwhile; ?>
          </ul>

          <div class="pagenate-area">
            <?php
            $big = 999999999; // 何でも良いダミー値
            $pagination_base = str_replace($big, '%#%', esc_url(get_pagenum_link($big)));

            $pagination_add_args = ['sort' => $sort];
            if (!empty($selected_types)) {
              $pagination_add_args['filter_type'] = $selected_types;
            }

            $pagination_links = paginate_links([
              'base'      => $pagination_base,
              'format'    => 'page/%#%/',
              'current'   => max(1, $paged),
              'total'     => $query->max_num_pages,
              'type'      => 'array',
              'add_args'  => $pagination_add_args,
              'prev_text' => '&laquo;',
              'next_text' => '&raquo;',
            ]);

            if (!empty($pagination_links)):
              echo '<ul class="page-numbers">';

              // ▼ First（最初のページ）
              if ($paged > 1) {
                echo '<li><a class="first page-numbers" href="' . esc_url(add_query_arg(array_merge(['sort' => $sort, 'paged' => 1], $current_filter_args), get_pagenum_link(1))) . '">First</a></li>';
              }

              // ▼ 通常のページネーションリンク
              foreach ($pagination_links as $link) {
                echo '<li>' . $link . '</li>';
              }

              // ▼ Last（最後のページ）
              if ($paged < $query->max_num_pages) {
                echo '<li><a class="last page-numbers" href="' . esc_url(add_query_arg(array_merge(['sort' => $sort, 'paged' => $query->max_num_pages], $current_filter_args), get_pagenum_link($query->max_num_pages))) . '">Last</a></li>';
              }

              echo '</ul>';
            endif;
            ?>
          </div>


          <?php wp_reset_postdata(); ?>

        <?php else: ?>
          <div class="no-results-message">No experiences matched your search.</div>
        <?php endif; ?>
      </div>
    </section>


    <?php get_footer(); ?>
  </main>
  <?php wp_footer() ?>

</body>

</html>