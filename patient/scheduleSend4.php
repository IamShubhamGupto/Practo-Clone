<?php
function makeNotification(){
  //get unique batch id
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.sendgrid.com/v3/mail/batch",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{}",
    CURLOPT_HTTPHEADER => array(
      "authorization: Bearer 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"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  $batch_id = "";
  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
      // echo $response;
      $batch_id_response =  json_decode($response);
      $batch_id = $batch_id_response->batch_id;
  }
  echo $batch_id,"<br>";
  //read form 
  $userid=$_GET["usermail"]; 
  $doctorid=$_GET["doctormail"];
  $apptdatetime = $_GET["apptdatetime"];
  $practo_user = $_GET["username"];
  $apptid = $_GET["apptid"];
  $practo_email = "bookingsforpracto@gmail.com";
  $practo_name = "Practo G6";
  $subject = "Upcoming scheduled appointment id:$apptid";

  echo $apptdatetime;
  $mail_body = "<p>Hello $practo_user,</p><p>This is a reminder email for your upcoming appointment at $apptdatetime.</p><p>Regards.</p><p>Practo Team.</p>";
  $dateTime = DateTime::createFromFormat('d/m/Y H:i', $apptdatetime);

  echo "   datetime timestamp = ",$dateTime->getTimestamp(),"   ";
  $send_at = $dateTime->getTimestamp() - 99000;
  // settype($send_at, "integer");
  echo "send at value = ",$send_at, gettype($send_at);


  //schedule send email
  $curl = curl_init();

  $curloptpostfields = "{\"personalizations\":[{
      \"to\":[{\"email\":\"$userid\"}],
      \"cc\":[{\"email\":\"$doctorid\"}]}],
      \"from\":{\"email\":\"$practo_email\",\"name\":\"$practo_name\"},
      \"reply_to\":{\"email\":\"$practo_email\",\"name\":\"$practo_name\"},
      \"subject\":\"$subject\",
      \"content\":[{\"type\":\"text/html\",\"value\":\"$mail_body\"}],
      \"send_at\":$send_at,
      \"batch_id\":\"$batch_id\"}";
  echo $curloptpostfields;    
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $curloptpostfields,
    CURLOPT_HTTPHEADER => array(
      "authorization: Bearer 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",
      "content-type: application/json"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    echo $response;
    echo "Sent success\n";
  }
}
if(isset($_GET["usermail"]) && isset($_GET["doctormail"])
  && isset($_GET["apptdatetime"]) && isset($_GET["username"])
  && isset($_GET["apptid"])){
    makeNotification();
}
?>