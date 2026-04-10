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

        $search_keyword = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
        $selected_types = isset($_GET['filter_type']) ? array_map('intval', (array) $_GET['filter_type']) : [];
        $type_terms = get_terms([
          'taxonomy'   => 'type',
          'hide_empty' => false,
        ]);

        // ▼ 新しいフィルター項目の処理
        $english_supported = isset($_GET['english_supported']) ? 1 : 0;
        $kid_friendly = isset($_GET['kid_friendly']) ? 1 : 0;
        $group_booking = isset($_GET['group_booking']) ? 1 : 0;
        $selected_capacity_ranges = isset($_GET['capacity_range']) ? array_map('sanitize_text_field', (array) $_GET['capacity_range']) : [];
        $selected_time_ranges = isset($_GET['time_range']) ? array_map('sanitize_text_field', (array) $_GET['time_range']) : [];

        $sort_labels = [
          'new'   => '新着順',
          'price' => '安い順',
          'time'  => '所要時間の短い順',
        ];

        $current_filter_args = [];
        if (!empty($selected_types)) {
          $current_filter_args['filter_type'] = $selected_types;
        }
        if ($english_supported) {
          $current_filter_args['english_supported'] = $english_supported;
        }
        if ($kid_friendly) {
          $current_filter_args['kid_friendly'] = $kid_friendly;
        }
        if ($group_booking) {
          $current_filter_args['group_booking'] = $group_booking;
        }
        if (!empty($selected_capacity_ranges)) {
          $current_filter_args['capacity_range'] = $selected_capacity_ranges;
        }
        if (!empty($selected_time_ranges)) {
          $current_filter_args['time_range'] = $selected_time_ranges;
        }
        if ($search_keyword) {
          $current_filter_args['s'] = $search_keyword;
        }
        ?>

        <div class="filter-area filter-modal" style="display: none;">
          <div class="filter-modal-overlay"></div>
          <div class="filter-modal-content">
            <span type="button" class="filter-close-button">&times;</span>
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

              <div class="filter-heading">オプション</div>
              <div class="filter-checkboxes">
                <label class="filter-option">
                  <input type="checkbox" name="english_supported" value="1"
                    <?php echo $english_supported ? 'checked' : ''; ?> />
                  <span class="filter-option-text">英語対応</span>
                </label>
                <label class="filter-option">
                  <input type="checkbox" name="kid_friendly" value="1"
                    <?php echo $kid_friendly ? 'checked' : ''; ?> />
                  <span class="filter-option-text">子連れ可</span>
                </label>
                <label class="filter-option">
                  <input type="checkbox" name="group_booking" value="1"
                    <?php echo $group_booking ? 'checked' : ''; ?> />
                  <span class="filter-option-text">グループ貸切</span>
                </label>
              </div>

              <div class="filter-heading">人数</div>
              <div class="filter-checkboxes">
                <label class="filter-option">
                  <input type="checkbox" name="capacity_range[]" value="1-10"
                    <?php echo in_array('1-10', $selected_capacity_ranges, true) ? 'checked' : ''; ?> />
                  <span class="filter-option-text">~10人</span>
                </label>
                <label class="filter-option">
                  <input type="checkbox" name="capacity_range[]" value="10-20"
                    <?php echo in_array('10-20', $selected_capacity_ranges, true) ? 'checked' : ''; ?> />
                  <span class="filter-option-text">10~20人</span>
                </label>
                <label class="filter-option">
                  <input type="checkbox" name="capacity_range[]" value="20+"
                    <?php echo in_array('20+', $selected_capacity_ranges, true) ? 'checked' : ''; ?> />
                  <span class="filter-option-text">20人+</span>
                </label>
              </div>

              <div class="filter-heading">所要時間</div>
              <div class="filter-checkboxes">
                <label class="filter-option">
                  <input type="checkbox" name="time_range[]" value="0-60"
                    <?php echo in_array('0-60', $selected_time_ranges, true) ? 'checked' : ''; ?> />
                  <span class="filter-option-text">~60分</span>
                </label>
                <label class="filter-option">
                  <input type="checkbox" name="time_range[]" value="60-90"
                    <?php echo in_array('60-90', $selected_time_ranges, true) ? 'checked' : ''; ?> />
                  <span class="filter-option-text">60~90分</span>
                </label>
                <label class="filter-option">
                  <input type="checkbox" name="time_range[]" value="90-120"
                    <?php echo in_array('90-120', $selected_time_ranges, true) ? 'checked' : ''; ?> />
                  <span class="filter-option-text">90~120分</span>
                </label>
                <label class="filter-option">
                  <input type="checkbox" name="time_range[]" value="120-150"
                    <?php echo in_array('120-150', $selected_time_ranges, true) ? 'checked' : ''; ?> />
                  <span class="filter-option-text">120~150分</span>
                </label>
                <label class="filter-option">
                  <input type="checkbox" name="time_range[]" value="150-180"
                    <?php echo in_array('150-180', $selected_time_ranges, true) ? 'checked' : ''; ?> />
                  <span class="filter-option-text">150~180分</span>
                </label>
                <label class="filter-option">
                  <input type="checkbox" name="time_range[]" value="180+"
                    <?php echo in_array('180+', $selected_time_ranges, true) ? 'checked' : ''; ?> />
                  <span class="filter-option-text">180分+</span>
                </label>
              </div>

              <?php if ($search_keyword): ?>
                <input type="hidden" name="s" value="<?php echo esc_attr($search_keyword); ?>" />
              <?php endif; ?>
              <input type="hidden" name="sort" value="<?php echo esc_attr($sort); ?>" />
              <button type="submit" class="filter-button">検索結果を表示</button>
            </form>
          </div>
        </div>

        <div class="flex-filters">
          <div type="button" class="filter-toggle-button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
              <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
            </svg>
            フィルター
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
        </div>

        <?php
        $args = [
          'post_type'      => 'event',
          'posts_per_page' => 15,   // ← ★ここで1ページあたりの表示数を自由に変更
          'paged'          => $paged,
        ];

        if ($search_keyword) {
          $args['s'] = $search_keyword;
        }

        if (!empty($selected_types)) {
          $args['tax_query'] = [
            [
              'taxonomy' => 'type',
              'field'    => 'term_id',
              'terms'    => $selected_types,
            ],
          ];
        }

        // ▼ 新しいメタフィルターの追加
        $meta_query = [];
        if ($english_supported) {
          $meta_query[] = [
            'key'   => 'english_supported',
            'value' => '1',
            'compare' => '='
          ];
        }
        if ($kid_friendly) {
          $meta_query[] = [
            'key'   => 'kid_friendly',
            'value' => '1',
            'compare' => '='
          ];
        }
        if ($group_booking) {
          $meta_query[] = [
            'key'   => 'group_booking',
            'value' => '1',
            'compare' => '='
          ];
        }

        // ▼ 人数範囲フィルターの追加
        if (!empty($selected_capacity_ranges)) {
          $capacity_conditions = [];
          foreach ($selected_capacity_ranges as $range) {
            switch ($range) {
              case '1-10':
                $capacity_conditions[] = [
                  'key'     => 'capacity',
                  'value'   => 10,
                  'type'    => 'NUMERIC',
                  'compare' => '<='
                ];
                break;
              case '10-20':
                $capacity_conditions[] = [
                  'relation' => 'AND',
                  [
                    'key'     => 'capacity',
                    'value'   => 10,
                    'type'    => 'NUMERIC',
                    'compare' => '>='
                  ],
                  [
                    'key'     => 'capacity',
                    'value'   => 20,
                    'type'    => 'NUMERIC',
                    'compare' => '<='
                  ]
                ];
                break;
              case '20+':
                $capacity_conditions[] = [
                  'key'     => 'capacity',
                  'value'   => 20,
                  'type'    => 'NUMERIC',
                  'compare' => '>='
                ];
                break;
            }
          }
          if (!empty($capacity_conditions)) {
            $meta_query[] = array_merge(['relation' => 'OR'], $capacity_conditions);
          }
        }

        // ▼ 所要時間範囲フィルターの追加
        if (!empty($selected_time_ranges)) {
          $time_conditions = [];
          foreach ($selected_time_ranges as $range) {
            switch ($range) {
              case '0-60':
                $time_conditions[] = [
                  'key'     => 'time_required',
                  'value'   => 60,
                  'type'    => 'NUMERIC',
                  'compare' => '<='
                ];
                break;
              case '60-90':
                $time_conditions[] = [
                  'relation' => 'AND',
                  [
                    'key'     => 'time_required',
                    'value'   => 60,
                    'type'    => 'NUMERIC',
                    'compare' => '>='
                  ],
                  [
                    'key'     => 'time_required',
                    'value'   => 90,
                    'type'    => 'NUMERIC',
                    'compare' => '<='
                  ]
                ];
                break;
              case '90-120':
                $time_conditions[] = [
                  'relation' => 'AND',
                  [
                    'key'     => 'time_required',
                    'value'   => 90,
                    'type'    => 'NUMERIC',
                    'compare' => '>='
                  ],
                  [
                    'key'     => 'time_required',
                    'value'   => 120,
                    'type'    => 'NUMERIC',
                    'compare' => '<='
                  ]
                ];
                break;
              case '120-150':
                $time_conditions[] = [
                  'relation' => 'AND',
                  [
                    'key'     => 'time_required',
                    'value'   => 120,
                    'type'    => 'NUMERIC',
                    'compare' => '>='
                  ],
                  [
                    'key'     => 'time_required',
                    'value'   => 150,
                    'type'    => 'NUMERIC',
                    'compare' => '<='
                  ]
                ];
                break;
              case '150-180':
                $time_conditions[] = [
                  'relation' => 'AND',
                  [
                    'key'     => 'time_required',
                    'value'   => 150,
                    'type'    => 'NUMERIC',
                    'compare' => '>='
                  ],
                  [
                    'key'     => 'time_required',
                    'value'   => 180,
                    'type'    => 'NUMERIC',
                    'compare' => '<='
                  ]
                ];
                break;
              case '180+':
                $time_conditions[] = [
                  'key'     => 'time_required',
                  'value'   => 180,
                  'type'    => 'NUMERIC',
                  'compare' => '>='
                ];
                break;
            }
          }
          if (!empty($time_conditions)) {
            $meta_query[] = array_merge(['relation' => 'OR'], $time_conditions);
          }
        }

        if (!empty($meta_query)) {
          $args['meta_query'] = $meta_query;
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
            if ($english_supported) {
              $pagination_add_args['english_supported'] = $english_supported;
            }
            if ($kid_friendly) {
              $pagination_add_args['kid_friendly'] = $kid_friendly;
            }
            if ($group_booking) {
              $pagination_add_args['group_booking'] = $group_booking;
            }
            if ($search_keyword) {
              $pagination_add_args['s'] = $search_keyword;
            }
            if (!empty($selected_capacity_ranges)) {
              $pagination_add_args['capacity_range'] = $selected_capacity_ranges;
            }
            if (!empty($selected_time_ranges)) {
              $pagination_add_args['time_range'] = $selected_time_ranges;
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