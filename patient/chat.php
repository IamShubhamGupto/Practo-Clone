<?php
session_start();
//include ‘db.php’;

//$conn = mysqli_connect("localhost", "root", "", "myDB");
extract($_GET);
include_once '../assets/conn/dbconnect.php';
$session=$_SESSION['patientSession'];
if(!isset($_SESSION['patientSession']))
{
header("Location: ../index.php");
}
$res=mysqli_query($con, "SELECT a.*, b.*,c.* FROM patient a
	JOIN appointment b
		On a.icPatient = b.patientIc
	JOIN doctorschedule c
		On b.scheduleId=c.scheduleId
	WHERE b.patientIc ='$session'");
	if (!$res) {
		die( "Error running $sql: " . mysqli_error());
	}
	$userRow=mysqli_fetch_array($res);

?>

<!DOCTYPE html>
 <html>
     <head> <title> Chat with Your Doctor! </title>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<!-- <link href="assets/css/bootstrap.min.css" rel="stylesheet"> -->
		<link href="assets/css/material.css" rel="stylesheet">
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="style.css" media="all" /> -->
		<link href="assets/css/default/style.css" rel="stylesheet">
		<link href="assets/css/default/blocks.css" rcel="stylesheet">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css" />
		<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
		<script src=“https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js”></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    *{
    padding: 0;
    margin: 0;
    border: 0; }
body{
    background: silver;
}
#container{
    width: 40%;
    background: white;
    margin: 0 auto;
    padding: 20px; }

#chat_box{
    width: 90%;
    height: 400px; }
#chat_data{
    width: 100%;
    padding: 5px;
    margin-bottom: 5px;
    border-bottom: 1px solid silver;
    font-weight: bold; }
input[type="text"]{
    width: 100%;
    height: 40px;
    border: 1px solid grey;
    border-radius: 5px; }
input[type="submit"]{
    width: 100%;
    height: 40px;
    border: 1px solid grey;
    border-radius: 5px; }
textarea{
    width: 100%;
    height: 40px;
    border: 1px solid grey;
    border-radius: 5px; }
input[type="submit"]:hover {
        background-color:white; /* Green */
        color: white;
      }
    </style>
	</head>
	<body>
		<!-- navigation -->
		<nav class="navbar navbar-default " role="navigation">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="patient.php"><img alt="Brand" src="assets/img/logo.png" height="40px"></a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<ul class="nav navbar-nav">
							<li><a href="patient.php?docid=<?php echo $userRow['maindoctorId']; ?>">Home</a></li>

							<li><a href="patientapplist.php?patientId=<?php echo $userRow['icPatient']; ?>&docid=<?php echo $userRow['maindoctorId']; ?>">Appointment</a></li>
						</ul>
					</ul>

					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $userRow['patientFirstName']; ?> <?php echo $userRow['patientLastName']; ?><b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<a href="profile.php?patientId=<?php echo $userRow['icPatient']; ?>&docid=<?php echo $userRow['maindoctorId']; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
								</li>
								<li>
									<a href="patientapplist.php?patientId=<?php echo $userRow['icPatient']; ?>&docid=<?php echo $userRow['maindoctorId']; ?>"><i class="glyphicon glyphicon-file"></i> Appointment</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="patientlogout.php?logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
        <div id="user_box">

        </div>
        <div id="container">
            <div id="chat_box">

            </div>


                 <textarea name="enter message" placeholder="Enter Message" id="chatmsg" maxlength='150' onkeyup="emptycheck()"></textarea>
                 <input type="submit" id="send" name="submit" value="Send!" onclick="sendmessage()"  disabled style="background-color: green; color:white;opacity: 0.5;"/>
                 <div id="the-count_comment" style="">
<span id="current_comment">0</span>
<span id="maximum_comment"> / 150</span>


        </div>
    </body>
    <script>
    function emptycheck(){
      console.log('ele');
      if (document.getElementById("chatmsg").value==""){
        document.getElementById("send").disabled = true;
        document.getElementById("send").style.opacity=0.5;


      }
      else{
        document.getElementById("send").disabled = false;
        document.getElementById("send").style.opacity=1;

      }

    };
     $('#chatmsg').keyup(function () {
  var characterCount = $(this).val().length,
  current = $('#current_comment'),
  maximum = $('#maximum_comment'),
  theCount = $('#the-count_comment');
  var maxlength = $(this).attr('maxlength');
  var changeColor = 0.75 * maxlength;
  current.text(characterCount);

  if (characterCount > changeColor && characterCount < maxlength) {
    current.css('color', '#FF4500');
    current.css('fontWeight', 'bold');
  }
  else if (characterCount >= maxlength) {
    current.css('color', '#B22222');
    current.css('fontWeight', 'bold');
  }
  else {
    var col = maximum.css('color');
    var fontW = maximum.css('fontWeight');
    current.css('color', col);
    current.css('fontWeight', fontW);
  }
});
    function getmessage(){
    var req = new XMLHttpRequest();

        req.onreadystatechange = function() {
            if(req.readyState == 4 && req.status == 200){
                document.getElementById('chat_box').innerHTML = req.responseText; }
                 }

                req.open('GET', 'chatdb.php?'+"appid="+"<?php echo $appid; ?>"+"&docid="+"<?php echo $docid; ?>"+"&patid="+"<?php echo $patid; ?>", true);

                //req.open('GET', 'db.php', true);
                req.send(); }



    function sendmessage(){
    var req = new XMLHttpRequest();

        req.onreadystatechange = function() {
            if(req.readyState == 4 && req.status == 200){
              document.getElementById("current_comment").innerHTML="0";
              document.getElementById("chatmsg").value='';

                document.getElementById('chat_box').innerHTML = req.responseText;
                document.getElementById("send").disabled=true;
                document.getElementById("send").style.opacity=0.5;
                 }
                 }
                chatmsg=document.getElementById("chatmsg").value;
                //console.log(chatmsg);

                req.open('POST', 'chatdb.php', true);
                req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                //req.send("msg="+chatmsg);}
                req.send("msg="+chatmsg+"&appid="+"<?php echo $appid; ?>"+"&docid="+"<?php echo $docid; ?>"+"&patid="+"<?php echo $patid; ?>"); }
    //setInterval(getmessage, 1000);
    getmessage();

             </script>


 </html>
