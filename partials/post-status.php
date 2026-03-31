<?php
if (!is_user_logged_in()) return;

$post_id = $args['post_id'];
$status = get_post_status($post_id);

$nonce  = wp_create_nonce('toggle_status_' . $post_id);
$delete_nonce = wp_create_nonce('delete_post_' . $post_id);
?>

<div class="post-status">
  <div class="status-button-area">

    <!-- 公開/非公開切り替え -->
    <a class="status-button toggle-button <?= ($status === 'publish') ? 'to-private' : 'to-publish'; ?>"
      href="<?= home_url('/toggle-status'); ?>?action=toggle_status&id=<?= $post_id; ?>&nonce=<?= $nonce; ?>">
      <?= ($status === 'publish') ? '非公開にする' : '公開する'; ?>
    </a>

    <!-- 削除ボタン -->
    <a class="status-button delete-button"
      href="<?= home_url('/delete-post'); ?>?action=delete_post&id=<?= $post_id; ?>&nonce=<?= $delete_nonce; ?>"
      onclick="return confirm('本当に削除してもよろしいですか？この操作は元に戻せません。');">
      削除する
    </a>

  </div>
</div>
