<?php
session_start();
include_once '../assets/conn/dbconnect.php';
$session=$_SESSION[ 'patientSession'];
if (isset($_GET['appId'])) {
	$appid =$_GET['appId'];
}
if (isset($_GET['scheduleId'])) {
	$scheduleid =$_GET['scheduleId'];
}



$sql1 = "DELETE FROM appointment WHERE appid='$appid'";
$delete = mysqli_query($con,$sql1);

$sql = "UPDATE doctorschedule SET bookAvail = 'available' WHERE scheduleId = $scheduleid" ;
$scheduleres=mysqli_query($con,$sql);
if ($scheduleres) {
	$btn= "enable";
}

?>
<!DOCTYPE html>
<html>
<body>
<script>
	alert('Appointment cancelled successfully.');
	window.location.href = "patientapplist.php";
</script>
</body>
</html>
