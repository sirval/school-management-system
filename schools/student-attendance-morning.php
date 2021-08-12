
<?php
error_reporting(0);
session_start();
date_default_timezone_set('Africa/Lagos');
 require '../db/db_con.php';
    if (isset($_POST['marked'])) 
     {
      if (isset($_POST['morAfter']) && !empty($_POST['morAfter']) && ($_POST['morAfter']) == "Morning") 
      {

        $class_id = mysqli_real_escape_string($conn, $_POST['class_id']);
     	
     	if (!empty($_POST['phone']) && !empty($_POST['year']) && !empty($_POST['date']) && !empty($_POST['term']) && !empty($_POST['studId']) && is_array($_POST['year']) && is_array($_POST['phone']) && is_array($_POST['date']) && is_array($_POST['term']) && is_array($_POST['studId']) && count($_POST['studId']) ) 
     	{
       
     	$yearArr= $_POST['year'];
     	$termArr= $_POST['term'];
     	$studIdArray= $_POST['studId'];
     	//$studClassArray= $_POST['studClass'];
     	$dateArr= $_POST['date'];
     	$presentArr= $_POST['pr'];
      $timeArr = $_POST['time'];
      $phoneArr = $_POST['phone'];
      $activatedArr = $_POST['activate'];
      $actTermArr = $_POST['activatedTerm'];
      $pname = $_POST['pname'];
      $message = $_POST['message'];

     	for ($i=0; $i < count($studIdArray); $i++) 
     	{
        
     	$year= mysqli_real_escape_string($conn, $yearArr[$i]);
     	$term= mysqli_real_escape_string($conn, $termArr[$i]);
     	$studId= mysqli_real_escape_string($conn, $studIdArray[$i]);
     	//$class_id= mysqli_real_escape_string($conn, $studClassArray[$i]);
     	//$section= mysqli_real_escape_string($conn, $morAfterArr[$i]);
      $date= mysqli_real_escape_string($conn, $dateArr[$i]);
     	$present= mysqli_real_escape_string($conn, $presentArr[$i]);
      $time = mysqli_real_escape_string($conn, $timeArr[$i]);
      $phone = mysqli_real_escape_string($conn, $phoneArr[$i]);
      $activated = mysqli_real_escape_string($conn, $activatedArr[$i]);
      $activatedTerm = mysqli_real_escape_string($conn, $actTermArr[$i]);
      //$pname = mysqli_real_escape_string($conn, $pname[$i]);
      
      
      $auth=mysqli_query($conn, "SELECT * FROM attendance_morning, students WHERE attendance_morning.studentId = students.id and attendance_morning.studentId='$studId' and attendance_morning.term='$term' and attendance_morning.date='$date' and attendance_morning.year='$year' and students.class='$class_id'");
      if (mysqli_num_rows($auth) > 0) 
      {
        echo "<script> 
        window.location.href='student-attendance-morning.php?error=4';
        
        </script>";
        exit();
      }
     
     	$query =mysqli_query($conn, "INSERT INTO `attendance_morning`(`studentId`, `year`, `date`, `term`, `present`, `time`,`phone`) VALUES ('$studId','$year','$date','$term','$present', DATE_FORMAT(NOW(), '%h:%i %p'), '$phone')");
     	if (mysqli_affected_rows($conn) >0) 
     	{
        echo "<script> 
        window.location.href='student-attendance-morning.php?confirm=successful'
        </script>";
      }
      else
          {
            echo "<script> 
            window.location.href='student-attendance-morning.php?error=5'
            
            </script>";
            exit();
          }
     	}
      
     	}
       else
       {
     		echo "
         <script> 
        window.location.href='student-attendance-morning.php?eror=3'
        
        </script>";
        exit();
    }
}
else {
  echo 'Afternoon';
}
     }

