<?php
/* Template Name: 検索結果ページ */
require TEMPLATEPATH . '/inc/my_variables.php';
$keyword = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
$post_type = 'event';

$args = [
  'post_type' => $post_type,
  's'         => $keyword,
  'posts_per_page' => -1,
];

$query = new WP_Query($args);
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

        <?php if ($query->have_posts()): ?>
          <ul class="event-list">
            <?php while ($query->have_posts()): $query->the_post(); ?>
              <li>
                <a href="<?php the_permalink(); ?>">■<?php the_title(); ?></a>
              </li>
            <?php endwhile; ?>
          </ul>
        <?php else: ?>
          <p>該当するイベントはありませんでした。</p>
        <?php endif; ?>

        <a href="<?= $home_url ?>" class="back-button">戻る</a>
      </div>
    </section>


    <?php get_footer(); ?>
  </main>
  <?php wp_footer() ?>

</body>

</html>