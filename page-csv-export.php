<?php
/* Template Name: フォーム送信数 CSVエクスポート */
require TEMPLATEPATH . '/inc/my_variables.php';
require_once get_template_directory() . '/inc/access-control.php';
require_once get_template_directory() . '/inc/reset-count.php';
require_once get_template_directory() . '/inc/csv-download.php';
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
    <section class="sec-csv">
      <div class="wrap">
        <h2 class="page-title">体験予約 CSVエクスポート</h2>

        <p>各体験に対するフォーム送信数を CSV でダウンロードできます。</p>

        <?php if (!empty($reset_done)): ?>
          <p class="reset-message">
            全イベントの送信件数をリセットしました。
          </p>
        <?php endif; ?>

        <div class="button-area">
          <a href="?download=1" class="csv-button">CSVをダウンロード</a>
          <button id="reset-count-button">送信数をリセット</button>
        </div>

      </div>
    </section>
    <?php get_footer(); ?>
  </main>
  <?php wp_footer() ?>
  <script>
    document.getElementById('reset-count-button').addEventListener('click', function() {
      if (confirm('全イベントの送信数をリセットしますか？')) {
        window.location.href = '?reset=1';
      }
    });
  </script>
</body>

</html>