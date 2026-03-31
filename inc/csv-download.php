<?php
// ▼ CSV ダウンロード処理
if (isset($_GET['download']) && $_GET['download'] === '1') {

  // ファイル名
  $filename = 'event_export_' . date('Ymd') . '.csv';

  // CSV 出力ヘッダー
  header('Content-Type: text/csv; charset=UTF-8');
  header('Content-Disposition: attachment; filename=' . $filename);

  // 出力バッファを開く
  $output = fopen('php://output', 'w');

  // Excel で文字化けしないよう BOM を付与
  fwrite($output, "\xEF\xBB\xBF");

  // ▼ 1行目（ヘッダー）
  fputcsv($output, ['体験名', '申し込み数']);

  // ▼ event 投稿を全件取得
  $events = get_posts([
    'post_type'      => 'event',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
  ]);

  foreach ($events as $event) {

    // 送信数（post_meta）
    $count = get_post_meta($event->ID, 'event_reservation_count', true);
    if (!$count) $count = 0;

    // ▼ CSV 1行分
    fputcsv($output, [
      $event->post_title,
      $count
    ]);
  }

  fclose($output);
  exit;
}
