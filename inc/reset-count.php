<?php
// ▼ カウントリセット処理
if (isset($_GET['reset']) && $_GET['reset'] === '1') {

  // 全 event 投稿を取得
  $events = get_posts([
    'post_type'      => 'event',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
  ]);

  foreach ($events as $event) {
    update_post_meta($event->ID, 'event_reservation_count', 0);
  }

  // 完了メッセージを表示するためのフラグ
  $reset_done = true;
}
