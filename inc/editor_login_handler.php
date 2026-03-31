<?php
// 編集者権限ログイン処理

if (is_user_logged_in()) {
  // すでにログイン済みならリダイレクト
  wp_redirect(home_url('/editor-home/'));
  exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $creds = [
    'user_login'    => sanitize_text_field($_POST['username']),
    'user_password' => sanitize_text_field($_POST['password']),
    'remember'      => true
  ];

  $user = wp_signon($creds, false);

  if (is_wp_error($user)) {
    $error = 'ログインに失敗しました。ユーザー名またはパスワードが違います。';
  } else {

    // 編集者 or 管理者以外はログアウトさせる
    if (!in_array($user->roles[0], ['editor', 'administrator'], true)) {
      wp_logout();
      $error = 'このページからログインできるのは編集者のみです。';
    } else {
      // ログイン成功 → 任意のページへ
      wp_redirect(home_url('/editor-home/'));
      exit;
    }
  }
}