<?php
extract($_GET);
$conn = mysqli_connect("localhost", "root", "", "db_healthcare");
if(isset($_POST['msg']))
{   extract($_POST);
    
    $query = "INSERT INTO chat (appid, maindoctorId, icPatient, msg, flag) VALUES ( '$appid', '$docid' ,'$patid', '$msg', '1')"; 
    $res= mysqli_query($conn, $query);
    
}

$q = "SELECT distinct doctorFirstName, doctorLastName FROM doctor where maindoctorId='$docid'" ; 
$row1 = mysqli_query($conn, $q);
if (mysqli_num_rows($row1) > 0) {
    // output data of each row
    
    while($row = mysqli_fetch_assoc($row1) ) {
        $fullname= $row['doctorFirstName'] ." " . $row['doctorLastName'];
        
    }
} 


//$r= mysqli_fetch_assoc($rowq1);

$query = "SELECT * FROM chat where appid='$appid' order by msgtimestamp" ; 
$result = mysqli_query($conn, $query);
if (!$result){
     echo mysqli_error($conn);}
if (mysqli_num_rows($result) > 0) {
          // output data of each row
          
          while($row = mysqli_fetch_assoc($result) ) {
              if ($row["flag"]){
            echo  "<div>  <span style='color:green;'> Me:  </span>" . $row["msg"]. "<span style='float:right;'>" . $row["msgtimestamp"] . "<br></div>";
          }
          else{ 
            echo  " <div><span style='color:red;'> Dr.  ".$fullname  .":  </span>" . $row["msg"]. "<span style='float:right;'>" . $row["msgtimestamp"] . "<br></div>";
            //echo $r['doctorFirstName'];
          }
        }
    } 
    





?>