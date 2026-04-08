<?php
include TEMPLATEPATH . '/inc/my_variables.php';
?>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Favicon and Icons -->
<link rel="icon" href="<?= $img_path ?>/favicon.ico" type="image/x-icon">
<link rel="apple-touch-icon" href="<?= $img_path ?>/apple-touch-icon.png">
<link rel="icon" sizes="192x192" href="<?= $img_path ?>/android-chrome-192×192.png">
<!-- Open Graph Image -->
<meta property="og:url" content="https://airstay.jp/">
<meta property="og:site_name" content="AIRSTAY DISCOVER">
<meta property="og:title" content="AiRSTAY DISCOVER | Immerse yourself in authentic rituals and local crafts.">
<meta property="og:type" content="website">
<meta property="og:image" content="<?= $img_path ?>/ogp.png">
<meta name="twitter:image" content="<?= $img_path ?>/ogp.png">
<title>
  <?php if(is_post_type_archive('event')): ?>
    AIRSTAY DISCOVER | Experiences
  <?php elseif (is_singular('event')): ?>
    AIRSTAY DISCOVER | <?= esc_html(get_the_title()); ?>
  <?php else: ?>
    AIRSTAY DISCOVER
  <?php endif; ?>
</title>
<meta name="keywords" content="AIRSTAY, DISCOVER, experiences, events, booking, travel">
<meta name="description" content="AIRSTAY DISCOVER - Discover unique experiences and events with AIRSTAY. Book your next adventure today.">
<!-- Google Fonts 読み込み -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<!-- Google Fonts 読み込み -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css?v=<?php echo filemtime(get_template_directory() . '/css/style.css'); ?>">
<!-- Splide -->
<link rel="stylesheet" href="<?= $theme_path ?>/lib/splide/splide.min.css">
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js"></script>
<script src="<?= $theme_path ?>/lib/splide/splide.min.js"></script>
<!-- Splide -->
<?php if (is_front_page()): ?>
<?php elseif (is_page('create-event') || is_page('editor-home')): ?>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/create-post.css?v=<?php echo filemtime(get_template_directory() . '/css/create-post.css'); ?>">
<?php elseif (is_page('editor-login')): ?>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/page-editor-login.css?v=<?php echo filemtime(get_template_directory() . '/css/page-editor-login.css'); ?>">
<?php elseif (is_page('contact') || is_page('confirm') || is_page('complete')): ?>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/page-contact.css?v=<?php echo filemtime(get_template_directory() . '/css/page-contact.css'); ?>">
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<?php elseif (is_singular('event')): ?>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/single-event.css?v=<?php echo filemtime(get_template_directory() . '/css/single-event.css'); ?>">
<?php elseif (is_page('csv-export')): ?>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/page-csv-export.css?v=<?php echo filemtime(get_template_directory() . '/css/page-csv-export.css'); ?>">
<?php endif; ?>

<!-- <link rel="icon" href="/favicon.ico"> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php wp_head() ?>