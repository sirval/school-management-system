<?php
error_reporting(0);
session_start();
require '../db/db_con.php';
if (isset($_POST['go'])) {
  $regNum = strip_tags(mysqli_real_escape_string($conn, $_POST['regNum']));
  $admDate = strip_tags(mysqli_real_escape_string($conn, $_POST['admDate']));
  $admTime = strip_tags(mysqli_real_escape_string($conn, $_POST['admTime']));
  $schoolCode = strip_tags(mysqli_real_escape_string($conn, $_POST['schIdCode']));
  $studClass = strip_tags(mysqli_real_escape_string($conn, $_POST['studClass']));
  
  if (!isset($regNum) || trim(strlen($regNum)) =='') 
  {
    header('location: new-student.php?error=1');
    exit();
  }
  if (!isset($studClass) || trim(strlen($studClass)) =='') 
  {
    header('location: new-student.php?error=2');
    exit();
  }

 
   $sql=mysqli_query($conn,"SELECT * from students WHERE students.regNum ='$regNum'");
      if (mysqli_num_rows($sql)>0 ) 
      {  

      header('location: new-student.php?error=3');
      exit(); 

      } 
      if (!empty($regNum) && !empty($studClass) && !empty($schoolCode)) 
      {
        session_regenerate_id();
        $_SESSION['regNum'] = $regNum;
        $_SESSION['admDate'] = $admDate;
        $_SESSION['admTime'] = $admTime;
        $_SESSION['schoolCode'] = $schoolCode;
        $_SESSION['studClass'] = $studClass;
      if (!empty($_SESSION['regNum']) && !empty($_SESSION['admDate']) && !empty($_SESSION['admTime']) && !empty($_SESSION['schoolCode']) && !empty($_SESSION['studClass'])) 
      {
        $url= base64_encode($_SESSION['regNum']);
         header("location: new-student-profile.php?userDetail=".$url);
         session_write_close();
      }
    }
      else
      {
        header('location: new-student.php?error=8');
      exit(); 

      }  
  
 

}



if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
    if($errmsg == '1') {
      $msgerror ='Warning: System ID not generated!';
    }
    elseif($errmsg == '2') {
      $msgerror ='Warning: Select Students Class!';
    }
    elseif($errmsg == '3') {
      $msgerror ='Warning: Admission Number Already Exists!';
    }
    elseif($errmsg == '40') {
      $msgerror ='Warning: You cannot proceed right now! Because it seems like we have lost the initial value you entered. Kindly refill this form and proceed. if this error persist, please contact admin for guidelines.';
    }
   
    elseif($errmsg =='8'){
        $msgerror ='Error: A fatal error occured while trying to process your request! If this error persists, contact admin for guidelines';
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
    
   ?>
    
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
       
        <div class="row mt">
         
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
        
              <div class="progress progress-striped active">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                  
                </div>
               <span class="">1 Of 4 steps</span>
            </div>
            <br><br>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                </button>
                    Enter Students Admission Number. If the Admission number does not exist, the <b>Next Button </b> will be shown.  
            </div>
            <p class="pull-right">[<i style="color: red; font-weight: bolder; font-size: 20px">*</i> indicates required values]</p>
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                <h3><span class="label label-primary label-mini"><i class="fa fa-university" ></i> Admission Data</span></h3><br>
              	<div class="form-group">
                  <label class="control-label col-sm-1">Class <i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-5">                    
                    <select class="form-control form-control-inline " name="studClass" id="userClass" onchange="loadClassCode()" required="">
                    	<option value="">--Select Students' Class--</option>
                      <?php 
                    $sql=mysqli_query($conn,"SELECT * from class");
                      if (mysqli_num_rows($sql)>0 ) {           
               
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                    	<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; }}else{echo "NO AVAILABLE CLASS FOUND";}?></option>
                    </select>
            		</div>
                <label class="control-label col-sm-1">Admission Date</label>
                  <div class="col-md-5 ">
                    <input class="form-control form-control-inline input-medium " name="admDate" id="admissionDate" type="text" readonly="" value="<?php echo date('d-m-Y D'); ?>">  
                    
                  </div>
                  <input  name="schIdCode"   type="hidden"  value="<?php echo $userSchool; ?>"/>  
                  
                </div>


                <div class="form-group">
                   <label class="control-label col-sm-1">Admission Time</label> 
                  <div class="col-md-5">
                     
                    <input class="form-control form-control-inline input-medium " name="admTime" id="admissionTime"  type="text" readonly="" value="<?php echo date('h:i:s a'); ?>">  
                    
                  </div>

                    <label class="control-label col-sm-1">Admission Number <i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-5">
                    <div class="input-append">
                    <input autocomplete="off" class="form-control form-control-inline input-medium " placeholder="Admission Number" name="regNum" id="regNum"  type="text" required="" id="regNum" oninput="checkAvailability()" >  
                     <span class="input-group-btn add-on" >
                        <p><img height="30px" width="30px" src="../assets/img/loaderIcon.gif" id="loaderIcon" style="display: none;"></p>
                        </span>
                        <p id="userAvailability-status"></p>
                        
                       
                  </div>
                  </div>
            </div>
              

              
                 <div class="form-group">
                 	<div class="col-md-12">
                 <a id="next" data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="new-student.php#myModal" style="display: none;" >Next &nbsp;<i class="fa fa-arrow-right"></i> </a><br><br>  
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
              <p style="font-size: 20px;">Are you sure you want to proceed?</p>
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
  
function checkAvailability() {
  $("#loaderIcon").show();
  jQuery.ajax({
    url: "checkAvailability.php",
    data: 'regNum='+$("#regNum").val(),
    type: "POST",
    success:function (data) {
      $("#next").show();
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
mysqli_close($conn);
?>
</html>
