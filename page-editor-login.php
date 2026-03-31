<?php
/* 
Template Name: 編集者ログインページ
*/
require_once get_template_directory() . '/inc/editor_login_handler.php';
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <?php get_header(); ?>
</head>

<body>
  <?php get_template_part('partials/parts', 'header'); ?>
  <!--================= END OF HEADER ===============-->
  <main>

    <section class="sec-editor-login" style="min-height: 80vh;">
      <div class="wrap">
        <h2 class="page-title">編集者ログイン</h2>

        <?php if ($error): ?>
          <div class="login-error"><?= esc_html($error); ?></div>
        <?php endif; ?>

        <form method="post">
          <div class="form-item">
            <label>ユーザー名</label>
            <input type="text" name="username" required>
          </div>

          <div class="form-item">
            <label>パスワード</label>

            <div class="password-wrap">
              <input type="password" name="password" id="password-field" required>

              <button type="button" id="toggle-password">
                <i class="fa-solid fa-eye fa-lg"></i>
                <i class="fa-solid fa-eye-slash fa-lg"></i>
              </button>
            </div>
          </div>
          <button type="submit">ログイン</button>
        </form>
      </div>
    </section>

  </main>

  <?php get_footer(); ?>
</body>

</html>