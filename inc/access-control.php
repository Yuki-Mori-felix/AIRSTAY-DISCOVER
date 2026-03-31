<?php
// 非ログインユーザ リダイレクト処理
if (!current_user_can('editor') && !current_user_can('administrator')) {
  wp_redirect(home_url());
  exit;
}
