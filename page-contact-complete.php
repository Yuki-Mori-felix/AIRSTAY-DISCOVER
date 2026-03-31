<?php
/* Template Name: お問い合わせ(完了) */
include TEMPLATEPATH . '/inc/my_variables.php';
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <?php get_header(); ?>
</head>

<body>
  <?php get_template_part('partials/parts', 'header'); ?>
  <!--================= END OF HEADER ===============-->
  <main>


    <section class="sec sec-contact">
      <div class="wrap contact-wrap">
        <h2 class="page-title">Application Form</h2>
        <div class="form-area">
          <div class="complete">
            <h2 class="complete-title">Your application has been successfully submitted.</h2>
            <p class="complete-txt">
              Thank you for your reservation.<br>
              Thank you for your reservation. We will contact you shortly with further details.
            </p>
            <a href="<?= $home_url; ?>/" class="common-button"><span class="text">TOP</span></a>
          </div>
        </div>
      </div>
    </section>

    <?php get_footer(); ?>
  </main>
  <?php wp_footer() ?>
</body>

</html>