
<?php
    include "test_connect.php";

    $text = $_GET['text'];
    // $sql = "SELECT * FROM doctor_data WHERE cond LIKE '%$text%'"; // OG

    // multiple symptom match.
    $text_arr = explode(", ", $text);
    $sql_list = "(";

    $size = sizeof($text_arr);
    for ($i = 0; $i < $size; $i++) {
        $sql_list = $sql_list."'";
        $sql_list = $sql_list.$text_arr[$i];
        $sql_list = $sql_list."'";
        if ($i != $size - 1) {
            $sql_list = $sql_list.",";
        }
    }

    $sql_list = $sql_list.")";
    $sql = "SELECT DISTINCT doctorFirstName, doctorLastName,maindoctorId,speciality FROM doctor WHERE symptom IN $sql_list";

  
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result)>0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            echo '<div class="container-fluid">';
            echo '<div class="container-fluid">';
            echo '<div class="media border p-3" style="background-color: ghostwhite;">';
            echo '<div class="media-body">';
            echo '<h4 class="media-heading">';
            echo '<a href="home.php?maindoctorId='. $row['maindoctorId'].'">';
            echo $row["doctorFirstName"];
            echo $row["doctorLastName"];
            echo " | ";
            echo $row["speciality"];
            echo '</a>';
            echo "</h4>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }
    else
    {
        echo '<div class="container-fluid">';
        echo '<div class="container-fluid">';
        echo '<div class="media border p-3" style="background-color: ghostwhite;">';
        echo '<div class="media-body">';
        echo '<h4 class="media-heading">';
        echo "NO DATA";
        echo "</h4>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
?>