if (isset($_GET['error']) && $_GET['error'] !=='') 
{
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
   
    if($errmsg =='2')
    {
        $msgerror ='A fatal error occured while trying to process your request! Kindly Contact the admin to correct this error ';
    }
    elseif($errmsg =='3')
    {
        $msgerror ='System internal error. Click <a href=""> Here </a> to get you back. ';
    }
     elseif($errmsg =='4')
     {
        $msgerror ='Attendance has been marked for today in the morning. Click <a href="update-attendance.php">Here</a> to mark for todays afternoon ';
     }
     elseif($errmsg =='5')
    {
        $msgerror ='SMS could not be sent ';
    }
    
}
  if (isset($_GET['confirm']) && $_GET['confirm']=='successful') 
  {
  $msgsucc="Attendance Marked Successfully";
  }
  if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 1) 
  {
      require '../controller/required.php'; 
  }
    else
    {
      require '../controller/users_required.php'; 
    }
   /*if (!isset($_SESSION['userId']) && !isset($_SESSION['user'])) {
    header('location:index.php');
}
$userId=$_SESSION['userId'];
$userSchool=$_SESSION['schoolId'];*/
siteTitle(mysite, ' || ', '  Admin'.' || ' . $_SESSION['user']);
   meta();
    pageHeader();
   sideBar();
   if (($_SESSION["attDate"]) && ($_SESSION["term"]) && ($_SESSION["studClass"]!='') && ($_SESSION["Mor_After"])) 
 	{
	$urlDecode= $_SESSION["Mor_After"] ;
 	}
	else
	{
	echo "<script> alert('A fatal error occured. Please contact the SmartSchool Team for update');
      window.location.href='main-dashboard.php';
       </script>";
       exit();
	}
   ?>
  <link href="../assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="../assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  
  <link href="../assets/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
  
  <!-- Custom styles for this template -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/style-responsive.css" rel="stylesheet">
  <style type="text/css">
    .padTable{
      margin: 10px;
    }
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="col-md-12 mt">
          <div class="row content-panel">
            <div class="col-md-12">
              <?php
              if (isset($_POST['updateAttendance'])) {
      //$attFor = strip_tags(mysqli_real_escape_string($conn, $_POST['attendFor']));
      $attDate = strip_tags(mysqli_real_escape_string($conn, $_POST['attDate']));
      $term = strip_tags(mysqli_real_escape_string($conn, $_POST['term']));
      $studClass = strip_tags(mysqli_real_escape_string($conn, $_POST['studClass']));
      $morAfter = strip_tags(mysqli_real_escape_string($conn, $_POST['morAfter']));
    if (empty($attDate) ) {
      echo "<script> alert('Enter Attendance Date');
      window.location.href='attendance-options.php';
      </script>";
      exit();
    }
    if (empty($term) ) {
      echo "<script> alert('Select Attendance Term');
      window.location.href='attendance-options.php';
       </script>";
       exit();
    }
    if (empty($studClass) ) {
      echo "<script> alert('Select Students Class');
      window.location.href='attendance-options.php';
       </script>";
       exit();
    }
    if (empty($morAfter) ) {
      echo "<script> alert('A fatal error occured. Please contact the SmartSchool Team for update');
       window.location.href='attendance-options.php'; </script>";
       exit();
    }
    //session_regenerate_id();
      $_SESSION['attDate'] = $attDate;
      $_SESSION['term']= $term;
      $_SESSION['studClass']=$studClass;//student class
      //$_SESSION['attFor']=$attFor;// attendance for students
      $_SESSION['morAfter']=$morAfter;
      //session_write_close();
    if (!empty($_SESSION['attDate']) || !empty($_SESSION['term']) || !empty($_SESSION['studClass']) || !empty($_SESSION['morAfter'])) {
      
        echo "error".mysqli_error($conn);
        
  }else{
    echo "<script> alert('An error was encountered while trying the process this request. Please contact the admin id this error persists')";
     exit();
  }
}

              ?>
              
 <div class="invoice-body">
    <?php
      	if (isset($_SESSION["attDate"]) && isset($_SESSION["term"]) && ($_SESSION["studClass"]!='') && ($_SESSION["Mor_After"] = $urlDecode))
        {
	    $classId = $_SESSION['studClass'];
        $termId= $_SESSION['term'];
        $date = $_SESSION['attDate'];
        //get term by name
        $term=mysqli_query($conn,"SELECT * from term WHERE id='$termId'");
            if (mysqli_num_rows($term)>0 ) 
            {  
             while($row = mysqli_fetch_array($term))
             {
                $termName=$row['termName'];
             }
            }
            else
            {
             echo "Oops: We could not find the academic term you specified. Click <a href='main-dashboard.php'>Here</a> to go back" ;
            }
         	//get class by name
        	$class=mysqli_query($conn,"SELECT * from class WHERE id='$classId'");
            if (mysqli_num_rows($class)>0 ) 
            {  
             while($row = mysqli_fetch_array($class))
	            {
	             $classResult=$row['classCode'];
	            }
             }
              else
           		{
                  echo "Oops: We could not find the specified class. Click <a href='main-dashboard.php'>Here</a> to go back" ;
                }
           ?>
         <div>
          <?php
                 if (isset($_GET['$userinfor']) && $_GET['$userinfor'] !=='') {
                     $message = $_GET['$userinfor'];
                     echo "$message";
                  }
                 if (isset($errmsg) && $errmsg !=='') {
                    ?>
                     <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                     </button>
                    <?php echo $msgerror; ?>
                  </div>
                 <?php
              }
              elseif (isset($msgsucc) && $msgsucc !=='') 
            {
        ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
                <?php echo $msgsucc; ?></div>
        <?php
            }
         ?>
       </div>


             <div  class="adv-table padTable">
              <table id="marks"  class="table table-bordered" id="hidden-table-info">
              
                <caption>
                <h1 style="text-align: center;"><?php echo strtoupper($urlDecode. ' ROLL CALL') ;?></h1>
                <strong>Date: </strong><label> <?php echo $date; ?></label>
                <br><strong>Term: </strong><label><?php echo $termName; ?></label>
                <br><strong>Class: </strong><label><?php echo $classResult; ?></label>
                </caption>
                <thead>
                  <tr>
                    <th>SN</th>
                    <th width="40%">Student Name</th>
                    <th width="40%">Admission Number</th>
                    <th width="20%">Present</th>
                    
                  </tr>
                </thead>

  <tbody>
     
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="post" class="style-form" enctype="multipart/form-data">
     <input type="hidden"  value="<?php echo $urlDecode; ?>"  name="morAfter">
     <input type="hidden"  value="<?php echo $classId ?>"  name="class_id">
 
  <?php
   $myYear= $_SESSION['year'];
   $curTime = date('h:i:s A');
  $sn=0;
  //get all the students in the specified class
  $sql=mysqli_query($conn, "SELECT * FROM students WHERE class='$classId'");
   if (mysqli_num_rows($sql)>0) 
    {
    	while ($res=mysqli_fetch_array($sql)) 
    {
      $studentId = $res['id'];
      $studName = $res['surname'].'&nbsp;&nbsp;&nbsp;'. $res['othernames'];
      $reg = $res['regNum'];
    $getParentPhone=mysqli_query($conn, "SELECT parentFname, parentOthers, phone, regNum, appActivation, term FROM parents WHERE regNum ='$studentId' ");
   if (mysqli_num_rows($getParentPhone)>0) 
    {
      while ($parPhone=mysqli_fetch_array($getParentPhone)) 
    {
      $phone = $parPhone['phone'];
      $activate = $parPhone['appActivation'];
      $term = $parPhone['term'];
      $pname = $parPhone['parentFname'].'&nbsp;'.$parPhone['parentOthers'];
      if ($activate == 0){
        $phone = 0;
      }
      
  	}
  }
 ?>
    <tr>
    <td><?php echo ++$sn; ?></td>
    <input type="hidden"  value="<?php echo $myYear; ?>"  name="year[]">
    <input type="hidden"  value="<?php echo $date; ?>"  name="date[]">
	<input type="hidden"  value="<?php echo $termId; ?>"  name="term[]">
	<input type="hidden"  value="<?php echo $curTime; ?>"  name="time[]">
  <input type="hidden"  value="<?php echo $phone; ?>"  name="phone[]">
  <input type="hidden"  value="<?php echo $activate; ?>"  name="activate[]">
  <input type="hidden"  value="<?php echo $term; ?>"  name="activatedTerm[]">
  <input type="hidden" value="<?php echo $studentId; ?>"  name="studId[]">
     <input type="hidden" value="<?php echo $pname; ?>"  name="pname[]">
     <textarea name="message" hidden="">Good Morning Mr/Mrs <?php echo $pname; ?>. Attendance take for today <?php echo $date .' by '. $curTime; ?>. Your child is Present: </textarea>
    <td><?php echo $studName; ?></td>
    <td><?php echo $reg; ?></td>
          <div class="form-group">
            <td>
        
            <select class="form-control form-control-inline" name="pr[]">
            	<option value="1">Yes</option>
            	<option value="0">No</option>
            </select>
           
            </td>
            
            </div>

    </tr>
    <?php } ?>

  </tbody>
  </table>
  <?php 
 	$myYear= $_SESSION['year'];
  $checkRollCallExistence = mysqli_query($conn, "SELECT * FROM attendance_morning WHERE `date` = '$date' and `term` = '$termId' and `year`='$myYear'");
  if (mysqli_num_rows($checkRollCallExistence)>0) 
  {
  	echo '<div class="pull-left">
    <a class="btn btn-warning" href="update-attendance.php"> Update Roll Call</a>
   </div>';
  }
  else
  {
  	echo "";
  }
  ?>
  
    <div class="pull-right">
       <a  data-toggle="modal" class="btn btn-theme btn-sm pull-right" href="student-attendance-morning.php#myModal">Submit Roll Call&nbsp;<i class="fa fa-save"></i> </a><br><br>  
    </div>                
</div>

                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm Attendance!</h4>
              </div>
              <p style="font-size: 20px;">Are you sure you want to proceed?</p>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                <button class="btn btn-theme" type="submit" name="marked">Yes</button>
              </div>
            </div>
          </div>
      </div>
  </form>

 
  <?php
 }else{
 	echo 
 	"<script> alert ('An Error Occured!');
 	window.location.href='main-dashboard.php';</script>

 	";
 }}
