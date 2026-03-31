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
    <style>
      * {
        margin: 0;
        padding: 0;
      }

      .box {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100vw;
        height: 100vh;
      }

      .status {
        font-size: 7vw;
        font-weight: bold;
        text-shadow: 0.2vw 0.2vw 0 #333;
      }
    </style>
    <div class="box">
      <p class="status">404</p>
      <p class="txt">ページが見つかりませんでした。</p>
    </div>
  </main>

  <?php get_footer(); ?>
</body>

</html>