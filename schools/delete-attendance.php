
<?php
error_reporting(0);
session_start();
   require '../db/db_con.php';
if (isset($_POST['delete'])) {
   
      $id = strip_tags(mysqli_real_escape_string($conn, $_POST['attId']));
      $term=strip_tags(mysqli_real_escape_string($conn, $_POST['term']));
      $vSession=strip_tags(mysqli_real_escape_string($conn, $_POST['vSession']));
      $adate=strip_tags(mysqli_real_escape_string($conn, $_POST['adate']));
      if (!empty($id) && !empty($term) && !empty($vSession) && !empty($adate)) 
      {
        if ($vSession == 'Afternoon') 
        {
        $query=("DELETE FROM `attendance_afternoon` WHERE `mId`='$id' and `term`='$term' and `date`='$adate'");
        if (mysqli_query($conn, $query)) 
        {
          echo "<script> 
        window.location.href='view-attendance.php?delete=successful'
        </script>";
        }
        else
        {
          echo "<script> 
        window.location.href='view-attendance.php?error=1'
        
        </script>";
        }
        }
        elseif ($vSession == 'Morning') 
        {
          $query=("DELETE FROM `attendance_morning` WHERE `studentId`='$id' and `term`='$term' and `date`='$adate'");
        if (mysqli_query($conn, $query)) 
        {
          echo "<script> 
        window.location.href='view-attendance.php?delete=successful'
        </script>";
        }
        else
        {
          echo "<script> 
        window.location.href='view-attendance.php?error=1'
        
        </script>";
        }
        }
        else
        {
          echo "<script> 
        window.location.href='view-attendance.php?error=3'
        
        </script>";
        }
      }
      else
      {
        echo "<script> 
        window.location.href='view-attendance.php?error=2'
        
        </script>";
      }
    }
  
  if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 1) {
      require '../controller/required.php'; 
    }else{
      require '../controller/users_required.php'; 
    }
    if (isset($_SESSION['userRole']) && $_SESSION['userRole'] != 1) {
    echo"
     <script>alert('Access Denied for this User');
    window.location.href='users-dashboard.php';</script>";
   
   }
   siteTitle(mysite, ' || ', ' Admin'.' || ' . $_SESSION['user']);
   if (!$_GET['permalink'] && $_GET['permalink'] == '') {
   	//$studId = base64_decode($_GET['permalink']);
   	echo"
     <script>alert('An error occured. Try again later');
    window.location.href='view-attendance.php';</script>";
   }
   $studId= gzinflate(base64_decode(strtr($_GET['permalink'], '-_', '+/')));
   
   
                  	$query = mysqli_query($conn,"SELECT surname, othernames, regNum FROM students WHERE id='$studId' ");
                  	if (mysqli_num_rows( $query) > 0) 
                    {
                  		while ($getStud = mysqli_fetch_array($query)) {
                  			$name = $getStud['surname']. '  '.$getStud['othernames'];
                  			$reg = $getStud['regNum'];
                  		}
                  	}
                  	else{
                  		echo "<script>alert('We could not find specified student. Try again later');
                              window.location.href='view-attendance.php';</script>";
                  	}
                  

 ?>

  <!-- Bootstrap core CSS -->
  <link href="../assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="../assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/style-responsive.css" rel="stylesheet">
 
</head>

<body>
	<?php 
	if (!empty($_SESSION['Mor_After']) && !empty($_SESSION['attDate']) && !empty($_SESSION['term'])) 
      {
        $vSession= $_SESSION['Mor_After'];
        $attDate = $_SESSION['attDate'];
        $termId= $_SESSION['term'];
        
      }
       else
    {
   	echo"
     <script>alert('An error occured. Try again later');
    window.location.href='view-attendance.php';</script>";
   
   }

	?>
  <div id="login-page">
    <div class="container">
      <form class="form-login" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
         <?php  
         
         ?>
        <h2 class="form-login-heading">You're about deleting <?php echo '<strong style="color: red">'.  $name."'s</strong>"; ?> Attendance Details</h2>
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
            </button>
                <h5><i class="fa fa-warning"> </i><b>&nbsp; This Action Cannot Be Reversed</b></h5>
        </div>
        
        
        <div class="login-wrap">
        	<p><?php echo "This will erase all attendance related to this student in the <strong>". $vSession. "</strong> on <strong>". $attDate ."</strong>";?>. Consider <a href="update-attendance.php"> updating</a> details instead</p>
          <input readonly="" type="text" class="form-control" name="studReg" value="<?php echo $reg; ?>">
          
             <input type="hidden" name="attId" value="<?php  $studId; echo $studId;  ?>">
                        <input type="hidden" name="term" value="<?php echo $_SESSION['vTerm'];  ?>">
                        <input type="hidden" name="vSession" value="<?php echo $_SESSION['vSession'];  ?>">
                        <input type="hidden" name="adate" value="<?php echo $_SESSION['vAttDate'];  ?>">

                     
          <br>
          <div>
          	<button onclick="cancel()"  class="btn btn-block" type="button"><i class="fa fa-times"></i> Cancel</button>
          <button class="btn btn-danger btn-block" type="submit" name="delete"><i class="fa fa-trash"></i> Continue Anyway</button>
      </div>
         
        </div>
        
      </form>
    </div>
  </div>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="../assets/lib/jquery/jquery.min.js"></script>
  <script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
  
</body>

</html>
<?php mysqli_close($conn); ?>