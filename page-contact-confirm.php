<?php
/* Template Name: お問い合わせ(確認) */
session_start();
include TEMPLATEPATH . '/inc/my_variables.php';
require_once TEMPLATEPATH . '/inc/mail-contact.php';
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
          <p class="form-headText">Please confirm the details below before submitting.</p>

          <form action="" class="confirm" method="POST">

            <div class="confirm-top-part">

              <div class="form-type-title">Event Name</div>
              <div class="confirm-box">
                <p class="confirm-heading"><?= esc_html($fpost['event_title']); ?></p>
              </div>

              <div class="form-type-title">Customer Information</div>
              <div class="confirm-box">
                <p class="confirm-heading">Full Name<span class="red">※</span></p>
                <p class="confirm-body"><?= $fpost['full_name'] ?></p>
              </div>
              <div class="confirm-box">
                <p class="confirm-heading">Phone Number<span class="red">※</span></p>
                <p class="confirm-body"><?= $fpost['tel_num'] ?></p>
              </div>
              <div class="confirm-box">
                <p class="confirm-heading">Email Address<span class="red">※</span></p>
                <p class="confirm-body"><?= $fpost['email'] ?></p>
              </div>

              <div class="confirm-box">
                <p class="confirm-heading">Inquiry Details</p>
                <div class="confirm-body"><?= nl2br($fpost['msg']) ?></div>
              </div>
<!-- 
              <div class="form-type-title">Handling of Personal Information</div>
              <div class="confirm-box">
                <p class="confirm-heading">I agree to the handling of personal information<span class="red">※</span></p>
                <p class="confirm-body"><?= $fpost['privacy_agree'] ?></p>
              </div> -->

            </div>

            <?php if (!empty($_SESSION['event_id'])): ?>
              <input type="hidden" name="event_id" value="<?= esc_attr($_SESSION['event_id']); ?>">
            <?php endif; ?>

            <input type="hidden" name="event_title" value="<?= esc_attr($fpost['event_title']); ?>">

            <div class="confirm-submit-box">
              <a href="<?= $home_url ?>/contact/" class="confirm-modify">Go Back</a>
              <button class="confirm-submit" type="submit">Submit</button>
            </div>

          </form>
        </div>
      </div>
    </section>

    <?php get_footer(); ?>
  </main>
  <?php wp_footer() ?>
</body>

</html>