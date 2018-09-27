<?php

use PHPMailer\PHPMailer\PHPMailer;


require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';


$mail = new PHPMailer();

//$mail->IsSMTP();  // telling the class to use SMTP
$mail->Mailer = "smtp";
$mail->SMTPDebug = 1;
$mail->Host = "ssl://smtp.gmail.com"; // specify main and backup server
$mail->Port = 465; // set the port to use
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->SMTPSecure = 'ssl';                          // SMTP password


$mail->Username = "jihenazzouz@gmail.com"; // SMTP username
$mail->Password = "allahuakbar@1395"; // SMTP password

$mail->SetFrom("workspace.noreply@gmail.com");
$mail->Subject = "Reset password";
$mail->AddAddress($_POST["email"]);

$mail->IsHTML(true);

$email=$_POST['email'];
$code=str_random(6);
$addy = "http://localhost:63342/workspace/reset.php?id=$user[0]&token=$reset_token";
$mail->Body = "Hi! $user[0] \n\n To reset your password you need to click the link bellow <a href='$addy'>click here</a>\n use this code $code ";
$mail->WordWrap = 50;
$mail->smtpConnect(
    array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
            "allow_self_signed" => true
        )
    )
);

if (!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}