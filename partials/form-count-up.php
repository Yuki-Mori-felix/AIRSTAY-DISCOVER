<?php
if (!is_user_logged_in()) return;
$count = get_post_meta(get_the_ID(), 'event_reservation_count', true);
if (!$count) $count = 0;
?>
<div class="count-area">
  <div class="count-title">フォーム送信数：</div>
  <div class="count-text"><?php echo $count; ?> 件</div>
</div>