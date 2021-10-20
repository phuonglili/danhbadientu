
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com;';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'vuphuong552k1@gmail.com';
    $mail->Password   = 'phuong05@';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;
    $mail->CharSet  = "utf-8";
    $mail->setFrom('vuphuong552k1@gmail.com', 'DHTL');
    $mail->addReplyTo('vuphuong552k1@gmail.com', 'DHTL');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Xác thực tài khoản Danh bạ DHTL';
    $mail->Body    = '<p>Xin chào<b> ' . $firstName . ',</b></p>';
    $mail->Body .= '<p>Bạn đã đăng ký tài khoản thành công, để xác thực tài khoản, bạn vui lòng nhấp vào đường link dưới đây:</p>';
    $mail->Body .= '<a href="http://localhost:3000/danhba/activation.php?accout=' . $email . '&code=' . $activationCode . '">Click here</a>';
    $mail->AltBody = 'Body in plain text for non-HTML mail clients';
    $mail->send();
    echo "Mail has been sent successfully!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>