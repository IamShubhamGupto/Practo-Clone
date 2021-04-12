<?php
session_start();
// require 'scheduleSend5.php';
$date = new DateTime('04/12/2021 9:31');
$sendDate = $date->format('d/m/Y H:i');
echo $date->format('d/m/Y H:i');
?>
<!DOCTYPE html>
<html>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
        function callPHPNotif(){
            $.ajax({
                type: "POST",
                data: "{'usermail':'sindhurao385@gmail.com','doctormail':'shubhamgupto@gmail.com','apptdatetime': '<?php echo $sendDate ?>','username':'hi','apptid': '123'}",     
                url: "/scheduleSend5.php",
                success: function(){
                    window.alert("Successfully subscribed to email notifications!");
                },
                error: function(error){
                    window.alert("Email Notifications failed !", error);
                }
            });	
            window.location.replace("scheduleSend5.php");
        }
    </script>
    <script>
        function callPHPNotif(){
            $.post("scheduleSend5.php",
                {'usermail':'sindhurao385@gmail.com','doctormail':'shubhamgupto@gmail.com','apptdatetime': '<?php echo $sendDate ?>','username':'hi','apptid': '123'},
            ).done(function( data ) {
                alert( "Data Loaded: " + data );
            });	
            // window.location.replace("scheduleSend5.php");
        }
    </script>
    <!-- <script>
        function callPHPNotif(){
            sessionStorage.setItem("usermail", "sindhurao385@gmail.com");
            sessionStorage.setItem("doctormail", "shubhamgupto@gmail.com");
            sessionStorage.setItem("apptdatetime", '<?php echo $sendDate ?>');
            sessionStorage.setItem("username", "hi");
            sessionStorage.setItem("apptid", "123");
            window.location.replace("scheduleSend5.php");
        }
    </script> -->
    <button type="button" onclick="callPHPNotif()">Click Me!</button>
    
</body>


</html>

<!-- <?php
// session_destroy();
// require 'scheduleSend5.php';
// $date=date('d-m-y h:i:s');
// echo date_format($date,"d/m/Y H:i");
?> -->
