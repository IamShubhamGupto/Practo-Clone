<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$userid=$_POST["userid"]; 
$doctorid=$_POST["doctorid"];
$apptdatetime = $_POST["apptdatetime"];
$practo_user = $_POST["username"];
$apptid = $_POST["apptid"];

$practo_email = "bookingsforpracto@gmail.com";
$practo_pwd = "practo123";
$practo_name = "Practo G6";
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";

$mail->SMTPDebug  = 0;  
$mail->SMTPAuth   = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port       = 587;
$mail->Host       = "smtp.gmail.com";
$mail->Username   = $practo_email;
$mail->Password   = $practo_pwd;

$mail->IsHTML(false);
$mail->AddAddress($userid);
$mail->SetFrom($practo_email, $practo_name);
$mail->AddReplyTo($practo_email, $practo_name);
$mail->AddCC($doctorid, $doctorid);
$mail->Subject = "Upcoming scheduled appointment id:$apptid ";
$content = "Hello $practo_user, <br>This is a reminder email for your upcoming appointment at $apptdatetime. <br>Regards.<br>Practo Team.";

$mail->MsgHTML($content); 
if(!$mail->Send()) {
  echo "Error while sending Email.";
//   var_dump($mail);
} else {
  echo "Email sent successfully";
}
?>