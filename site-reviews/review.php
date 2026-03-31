<?php defined('ABSPATH') || exit;
/**
 * @version 1.0.0
 */
?>
<div class="glsr-review" id="review-{{ review_id }}" data-assigned='{{ assigned }}'>
  {{ title }}
  {{ rating }} {{ date }}
  {{ assigned_links }}
  {{ content }}
  {{ avatar }}
  {{ author }} {{ verified }} {{ location }}
  {{ response }}
</div>

<?php
$review_id = $review->ID;

// ログインユーザーが投稿者、または管理者なら削除ボタン表示
if (is_user_logged_in()) {
  $user = wp_get_current_user();
  if ($user->ID == $review->user_id || current_user_can('administrator')) {
    $delete_url = add_query_arg([
      'delete_review' => $review_id,
      '_wpnonce'      => wp_create_nonce('delete_review_' . $review_id),
    ], home_url($_SERVER['REQUEST_URI']));
    echo '<a href="' . esc_url($delete_url) . '" class="review-delete-button">削除</a>';
  }
}
?>