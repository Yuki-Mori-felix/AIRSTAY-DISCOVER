<?php
require TEMPLATEPATH . '/inc/my_variables.php';
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php get_header(); ?>
</head>

<body class="home">
  <?php get_template_part('partials/parts', 'header'); ?>
  <!--================= END OF HEADER ===============-->
  <main>

    <section class="sec-mv">
      <div class="splide splide-mv" aria-label="Splideの基本的なHTML">
        <div class="splide__track">
          <ul class="splide__list">
            <li class="splide__slide"><img src="<?= $img_path ?>/top/mv1.webp" alt=""></li>
            <li class="splide__slide"><img src="<?= $img_path ?>/top/mv2.webp" alt=""></li>
            <li class="splide__slide"><img src="<?= $img_path ?>/top/mv3.webp" alt=""></li>
          </ul>
        </div>
      </div>
      <div class="part-search">
        <div class="part-search-wrap">
          <h1>DISCOVER THE HEART <br class="sp-visible">OF JAPAN</h1>
          <p>Immerse yourself in authentic rituals <br class="sp-visible">and local crafts.</p>
          <form method="get" action="/">
            <div class="search-box">
              <input type="text" id="event_search" name="s" placeholder="Search activities and destinations" required>
              <input type="hidden" name="post_type" value="event">
              <button type="submit">search</button>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!--========================= END OF MV =========================-->

    <section class="sec-categories">
      <div class="wrap">
        <h2 class="sec-title">Popular Categories</h2>
        <ul class="category-list">
          <li class="category-item">
            <a href="<?= $home_url; ?>/event/?filter_type%5B%5D=10&sort=new">
              <img class="category-img" src="<?= $img_path; ?>/test/category.png" alt="">
              <div class="category-name">Adventure & Sports</div>
            </a>
          </li>
          <li class="category-item">
            <a href="<?= $home_url; ?>/event/?filter_type%5B%5D=19&sort=new">
              <img class="category-img" src="<?= $img_path; ?>/test/category-02.png" alt="">
              <div class="category-name">History & Architecture</div>
            </a>
          </li>
          <li class="category-item">
            <a href="<?= $home_url; ?>/event/?filter_type%5B%5D=20&sort=new">
              <img class="category-img" src="<?= $img_path; ?>/test/category-03.png" alt="">
              <div class="category-name">Nature & Outdoors</div>
            </a>
          </li>
          <li class="category-item">
            <a href="<?= $home_url; ?>/event/?filter_type%5B%5D=21&sort=new">
              <img class="category-img" src="<?= $img_path; ?>/test/category-04.png" alt="">
              <div class="category-name">Art & Craftsmanship</div>
            </a>
          </li>
          <li class="category-item">
            <a href="<?= $home_url; ?>/event/?filter_type%5B%5D=22&sort=new">
              <img class="category-img" src="<?= $img_path; ?>/test/category-05.png" alt="">
              <div class="category-name">Eat & Drink Authentic</div>
            </a>
          </li>
          <li class="category-item">
            <a href="<?= $home_url; ?>/event/?filter_type%5B%5D=23&sort=new">
              <img class="category-img" src="<?= $img_path; ?>/test/category-06.png" alt="">
              <div class="category-name">Local Lifestyle & Etiquette</div>
            </a>
          </li>
        </ul>
      </div>
    </section>
    <!--========================= END OF CATEGORIES =========================-->

    <section style="display: none;" class="sec-areas">
      <div class="areas-back">
        <div class="wrap">
          <h2 class="sec-title">Popular Areas</h2>
          <ul class="area-list">
            <li class="area-item">
              <a href="<?= $home_url ?>?s=tokyo">
                <img src="<?= $img_path; ?>/test/area.png" alt="">
                <p>東京</p>
              </a>
            </li>
            <li class="area-item">
              <a href="<?= $home_url ?>?s=kyoto">
                <img src="<?= $img_path; ?>/test/area-02.png" alt="">
                <p>京都</p>
              </a>
            </li>
            <li class="area-item">
              <a href="<?= $home_url ?>?s=osaka">
                <img src="<?= $img_path; ?>/test/area-03.png" alt="">
                <p>大阪</p>
              </a>
            </li>
            <li class="area-item">
              <a href="<?= $home_url ?>?s=hokkaido">
                <img src="<?= $img_path; ?>/test/area-04.png" alt="">
                <p>北海道</p>
              </a>
            </li>
            <li class="area-item">
              <a href="<?= $home_url ?>?s=kanagawa">
                <img src="<?= $img_path; ?>/test/area-05.png" alt="">
                <p>神奈川</p>
              </a>
            </li>
            <li class="area-item">
              <a href="<?= $home_url ?>?s=hiroshima">
                <img src="<?= $img_path; ?>/test/area-06.png" alt="">
                <p>広島</p>
              </a>
            </li>
            <li class="area-item">
              <a href="<?= $home_url ?>?s=fukuoka">
                <img src="<?= $img_path; ?>/test/area-07.png" alt="">
                <p>福岡</p>
              </a>
            </li>
            <li class="area-item">
              <a href="<?= $home_url ?>?s=okinawa">
                <img src="<?= $img_path; ?>/test/area-08.png" alt="">
                <p>沖縄</p>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </section>
    <!--========================= END OF AREAS =========================-->

    <section class="sec-experiences">
      <div class="wrap">
        <h2 class="sec-title">Featured Experiences</h2>
        <div class="splide splide-event">
          <div class="splide-wrapper">
            <div class="splide__arrows">
              <button class="splide__arrow splide__arrow--prev">
                <img src="<?= $img_path ?>/arrow-p.png" alt="">
              </button>
              <button class="splide__arrow splide__arrow--next">
                <img src="<?= $img_path ?>/arrow-n.png" alt="">
              </button>
            </div>
            <div class="splide__track">
              <ul class="splide__list">
                <?php
                // ▼ event 投稿専用サブループ
                $args = array(
                  'post_type'      => 'event',
                  'posts_per_page' => 6,
                  'orderby'        => 'rand',
                  'order'          => 'DESC',
                  'meta_key'   => 'featured_experience',
                  'meta_value' => 1,
                );
                $event_query = new WP_Query($args);
                ?>

                <?php if ($event_query->have_posts()): ?>
                  <?php while ($event_query->have_posts()): ?>
                    <?php $event_query->the_post(); ?>

                    <li class="splide__slide">

                      <a href="<?php the_permalink(); ?>" class="post-link">

                        <?php
                        // ▼ メイン画像
                        $img_id  = get_post_meta(get_the_ID(), 'event_img', true);
                        $img_url = wp_get_attachment_url($img_id);
                        ?>

                        <?php if ($img_id): ?>
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
                        ?>

                        <div class="list-textarea">
                          <?php if ($area_name || $type_name): ?>
                            <div class="event-taxonomy">
                              <?php echo esc_html($area_name); ?>
                              <?php if ($area_name && $type_name) echo ' / '; ?>
                              <?php echo esc_html($type_name); ?>
                            </div>
                          <?php endif; ?>

                          <?php
                          $title = get_the_title();
                          $limit = 80;

                          if (mb_strlen($title) > $limit) {
                            $title = mb_substr($title, 0, $limit) . '...';
                          }

                          $event_text = get_field('event_text');
                          $text_limit = 200;

                          if (mb_strlen($event_text) > $text_limit) {
                            $event_text = mb_substr($event_text, 0, $text_limit) . '...';
                          }
                          ?>
                          <div class="list-title"><?= $title; ?></div>

                          <div class="list-text"><?= wp_kses($event_text, array('br' => array())); ?></div>

                          <div class="list-price"><?= the_field('event_price'); ?>JPY</div>
                        </div>

                      </a>

                    </li>

                  <?php endwhile; ?>
                <?php endif; ?>

                <?php wp_reset_postdata(); ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--========================= END OF EXPERIENCES =========================-->

    <section class="sec-arrivals">
      <div class="wrap">
        <h2 class="sec-title">New Arrivals</h2>

        <ul class="event-list">

          <?php
          // ▼ event 投稿専用サブループ
          $args = array(
            'post_type'      => 'event',
            'posts_per_page' => 6,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
          );
          $event_query = new WP_Query($args);
          ?>

          <?php if ($event_query->have_posts()): ?>
            <?php while ($event_query->have_posts()): ?>
              <?php $event_query->the_post(); ?>

              <li class="list-item">

                <a href="<?php the_permalink(); ?>" class="post-link">

                  <?php
                  // ▼ メイン画像
                  $img_id  = get_post_meta(get_the_ID(), 'event_img', true);
                  $img_url = wp_get_attachment_url($img_id);
                  ?>

                  <?php if ($img_id): ?>
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
                  ?>

                  <?php if ($area_name || $type_name): ?>
                    <div class="event-taxonomy">
                      <?php echo esc_html($area_name); ?>
                      <?php if ($area_name && $type_name) echo ' / '; ?>
                      <?php echo esc_html($type_name); ?>
                    </div>
                  <?php endif; ?>

                  <?php
                  $title = get_the_title();
                  $limit = 80;

                  if (mb_strlen($title) > $limit) {
                    $title = mb_substr($title, 0, $limit) . '...';
                  }

                  $event_text = get_field('event_text');
                  $text_limit = 200;

                  if (mb_strlen($event_text) > $text_limit) {
                    $event_text = mb_substr($event_text, 0, $text_limit) . '...';
                  }
                  ?>
                  <div class="list-title"><?= $title; ?></div>

                  <div class="list-text"><?= wp_kses($event_text, array('br' => array())); ?></div>

                  <div class="list-price"><?= the_field('event_price'); ?>JPY</div>

                </a>

              </li>

            <?php endwhile; ?>
          <?php endif; ?>

          <?php wp_reset_postdata(); ?>

        </ul>

        <a href="<?= $home_url ?>/event/" class="common-button">
          <p class="text">Explore All Experiences</p>
        </a>

      </div>
    </section>
    <!--========================= END OF ARRIVALS =========================-->

    <section class="sec-about">
      <div class="wrap">
        <h2 class="sec-title">What We Care About</h2>
        <ul class="about-list">
          <li class="about-item">
            <h3>Authentic Experiences, Carefully Curated</h3>
            <p>
              Not made for tourists — only real, rooted experiences that truly reflect the local culture. Every experience is delivered directly by local professionals.
            </p>
          </li>
          <li class="about-item">
            <h3>Authentic Experiences, Carefully Curated</h3>
            <p>
              Not made for tourists — only real, rooted experiences that truly reflect the local culture. Every experience is delivered directly by local professionals.
            </p>
          </li>
          <li class="about-item">
            <h3>Authentic Experiences, Carefully Curated</h3>
            <p>
              Not made for tourists — only real, rooted experiences that truly reflect the local culture. Every experience is delivered directly by local professionals.
            </p>
          </li>

        </ul>
      </div>
    </section>
    <!--========================= END OF ABOUT =========================-->

  </main>

  <?php get_footer(); ?>
</body>

</html>