?>
                
                <br>
                <br>
              </div>
              <!--/col-lg-12 mt -->
      </section>
      <!-- /wrapper -->
    </section><br><br>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
    <!--footer start-->
    <footer class="">
      <div class="text-center">
                
      <?php footer();
      ?>
      </div>
    </footer>
    <!--footer end-->
  </section>
  <script src="../assets/lib/jquery/jquery.min.js"></script>

<script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../assets/lib/jquery.dcjqaccordion.2.7.js"></script>
<script src="../assets/lib/jquery.scrollTo.min.js"></script>
<script src="../assets/lib/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../assets/lib/jquery.sparkline.js"></script>
<script src="../assets/lib/common-scripts.js"></script>
<script type="text/javascript" src="../assets/lib/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="../assets/lib/gritter-conf.js"></script>
<!--common script for all pages-->
<script src="../assets/lib/jquery/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/lib/advanced-datatable/js/jquery.js"></script>
<script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../assets/lib/jquery.dcjqaccordion.2.7.js"></script>
  
  <script type="text/javascript">
    function loadSubject() {
    var xmlhttp= new XMLHttpRequest();
    xmlhttp.open("GET", "class-request.php?classes="+document.getElementById("studClasses").value, false);
    xmlhttp.send(null);
    document.getElementById("classSubject").innerHTML=xmlhttp.responseText;
    
  }

  function loadResultSheet() {
    var xmlhttp= new XMLHttpRequest();
    xmlhttp.open("GET", "student-request.php?studClass="+document.getElementById("studClasses").value, false);
    xmlhttp.send(null);
    //document.getElementById("classSubject").innerHTML=xmlhttp.responseText;
    document.getElementById("studId").innerHTML=xmlhttp.responseText;
    //document.getElementById("studName").innerHTML=xmlhttp.responseText;
    var x=document.getElementById("studContainer");
    
  }
/*$('table input').on('input', function() {
  var $tr = $(this).closest('tr');
  var tot = 0;
  $('input:not(:last)',$tr).each(function() {
    tot += Number($(this).val()) || 0;
  });
  $('td:last input', $tr).val(tot);
}).trigger('input');


  $(document).on("change", ".score", function() {
    var sum = 0;
    var parent = $(this).closest('tr');
    parent.find($(".score")).each(function() {
      sum += +$(this).val();
    });
    $(".totScore").val(sum);
    if ((".totScore").val() > 89) {
       $(".grade").val("Excellent");
    }
  });
  */



$(window).on('load', function() {
  $('myModalLoader').modal('show');
});

</script>
   
</body>

</html>
<?php
mysqli_close($conn);
?>

</body>

</html>