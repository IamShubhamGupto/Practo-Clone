<?php
//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
// using SendGrid's PHP Library
// https://github.com/sendgrid/sendgrid-php
require 'vendor/autoload.php';
use SendGrid\Mail\Mail;


$userid=$_POST["userid"]; 
$doctorid=$_POST["doctorid"];
$apptdatetime = $_POST["apptdatetime"];
$practo_user = $_POST["username"];
$apptid = $_POST["apptid"];
$practo_email = "bookingsforpracto@gmail.com";
$practo_name = "Practo G6";
$subject = "Upcoming scheduled appointment id:$apptid ";
$mail_body = "Hello $practo_user, <br>This is a reminder email for your upcoming appointment at $apptdatetime. <br>Regards.<br>Practo Team.";

echo $doctorid;
echo $userid;
$sendgrid = new SendGrid("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");
$email    = new Mail();
$tos = [$userid => $practo_user, $doctorid => $practo_name];
$email->addTos($tos);
$email->setFrom($practo_email, $practo_name);
$email->setSubject("Upcoming scheduled appointment id:$apptid ");
$email->addContent("text/html","Hello $practo_user, <br>This is a reminder email for your upcoming appointment at $apptdatetime. <br>Regards.<br>Practo Team.");

try {
	$response = $sendgrid->send($email);
	print $response->statusCode() . "\n";
	print_r($response->headers());
	print $response->body() . "\n";
} 
catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}

?>