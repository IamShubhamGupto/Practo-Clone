<?php
// function makeNotification(){
  //get unique batch id
  // session_start();
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
  // echo $batch_id,"<br>";
  $userid=$_POST["usermail"];
    $doctorid=$_POST["doctormail"];
    $apptdatetime = $_POST["apptdatetime"];
    $practo_user = $_POST["username"];
    $apptid = $_POST["apptid"];
  // $userid= '<script>document.writeln(sessionStorage.getItem("usermail"));</script>';
  // $doctorid='<script>document.writeln(sessionStorage.getItem("doctormail"));</script>';
  // $apptdatetime = '<script>document.writeln(sessionStorage.getItem("apptdatetime"));</script>';
  // $practo_user = '<script>document.writeln(sessionStorage.getItem("username"));</script>';
  // $apptid = '<script>document.writeln(sessionStorage.getItem("apptid"));</script>';
  // echo "LOPPING"."<br>";
  // $i = 0;
  // $array = str_split($apptdatetime);
  // foreach ($array as $char) {

  //   echo $char. "i = $i    ";
  //   $i +=1;
  //  }

  // echo $userid, $doctorid, $apptdatetime, $practo_user, $apptid;
  $practo_email = "bookingsforpracto@gmail.com";
  $practo_name = "Practo G6";
  $subject = "Upcoming scheduled appointment id:$apptid";

  // echo "appdatetime recieved == $apptdatetime ", gettype($apptdatetime),"   length   ",strlen($apptdatetime);
  $mail_body = "<p>Hello $practo_user,</p><p>This is a reminder email for your upcoming appointment at $apptdatetime.</p><p>Regards.</p><p>Practo Team.</p>";
  $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $apptdatetime);

  // echo "dateTime === $dateTime    ","   datetime timestamp = ",$dateTime->getTimestamp(),"   ";
  $send_at = $dateTime->getTimestamp() - 99000;
  // settype($send_at, "integer");
  // echo "send at value = ",$send_at, gettype($send_at);


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
    // echo $response;
    echo "Sent success\n";
  }

?>
