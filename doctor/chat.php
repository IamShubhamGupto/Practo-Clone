<?php
session_start();
extract($_GET);
include_once '../assets/conn/dbconnect.php';
// include_once 'connection/server.php';
if(!isset($_SESSION['doctorSession']))
{
header("Location: ../index.php");
}
$usersession = $_SESSION['doctorSession'];
$res=mysqli_query($con,"SELECT * FROM doctor WHERE doctorId=".$usersession);
$userRow=mysqli_fetch_array($res,MYSQLI_ASSOC);



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Welcome Dr <?php echo $userRow['doctorFirstName'];?> <?php echo $userRow['doctorLastName'];?></title>
        <!-- Bootstrap Core CSS -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>


        <link href="assets/css/material.css" rel="stylesheet">

        <link href="assets/css/sb-admin.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css" />
        <style>
            *{
    padding: 0;
    margin: 0;
    border: 0; }
body{
    background: silver;
}
#chat_box{
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
    background-color: red;
    border: 1px solid grey;
    border-radius: 5px; }

textarea{
    width: 100%;
    height: 40px;
    border: 1px solid grey;
    border-radius: 5px; }
#user_box{
    margin-top: 50px;
    box-shadow: 0 0 30px black;
    padding:0 15px 0 15px;
}
        </style>
        <!-- Custom Fonts -->
    </head>
    <body>

        <div id="wrapper">

            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="doctordashboard.php">Welcome Dr <?php echo $userRow['doctorFirstName'];?> <?php echo $userRow['doctorLastName'];?></a>
                </div>
                <ul class="nav navbar-right top-nav">


                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $userRow['doctorFirstName']; ?> <?php echo $userRow['doctorLastName']; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="doctorprofile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                            </li>

                            <li class="divider"></li>
                            <li>
                                <a href="logout.php?logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li class="active">
                            <a href="doctordashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="addschedule.php"><i class="fa fa-fw fa-table"></i> Doctor Schedule</a>
                        </li>
                        <li>
                            <a href="patientlist.php"><i class="fa fa-fw fa-edit"></i> Patient List</a>
                        </li>
                    </ul>
                </div>
            </nav>
             <div id="page-wrapper">
                <div class="container-fluid">


                    <div class="row">
                        <div class="col-lg-12 " >


                        <div id="user_box" >


            <div id="container" >
                <div id="chat_box">

                </div>


                     <textarea name="enter message" placeholder="Enter Message" id="chatmsg" maxlength='150' onkeyup="emptycheck()"></textarea>
                     <input type="submit" id="send" sname="submit" value="Send!" onclick="sendmessage()" disabled/>
                     <div id="the-count_comment" style="">
    <span id="current_comment">0</span>
    <span id="maximum_comment"> / 150</span>


    </div>
                        </div>
                    </div>
                    </div>
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
                //console.log(req.responseText);
                document.getElementById("current_comment").innerHTML="0";
              document.getElementById("chatmsg").value='';

                document.getElementById('chat_box').innerHTML = req.responseText;
                document.getElementById("send").disabled=true;
                document.getElementById("send").style.opacity=0.5; }
                 }
                chatmsg=document.getElementById("chatmsg").value;
                //console.log(chatmsg);
                document.getElementById("chatmsg").value='';
                req.open('POST', 'chatdb.php', true);
                req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                //req.send("msg="+chatmsg);}
                req.send("msg="+chatmsg+"&appid="+"<?php echo $appid; ?>"+"&docid="+"<?php echo $docid; ?>"+"&patid="+"<?php echo $patid; ?>"); }
    //setInterval(getmessage, 1000);
    getmessage();

             </script>


 </html>
