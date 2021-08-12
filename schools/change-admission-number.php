<?php
error_reporting(0);
session_start();
require '../db/db_con.php';
if (isset($_POST['go'])) {
  $regNum = strip_tags(mysqli_real_escape_string($conn, $_POST['regNum']));
  //$parentId = strip_tags(mysqli_real_escape_string($conn, $_POST['parentId']));
  $studentId = strip_tags(mysqli_real_escape_string($conn, $_POST['studentId']));
  //$studentFeeId = strip_tags(mysqli_real_escape_string($conn, $_POST['studentFeeId']));
   $school = strip_tags(mysqli_real_escape_string($conn, $_POST['school']));
  
 
  if ( (!isset($studentId) || trim(strlen($studentId)) =='')) {
    echo "<script>alert('An error was encountered while trying to update student Admission Number. If this error persists, kindly contact the system admin');</script>";
    exit();
  }
  if (isset($studentId)) {
   $sql=mysqli_query($conn,"SELECT * from students WHERE students.regNum ='$regNum' ");
      if (mysqli_num_rows($sql)>0 ) {  
  
echo "<script>alert('Admission Number  Already Exists');
window.location.href='view-admitted-students.php';;
</script>";
    exit();
      }     

$query=mysqli_query($conn, "UPDATE `students` SET `regNum`='$regNum' WHERE `school`='$school' and `id`='$studentId'");
if (mysqli_affected_rows($conn)>0) {
  
echo "<script>alert('Admission Number Updated Successfully');
window.location.href='view-admitted-students.php';;
</script>";
    exit();
}else{
  echo "<script>alert('Error: A fatal error occured while trying to process your request! If this error persists, contact admin for guidelines');</script>";
  header('location: view-admitted-students.php');
    exit();

}
}
}

   if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 1) {
      require '../controller/required.php'; 
    }else{
      echo "<script> alert('Access denied for this user');
  window.location.href='users-dashboard.php';
  </script>";
    }
   if (!isset($_SESSION['userId']) && !isset($_SESSION['user'])) {
    header('location:index.php');
}
$userId=$_SESSION['userId'];
$userSchool=$_SESSION['schoolId'];
siteTitle(mysite, ' || ', '  Admin'.' || ' . $_SESSION['user']);
   meta();
    pageHeader();
   sideBar();
   if ($_GET['id'] && $_GET['id']!='') {
      $studId= gzinflate(base64_decode(strtr($_GET['id'], '-_', '+/')));
  
   ?>
    
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
       
        <div class="row mt">
          <!--  DATE PICKERS -->
          <div class="col-lg-12">
            <div class="form-panel">
            	 
               <div><?php
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
           
         ?>
        </div> 
        <div>
        </div>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
              Enter the Assumed Admission number and wait for our Admission Number Verifier to validate it before assigning it to a student.      
        </div>
       
         <?php

      $sql=mysqli_query($conn,"SELECT s.regNum AS reg, s.surname AS sur, s.othernames AS other, p.id AS pid, sch.id AS schid, c.id AS cid, c.classCode AS cco, c.name AS cn
                    from students s
                    INNER JOIN class c
                    ON s.class=c.id 
                    INNER JOIN parents p
                    ON s.id=p.regNum
                    INNER JOIN schools sch
                    ON s.school = sch.id
                    
                    WHERE s.school='$userSchool' and s.id='$studId'");
     
                      if (mysqli_num_rows($sql)) { 
                        while ($row=mysqli_fetch_assoc($sql)) {
                          
                           $class=$row['cn'];
                           $classId=$row['cid'];
                            $surname=$row['sur'];
                            $others=$row['other'];
                            $studParId=$row['pid'];
                            $reg=$row['reg'];
                            

                }}
                else
                {
                  $url = rtrim(strtr(base64_encode(gzdeflate($studId, 9)), '+/','-_'),'=') ;
  
                  echo "<script> alert('We could not complete your request. Kindly update parent details and try again later');
                  window.location.href='update-choice.php?id=".$url."';</script>";
                }
               
        ?> 
        
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                <input type="text" hidden="" value="<?php echo $userSchool; ?>" name="school">
               
                <input type="text" hidden="" value="<?php echo $studId; ?>" name="studentId">
                
                <div class="form-group">
                  <label class="control-label col-sm-1">Class </label>
                  <div class="col-md-3">
                  <select class="form-control form-control-inline " name="studClass" id="userClass"  required="">
                      <option value="<?php echo $classId; ?>"><?php echo $class; ?></option>
                    </select>
                  </div>

                    <label class="control-label col-sm-2">Admission Number</label>

                    <div class="col-md-6">
                    <div class="input-append">
                    <input value="<?php echo $reg; ?>" class="form-control form-control-inline input-medium " placeholder="Admission Number" name="regNum" id="regNum"  type="text" required="" id="regNum" oninput="checkAvailability()" autocomplete="off">  
                     <span class="input-group-btn add-on" >
                        <p><img height="30px" width="30px" src="img/loaderIcon.gif" id="loaderIcon" style="display: none;"></p>
                        </span>
                        <p id="userAvailability-status"></p>
                        
                       
                  </div>
                  </div>
                </div>

                
              	
              <div class="form-group">
                  
                  <label class="control-label col-sm-1">Surname</label>
                  <div class="col-md-5">
                    <input  readonly="" class="form-control form-control-inline input-medium " name="surname" id="surname" type="text" value="<?php echo $surname; ?>">  
                    
                  </div>
                  <label class="control-label col-sm-1" >Othernames</label>
                  <div class="col-md-5 ">
                    <input readonly="" class="form-control form-control-inline input-medium " name="othernames" id="othernames" type="text" value="<?php echo $others; ?>"  required="">  
                    
                  </div>
                </div>
                 <div class="form-group">
                 	<div class="col-md-12">
                 <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="update-student-details.php#myModal">Change Admission Number&nbsp;<i class="fa fa-arrow-right"></i> </a><br><br>  
                 </div>                
                </div>
                <div class="form-group"></div>

                 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm Registration!</h4>
              </div>
              <p style="font-size: 20px;">Are you sure you want to update <?php echo $reg;?>?</p>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                <button class="btn btn-theme" type="submit" name="go">Yes</button>
              </div>
            </div>
          </div>
        </div>
                 </div>                
                </div>
                
               
              </form>
            <?php }else{echo "<script>alert('An error ooccured due to system modification. Click Ok to continue');
            window.location.href='view-admitted-students.php';

            </script>";} ?>
            </div>
            <!-- /form-panel -->
          </div>
          <!-- /col-lg-12 -->
        </div>
        <!-- /row -->     
      
      </section>
     
    </section>
    
    <?php footer();?>
    <!--footer end-->
  </section>

  <?php mainJs(); ?>
  <script type="text/javascript">
  	function description() {
  		var x=document.getElementById('des');
  		if (x.style.display==='none') {
  			x.style.display='block';
  		}else{
  			x.style.display='none';
  		}
  	}

    function checkAvailability() {
  $("#loaderIcon").show();
  jQuery.ajax({
    url: "checkAvailability.php",
    data: 'regNum='+$("#regNum").val(),
    type: "POST",
    success:function (data) {
      $("#userAvailability-status").html(data);
      $("#loaderIcon").hide();
    },
    error:function () {
      
    }
  });
}

  
  </script>

</body>
<?php
mysql_close($conn);
?>
</html>
