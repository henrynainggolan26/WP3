<?php
include('phpmailer/class.phpmailer.php');
$mail = new PHPMailer();
//$mail->IsSMTP(); // telling the class to use SMTP
//$mail->Host = "localhost"; // SMTP server
//IsSMTP(); // send via SMTP
$mail->Host     = "ssl://smtp.gmail.com"; // SMTP server Gmail
$mail->Mailer   = "smtp";
$mail->SMTPAuth = true; // turn on SMTP authentication

$mail->Username = "username@gmail.com"; // 
$mail->Password = "password"; // SMTP password
$webmaster_email = "username@domain.com"; //Reply to this email ID
$email = "emailtujuan@domain.com"; // Recipients email ID
$name = "namapenerima"; // Recipient's name
$mail->From = $webmaster_email;
$mail->FromName = "namapengirim";
$mail->AddAddress($email,$name);
$mail->AddReplyTo($webmaster_email,"namawebmaster");
$mail->WordWrap = 50; // set word wrap
$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment
$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment
$mail->IsHTML(true); // send as HTML
$mail->Subject = "Ini adalah Email HTML";
$mail->Body = "Ini adalah email contoh"; //HTML Body
$mail->AltBody = "This is the body when user views in plain text format"; //Text Body 
if(!$mail->Send())
{
echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
echo "Message has been sent";
}
?>