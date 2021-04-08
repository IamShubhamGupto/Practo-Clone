<?php
require_once __DIR__ . '/vendor/autoload.php';
//get batch id
$client = new http\Client;
$request = new http\Client\Request;

$body = new http\Message\Body;
$body->append('{}');

$request->setRequestUrl('https://api.sendgrid.com/v3/mail/batch');
$request->setRequestMethod('POST');
$request->setBody($body);

$request->setHeaders(array(
  'authorization' => 'Bearer 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'
));

$client->enqueue($request)->send();
$response = $client->getResponse();

$batch_id_response =  json_decode($response->getBody());
$batch_id = $batch_id_response->batch_id;

$userid=$_POST["userid"]; 
$doctorid=$_POST["doctorid"];
$apptdatetime = $_POST["apptdatetime"];
$practo_user = $_POST["username"];
$apptid = $_POST["apptid"];
$practo_email = "bookingsforpracto@gmail.com";
$practo_name = "Practo G6";
$subject = "Upcoming scheduled appointment id:$apptid ";
$mail_body = "Hello $practo_user, <br>This is a reminder email for your upcoming appointment at $apptdatetime. <br>Regards.<br>Practo Team.";

$datetime = new Date($apptdatetime);
echo $datetime->getTimestamp();
$client = new http\Client;
$request = new http\Client\Request;

$body = new http\Message\Body;
$body->append('{
    "personalizations": [
      {
        "to": [
          {
            "email": $userid,
            "name": "$practo_user"
          }
        ],
        "cc": [
          {
            "email": $doctorid,
            "name": $practo_name
          }
        ]
      }
    ],
    "from": {
      "email": $practo_email,
      "name": $practo_name
    },
    "reply_to": {
      "email": $practo_email,
      "name": $practo_name
    },
    "subject": $subject,
    "content": [
      {
        "type": "text/html",
        "value": $mail_body
      }
    ],
    "send_at": 1617776700,
    "batch_id": $batch_id
  }');

$request->setRequestUrl('https://api.sendgrid.com/v3/mail/send');
$request->setRequestMethod('POST');
$request->setBody($body);

$request->setHeaders(array(
  'content-type' => 'application/json',
  'authorization' => 'Bearer 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'
));

$client->enqueue($request)->send();
$response = $client->getResponse();

echo $response->getBody();
?>