<?php
$reqst_post = ($_SERVER["REQUEST_METHOD"] === 'POST') ? true : false;

// データ送信時(submit) 一時保管
function restoreTxt($target, $slug)
{
  global $fpost;
  if (isset($_SESSION[$slug][$target])) {
    return htmlspecialchars($_SESSION[$slug][$target]);
  } elseif (isset($fpost[$target])) {
    return htmlspecialchars($fpost[$target]);
  } else {
    return '';
  }
}

// ラジオボタンの選択状態を復元する関数
function restoreRadio($target, $value, $slug)
{
  global $fpost;
  if (isset($_SESSION[$slug]) && $_SESSION[$slug][$target] == $value) {
    return 'checked';
  } elseif (isset($fpost[$target]) && $fpost[$target] == $value) {
    return 'checked';
  } else {
    return '';
  }
}

// チェックボックスの選択状態を復元する関数
function restoreCheckbox($target, $value, $slug)
{
  global $fpost;
  if (isset($_SESSION[$slug]) && in_array($value, $_SESSION[$slug][$target])) {
    return 'checked';
  } elseif (isset($fpost[$target]) && in_array($value, $fpost[$target])) {
    return 'checked';
  } else {
    return '';
  }
}

// セレクトボックスの値を復元する関数
function restoreSelect($target, $slug, $value)
{
  global $fpost;
  if (isset($_SESSION[$slug]) && $_SESSION[$slug][$target] == $value) {
    return 'selected';
  } elseif (isset($fpost[$target]) && $fpost[$target] == $value) {
    return 'selected';
  } else {
    return '';
  }
}

// エーラーメッセージ生成
function createErrMsg($ipt_name)
{
  global $err;
  if (isset($err[$ipt_name])) {
?>

    <p class="msg-err"><?= $err[$ipt_name] ?></p>

<?php
  }
}


