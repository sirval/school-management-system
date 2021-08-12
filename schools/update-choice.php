<?php
//error_reporting(0);
session_start();
require '../db/db_con.php';
if (isset($_POST['go'])) 
{
  $info = strip_tags(mysqli_real_escape_string($conn, $_POST['info']));
  $studId = strip_tags(mysqli_real_escape_string($conn, $_POST['studId']));
  $urlEncode = rtrim(strtr(base64_encode(gzdeflate($studId, 9)), '+/','-_'),'=') ;
  if (!empty($info)) 
  {
   
    if ($info == '1') {
     
   header("location: update-student-details.php?id=".$urlEncode."");
   
    }
    elseif ($info == '2') {
    	 header("location: update-student-personal-detail.php?id=".$urlEncode."");
   
    }
    elseif ($info == '3') {
    	 header("location: update-student-parents.php?id=".$urlEncode."");
   
    }
    else
    {
     header("location: view-admitted-students.php");
   	
    }
  }
}



if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 1) {
      require '../controller/required.php'; 
    }else{
      require '../controller/users_required.php'; 
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
          <div class="alert alert-info alert-dismissable">
                              
                  <p>Kindly select the information you wish to update for <strong><?php echo $reg; ?></strong></p>
                  </div>
        
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
              	<input type="hidden" value="<?php echo $studId ?>" name="studId">
              	<div class="form-group">
                  
                  <div class="col-md-6">                    
                    <select class="form-control form-control-inline " name="info" required="">
                    	<option value="">-- Select the Information you Wish to Update--</option>
                     
                    	<option value="1">Update Admission Detail(s)</option>
                    	<option value="2">Update Personal Information</option>
                    	<option value="3">Update Parents Information</option>
                    </select>
            		</div>
                
                  <div class="col-md-6">
                    <input class="form-control form-control-inline input-medium " name="regNum" id="regNum"  type="text" readonly="" value="<?php $urlEncode = rtrim(strtr(base64_encode(gzdeflate($studId, 9)), '+/','-_'),'=') ; echo $reg; ?>" autocomplete="off"> 
                  
                    
                  </div>

            	</div>
              <div class="form-group">
                  <div class="col-md-12">
                 <button type="submit" name="go" class="btn btn-primary btn-sm pull-right">Proceed&nbsp;<i class="fa fa-arrow-right"></i> </button><br><br>  
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
