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
    <section class="sec-event-list">
      <div class="wrap">
        <h2 class="page-title">Experiences</h2>

        <?php if (have_posts()): ?>
          <ul class="event-list">
            <?php while (have_posts()): the_post(); ?>
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
                  <div class="list-text"><?= the_field('event_text'); ?></div>
                  <div class="list-price"><?= the_field('event_price'); ?>JPY</div>
                </a>

                <?php get_template_part('partials/post-status', null, ['post_id' => get_the_ID()]); ?>

              </li>
            <?php endwhile; ?>
          </ul>
        <?php else: ?>
          <p>No experiences matched your search.</p>
        <?php endif; ?>

        <a href="<?= home_url(); ?>/experiences/" class="back-link">Back to All Experiences</a>
      </div>
    </section>
  </main>

  <?php get_footer(); ?>

</body>

</html>