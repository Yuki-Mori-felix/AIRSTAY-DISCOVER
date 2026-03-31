<?php
/* Template Name: お問い合わせ */
session_start();
if (!empty($_GET['event_id'])) {
  $_SESSION['event_id'] = intval($_GET['event_id']);
}
if (!empty($_GET['event_title'])) {
  $_SESSION['event_title'] = sanitize_text_field($_GET['event_title']);
}

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
    <?php my_breadcrumb(); ?>

    <section class="sec sec-contact">
      <div class="wrap contact-wrap">
        <h2 class="page-title">Application Form</h2>
        <div class="form-area">

          <p class="form-headText">
            Please fill in the required information in the fields below, then click the “Confirm” button.<br>
            <span class="red">※</span> is a required field.
          </p>

          <form action="" class="form h-adr" method="POST" autocomplete="off" novalidate>
            <span class="p-country-name" style="display:none;">Japan</span>
            <div class="form-top-part">

              <?php if (!empty($_SESSION['event_title'])): ?>
                <div class="form-type-title">Event Name</div>
                <div class="form-box">
                  <div class="form-label-box">
                    <label class="form-label">
                      <span class="form-label-ja">
                        <?= esc_html($_SESSION['event_title']); ?>
                      </span>
                    </label>
                  </div>
                </div>
              <?php endif; ?>

              <div class="form-type-title">Customer Information</div>
              <div class="form-box full_name">
                <div class="form-label-box">
                  <label for="full_name" class="form-label">
                    <span class="form-label-ja">Full Name <span class="red">※</span></span>
                  </label>
                </div>
                <div class="form-ipt-box">
                  <input id="full_name" type="text" class="form-ipt" name="full_name" value="<?= restoreTxt('full_name', 'contact') ?>">
                  <?= createErrMsg('full_name') ?>
                </div>
              </div>

              <div class="form-box tel_num">
                <div class="form-label-box">
                  <label for="tel_num" class="form-label">
                    <span class="form-label-ja">Phone Number <span class="red">※</span></span>
                  </label>
                </div>
                <div class="form-ipt-box">
                  <input id="tel_num" type="tel" class="form-ipt form-ipt-tel" name="tel_num" value="<?= restoreTxt('tel_num', 'contact') ?>">
                  <?= createErrMsg('tel_num') ?>
                </div>
              </div>

              <div class="form-box email">
                <div class="form-label-box">
                  <label for="email" class="form-label">
                    <span class="form-label-ja">Email Address <span class="red">※</span></span>
                  </label>
                </div>
                <div class="form-ipt-box">
                  <input id="email" type="text" class="form-ipt" name="email" value="<?= restoreTxt('email', 'contact') ?>">
                  <?= createErrMsg('email') ?>
                </div>
              </div>

            </div>

            <div class="form-middle-part">

              <div class="form-box msg">
                <div class="form-label-box">
                  <label for="msg" class="form-label">
                    <span class="form-label-ja">Inquiry Details</span>
                  </label>
                </div>
                <div class="form-ipt-box">
                  <textarea id="msg" type="text" class="form-ipt" name="msg" rows="15"><?= restoreTxt('msg', 'contact') ?></textarea>
                  <?= createErrMsg('msg') ?>
                </div>
              </div>

            </div>

            <div class="form-privacy">
              <div class="form-type-title">Handling of Personal Information</div>

              <div class="form-box">
                <div class="form-label-box">
                  <label for="privacy_agree" class="form-label">
                    <span class="form-label-ja">I agree to the handling of personal information <span class="red">※</span></span>
                  </label>
                </div>
                <div class="form-privacy-check">
                  <div class="privacy-textArea">
                    ダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキスト
                  </div>
                  <label for="privacy_agree">
                    <input id="privacy_agree" type="checkbox" name="privacy_agree" class="check-box" value="I Agree">
                    <span class="txt"><span class="ja">I Agree</span></span>
                  </label>
                  <?= createErrMsg('privacy_agree') ?>
                </div>
              </div>
            </div>


            <?php if (!empty($_SESSION['event_title'])): ?>
              <input type="hidden" name="event_title" value="<?= esc_attr($_SESSION['event_title']); ?>">
            <?php endif; ?>

            <!-- 送信数カウント用 -->
            <?php if (!empty($_SESSION['event_id'])): ?>
              <input type="hidden" name="event_id" value="<?= esc_attr($_SESSION['event_id']); ?>">
            <?php endif; ?>


            <div class="form-submit-box">
              <button class="form-submit" type="submit">Confirm</button>
            </div>
          </form>

        </div>
      </div>
    </section>

    <?php get_footer(); ?>
  </main>

  <?php wp_footer() ?>
  <script>
    const phoneInputField = document.querySelector("#tel_num");
    const phoneInput = window.intlTelInput(phoneInputField, {
      initialCountry: "us", // デフォルトで表示する国
      preferredCountries: ["us", "cn", "kr", "tw", "hk", "au"], // 優先表示の国
      utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });
  </script>
</body>

</html>