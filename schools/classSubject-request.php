<?php 
error_reporting(0);
 require '../db/db_con.php';
 $state=$_GET['studClass'];
 if ($state!='') {
 	$query=mysqli_query($conn, "SELECT * from subjects where classId='$state'");
 	echo '<select>';
 	while ($row=mysqli_fetch_array($query)) {
 		echo '<option value='.$row['id'].'>'; echo $row['subjectname']; echo '</option>' ;
 	}
 	echo '</select>' ;
 }
?>