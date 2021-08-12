<?php
//error_reporting(0);
session_start();
require '../db/db_con.php';
if (isset($_POST['go'])) 
{
  $regNum = strip_tags(mysqli_real_escape_string($conn, $_POST['regNum']));
  $studId = strip_tags(mysqli_real_escape_string($conn, $_POST['studId']));
  $admDate = strip_tags(mysqli_real_escape_string($conn, $_POST['admDate']));
  $admTime = strip_tags(mysqli_real_escape_string($conn, $_POST['admTime']));
  $schoolCode = strip_tags(mysqli_real_escape_string($conn, $_POST['schIdCode']));
  $studClass = strip_tags(mysqli_real_escape_string($conn, $_POST['studClass']));
  
  $urlEncode = rtrim(strtr(base64_encode(gzdeflate($studId, 9)), '+/','-_'),'=') ;
  if (!isset($regNum) || (strlen($regNum)) =='') {
   echo "<script>alert('Warning :Admission number is empty');
    
   </script>";
   header("location: update-student-details.php?id=".$urlEncode."");
  }
  if (!empty($studId)) 
  {
    $update = mysqli_query($conn, "UPDATE `students` SET `admDate`='$admDate', `class`='$studClass' WHERE `school`='$schoolCode' and `id`='$studId'");
    if (mysqli_affected_rows($conn)) 
    {
       echo "<script>alert('Students Class Updated Successfully');
       var resp = confirm('This Students Class has been updated. We suggest you update the Admission Number');
       if (resp == true)
       {
        window.location.href='change-admission-number.php?id=".$urlEncode."'
       }
       else
       {
        window.location.href='update-choice.php?id=".$urlEncode."'
       }
   </script>";
    }
    else
    {
      echo "<script>alert('An error occured while trying to process your request. Please try again later.');
       
        window.location.href='view-admitted-students.php';
       
   </script>";
    }
    
  }
  else
      {
        echo "<script>alert('Error: Your request could not be processed. This might be as a result of invalid parameters');</script>";
        header("location: update-student-details.php?id=".$urlEncode."");
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
if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == '') {
    echo"
     <script>alert('Access Denied for this User');
    window.location.href='view-admitted-students.php';</script>";
   
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
       
         <?php
        
      $sql=mysqli_query($conn,"SELECT s.regNum AS reg,  s.admDate AS adate, s.admTime AS atime, s.class AS ac, s.school AS ssc, c.id AS cid, c.classCode AS cco, c.name AS cn, sch.id AS schid, sch.name AS schname, sch.motto AS schmo, sch.address AS schad, sch.code AS schco, sch.logo AS schlog
                    from students s
                    INNER JOIN class c
                    ON s.class=c.id 
                    
                    INNER JOIN schools sch
                    ON s.school = sch.id
                    WHERE s.school='$userSchool' and s.id='$studId'");
                      if (mysqli_num_rows($sql)) { 
                        while ($row=mysqli_fetch_assoc($sql)) {
                           
                           $admDate=$row['adate'];
                           $admTime=$row['atime'];
                           $class=$row['cn'];
                           $classId=$row['cid'];
                            $reg=$row['reg'];
                            
                }
              }
             

               
        ?> 
          
        <h3><span class="label label-primary label-mini"><i class="fa fa-university" ></i> Admission Data</span></h3><br>
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
              	<div class="form-group">
                  <input  name="schIdCode"  type="hidden" value="<?php echo $userSchool; ?>">
                  <input type="hidden" name="studId" value="<?php echo $studId; ?>">
                  <label class="control-label col-sm-2">Class<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4">                    
                    <select class="form-control form-control-inline " name="studClass" id="userClass" onchange="loadClassCode()" required="">
                    	<option value="<?php echo $classId; ?>"><?php echo $class; ?></option>
                      <?php 
                    $sql=mysqli_query($conn,"SELECT * from class WHERE id != '$classId'");
                      if (mysqli_num_rows($sql)>0 ) {           
               
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                    	<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; }}else{echo "NO AVAILABLE CLASS FOUND";}?></option>
                    </select>
            		</div>
                <label class="control-label col-sm-2">Admission Date</label>
                  <div class="col-md-4 ">
                    <?php $newDate=date('d-m-Y D');  if ($admDate == '') {
                      echo '<input class="form-control form-control-inline input-medium " name="admDate" id="admissionDate" type="text" readonly="" value="'.$newDate.'"> ';
                    }
                    else
                    {
                      echo '<input class="form-control form-control-inline input-medium " name="admDate" id="admissionDate" type="text" readonly="" value="'.$admDate.'">  
                    ';
                    }
                    ?>
                  </div>
                    
                </div>
                    
                <div class="form-group">
                      <label class="control-label col-sm-2">Admission Time</label>
                        <div class="col-md-4">
                          <input class="form-control form-control-inline input-medium " name="admTime" id="admissionTime"  type="text" readonly="" value="<?php echo $admTime; ?>">  
                        </div>
                


                    <label class="control-label col-sm-2">Admission Number</label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="regNum" id="regNum"  type="text" readonly="" value="<?php $urlEncode = rtrim(strtr(base64_encode(gzdeflate($studId, 9)), '+/','-_'),'=') ; echo $reg; ?>" autocomplete="off"> 
                  
                    <p>Error in Admission Number? <a style="color: red; font-weight: bolder;" href="change-admission-number.php?id=<?php echo $urlEncode ; ?>"> Change Here</a></p> 
                    
                  </div>

            	</div>
              <div class="form-group">
                  <div class="col-md-12">
                 <button type="submit" name="go" class="btn btn-primary btn-sm pull-right">Update&nbsp;<i class="fa fa-refresh"></i> </button><br><br>  
                 </div>                
                </div>
                
               
              </form>
            <?php }else{echo "<script>alert('Error due to system modification. Click Ok to continue');
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
 
  	function description() {
  		var x=document.getElementById('des');
  		if (x.style.display==='none') {
  			x.style.display='block';
  		}else{
  			x.style.display='none';
  		}
  	}
  

    function loadClassCode() {
    var xmlhttp= new XMLHttpRequest();
    xmlhttp.open("GET", "class-request.php?classCode="+document.getElementById("userClass").value, false);
    xmlhttp.send(null);
    document.getElementById("gradeCode").innerHTML=xmlhttp.responseText;
  }

  
  </script>

</body>

</html>
<?php 
mysqli_close($conn);
?>
