<?php
include TEMPLATEPATH . '/inc/my_variables.php';
?>
<script src="<?= get_template_directory_uri(); ?>/js/script.js?v=<?= filemtime(get_template_directory() . '/js/script.js'); ?>"></script>
<?php if (is_front_page()): ?>
  <script src="<?= get_template_directory_uri(); ?>/js/front-page.js?v=<?= filemtime(get_template_directory() . '/js/front-page.js'); ?>"></script>
<?php elseif (is_archive("event")): ?>
  <script src="<?php echo get_template_directory_uri(); ?>/js/archive-event.js"></script>
<?php elseif (is_singular("event") || is_page("create-event")): ?>
  <script src="<?= get_template_directory_uri(); ?>/js/single-event.js?v=<?= filemtime(get_template_directory() . '/js/single-event.js'); ?>"></script>
<?php endif; ?>
<footer>
  <div class="footer-wrap wrap">
    <div class="footer-logo">AIRSTAY <br class="sp-visible">DISCOVER</div>
    <ul class="footer-list">
      <li class="footer-item">
        <a href="<?= $home_url ?>/">Home</a>
      </li>
      <li class="footer-item">
        <a href="<?= $home_url ?>/experiences/">Experiences</a>
      </li>
      <!-- <li class="footer-item">
        <a href="">Operating Company</a>
      </li>
      <li class="footer-item">
        <a href="">Contact</a>
      </li>
      <li class="footer-item">
        <a href="">Privacy Policy</a>
      </li>
      <li class="footer-item">
        <a href="">Terms of Service</a>
      </li>
      <li class="footer-item">
        <a href=""><img src="<?= $img_path ?>/insta.png" alt=""></a>
      </li> -->
    </ul>
  </div>
  <div class="copy-right">
    <div class="wrap">
      <p>© AIRSTAY. All Rights Reserved.</p>
    </div>
  </div>
</footer>

<div class="create-buttons">
  <?php if (current_user_can('editor') || current_user_can('administrator')): ?>
    <a class="create-button" href="<?= $home_url ?>/create-event/">イベント情報を作成</a>
  <?php endif; ?>
  <?php if (current_user_can('editor') || current_user_can('administrator')): ?>
    <a class="create-button" href="<?= $home_url ?>/experiences/">イベント一覧ページ</a>
  <?php endif; ?>
  <?php if (current_user_can('editor')): ?>
    <a href="<?php echo wp_logout_url(home_url('editor-login')); ?>" class="logout-button">ログアウト</a>
  <?php endif; ?>
</div>
<?php wp_footer(); ?>