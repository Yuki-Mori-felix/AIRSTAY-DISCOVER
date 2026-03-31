<?php
/* Template Name: 編集者TOPページ */

require_once get_template_directory() . '/inc/access-control.php';

get_header();
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
    <section style="min-height: 100dvh;">
      <div class="wrap">
        <div class="editor-home">
          <h2 class="page-title">投稿を作成する</h2>

          <p class="editor-home-text">作成したい投稿の種類を選択してください。</p>

          <div class="select-post-type">
            <!-- <div class="post-type">
            <a href="<?php echo home_url('/create-top'); ?>">TOPページを編集</a>
          </div> -->
            <div class="post-type">
              <a href="<?php echo home_url('/create-event'); ?>">イベント情報を作成</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    
  </main>

  <?php get_footer(); ?>
</body>

</html>