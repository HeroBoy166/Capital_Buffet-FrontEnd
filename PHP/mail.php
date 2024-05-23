<?php
        $abs_path = explode("/",str_replace("\\", "/",__DIR__));
        $max = sizeof($abs_path);
        $max--;
        $include = "";
        for($i = 0; $i <= $max; $i++)
        {
        $include .= $abs_path[$i] . "/";
        }
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;

include 'PHPMailer/src/Exception.php';
include 'PHPMailer/src/PHPMailer.php';
include 'PHPMailer/src/SMTP.php';

function gmail($subject, $message){
  $mail = new PHPMailer(true);
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = "urgensoyer@gmail.com";
  $mail->Password = 'tejwsspuyundgkrf';
  $mail->SMTPSecure = 'ssl';

  $mail->Port=465;

  $mail->setFrom('urgensoyer@gmail.com');

  $mail->addAddress ("dagvjr@gmail.com");
  $mail->isHTML(true);

  $mail->Subject = $subject;
  $mail->Body = $message;

  $mail->send();

 }