if (is_page('contact')) {
  if ($reqst_post) {
    $err = [];
    $fpost = $_POST;

    if (empty($fpost['full_name'])) {
      $err['full_name'] = 'Please enter your full name.';
    }

    if (empty($fpost['tel_num'])) {
      $err['tel_num'] = 'Please enter your phone number.';
    }

    if (empty($fpost['email'])) {
      $err['email'] = 'Please enter your email address.';
    } elseif (!filter_var($fpost['email'], FILTER_VALIDATE_EMAIL)) {
      $err['email'] = 'Please enter a valid email address.';
    }

    if (empty($fpost['msg'])) {
      $err['msg'] = 'Please enter your inquiry details.';
    }

    if (empty($fpost['privacy_agree'])) {
      $err['privacy_agree'] = 'You must agree to the handling of personal information to proceed.';
      $err2['privacy_agree'] = ' ';
    }

    if (empty($err)) {
      $_SESSION['contact'] = $fpost;
      wp_redirect(home_url('/contact/confirm/'));
      exit;
    }
  }
} elseif (is_page('confirm')) {
  // URLでの不正アクセスリダイレクト
  if (empty($_SESSION['contact'])) wp_redirect(home_url('/contact/'));

  $fpost = $_SESSION['contact'];

  if (!empty($_SESSION['event_id'])) {
    $fpost['event_id'] = $_SESSION['event_id'];
  }

  if (!empty($_SESSION['event_title'])) {
    $fpost['event_title'] = $_SESSION['event_title'];
  }


  if ($reqst_post) {
    // メール送信 -- phpmailer読み込み
    require_once TEMPLATEPATH . '/inc/class.phpmailer.php';

    // メール送信 -- 環境設定
    date_default_timezone_set('Asia/Tokyo');
    mb_language("ja");
    mb_internal_encoding("UTF-8");

    // メール送信 -- 宛先
    $to = [
      'manager' => 'mori@felixjapan.net',
      'user' => $fpost['email'],
      'dev' => 'mori@felixjapan.net',
    ];
    $header = 'From: mori@felixjapan.net';

    // メール送信 -- 件名
    $subject = [
      'manager' => 'お客様からお問い合わせメールを受信しました（自動返信メール）| AIRSTAY DISCOVER',
      'user' => 'Your Inquiry Has Been Received (Auto-Reply) | AIRSTAY DISCOVER',
    ];

    // メール送信 -- 本文
    $body = [];

    $body['manager'] =
      'お客様からお問い合わせメールを受信しました' . "\n\n\n" .
      '-------お問い合わせ内容------------------------------------------' . "\n\n" .
      '申し込みイベント：' . htmlspecialchars($fpost['event_title'], ENT_QUOTES, 'UTF-8') . "\n" .
      '受付日時：' . htmlspecialchars(date("Y年m月d日 H:i"), ENT_QUOTES, 'UTF-8') . "\n" .
      '氏名：' . htmlspecialchars($fpost['full_name'], ENT_QUOTES, 'UTF-8') . "\n" .
      '電話番号：' . htmlspecialchars($fpost['tel_num'], ENT_QUOTES, 'UTF-8') . "\n" .
      'メールアドレス：' . htmlspecialchars($fpost['email'], ENT_QUOTES, 'UTF-8') . "\n" .
      'お問い合わせ内容：' . "\n" . htmlspecialchars($fpost['msg'], ENT_QUOTES, 'UTF-8') . "\n" .
      '---------------------------------------------------------------' . "\n\n" .
      'AIRSTAY DISCOVER' . "\n";

    $body['user'] =
      "This email is an automated system response.\n" .
      "Please note that we are unable to accept replies to this message.\n\n" .
      "Thank you very much for your inquiry.\n" .
      "We have received your inquiry as detailed below.\n\n" .
      "A representative will contact you shortly.\n" .
      "We sincerely apologize for any inconvenience and kindly ask for your patience as we process your request.\n\n\n" .
      '-------Inquiry Details--------------------------------------------' . "\n\n" .
      // 'Applied Event：' . htmlspecialchars($fpost['event_title'], ENT_QUOTES, 'UTF-8') . "\n" .
      'Received Date and Time: ' . htmlspecialchars(date("F d, Y"), ENT_QUOTES, 'UTF-8') . "\n" .
      'Full Name：' . htmlspecialchars($fpost['full_name'], ENT_QUOTES, 'UTF-8') . "\n" .
      'Phone Number：' . htmlspecialchars($fpost['tel_num'], ENT_QUOTES, 'UTF-8') . "\n" .
      'Email Address：' . htmlspecialchars($fpost['email'], ENT_QUOTES, 'UTF-8') . "\n" .
      'Inquiry Details：' . "\n" . htmlspecialchars($fpost['msg'], ENT_QUOTES, 'UTF-8') . "\n" .
      '-----------------------------------------------------------------' . "\n\n" .
      'AIRSTAY DISCOVER' . "\n";

    // メール送信 -- 管理者通知
    try {
      $mail = new PHPMailer(true);
      $mail->CharSet = "UTF-8";
      // $mail->IsSendmail();
      $mail->AddReplyTo('mori@felixjapan.net', 'AIRSTAY DISCOVER');
      $mail->From = 'mori@felixjapan.net';
      $mail->FromName   = 'AIRSTAY DISCOVER';
      $mail->AddAddress($to['dev']);
      $mail->Subject  = $subject['manager'];
      $mail->Body = $body['manager'];
      $mail->Send();
    } catch (phpmailerException $e) {
      echo $e->errorMessage();
    }

    // メール送信 -- ユーザーリプライ
    try {
      $mail = new PHPMailer(true);
      $mail->CharSet = "UTF-8";
      // $mail->IsSendmail();
      $mail->AddReplyTo('mori@felixjapan.net', 'AIRSTAY DISCOVER');
      $mail->From = 'mori@felixjapan.net';
      $mail->FromName   = 'AIRSTAY DISCOVER';
      $mail->AddAddress($to['user']);
      $mail->Subject  = $subject['user'];
      $mail->Body = $body['user'];
      $mail->Send();
    } catch (phpmailerException $e) {
      echo $e->errorMessage();
    }

    // ▼▼▼ 予約カウント処理（イベント投稿に紐づけ）
    if (!empty($fpost['event_id'])) {
      $event_id = intval($fpost['event_id']);

      // 現在のカウントを取得
      $count = get_post_meta($event_id, 'event_reservation_count', true);
      if (!$count) $count = 0;

      // カウントを +1
      update_post_meta($event_id, 'event_reservation_count', $count + 1);
    }


    // セッション終了
    session_unset();
    session_destroy();
    wp_redirect(home_url('/contact/complete/?submitted=complete'));
  }
} elseif (is_page('complete')) {
  if (empty($_GET['submitted'])) wp_redirect(home_url('/contact/'));
}
