<?php
error_reporting(0);
session_start();
require '../db/db_con.php';
if (isset($_POST['go'])) {
  $surname =strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['surname'])));
  $othernames = strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['othernames'])));
  $dday = strip_tags(mysqli_real_escape_string($conn, $_POST['day']));
  $dmonth = strip_tags(mysqli_real_escape_string($conn, $_POST['month']));
  $dyear = strip_tags(mysqli_real_escape_string($conn, $_POST['year']));
  $gender = strip_tags(mysqli_real_escape_string($conn, $_POST['gender']));
  $studAddress = strip_tags(mysqli_real_escape_string($conn, $_POST['address']));
  $ailment = strip_tags(mysqli_real_escape_string($conn, $_POST['ailment']));
  $ailmentDes = strip_tags(mysqli_real_escape_string($conn, $_POST['ailmentDes']));
  $dob = $dday."-".$dmonth."-".$dyear;
  $studPics=$_FILES['studPics']['name'];
  $studPics_size=$_FILES['studPics']['size'];
  $studPics_type=$_FILES['studPics']['type'];
  $maxSize= 51200; //50KB
  $accepted=array('jpeg','jpg', 'png');

 
  if (!isset($surname) || trim(strlen($surname)) =='') 
  {
    header('location: new-student-profile.php?error=9');
    exit();
  }
  if (!isset($othernames) || trim(strlen($othernames)) =='') 
  {
    header('location: new-student-profile.php?error=10');
    exit();
  }
  if (!isset($gender) || trim(strlen($gender)) =='') 
  {
    header('location: new-student-profile.php?error=7');
    exit();
  }
  if (!isset($studAddress) || trim(strlen($studAddress)) =='') 
  {
    header('location: new-student-profile.php?error=6');
    exit();
  }
  if (!isset($dob) || trim(strlen($dob)) =='') 
  {
    header('location: new-student-profile.php?error=5');
    exit();
  }

  if (($studPics_size>=$maxSize) || $studPics_size=='' ) 
  {
     header('location: new-student-profile.php?error=17');
    exit();
  }
 
  if ((($accepted)==false) || (empty($studPics_type)))
  {
     header('location: new-student-profile.php?error=18');
    exit();
 
  }
    $passportDate = date("d-m-Y");
    $extension=explode('.', $studPics);
    
    $extension=strtolower(end($extension));
    $pass=substr(uniqid(), 0,20) ;
    $passport='SMARTSCHOOL_'.$surname.'_'.$othernames.'_'.$pass.'_'.$passportDate.'.'.$extension;
    $image = (move_uploaded_file($_FILES['studPics']['tmp_name'],"student_temp_passport/$passport"));
if (!empty($surname) && !empty($othernames) && !empty($dob) && !empty($studAddress) && !empty($gender) && !empty($passport))
{
  session_regenerate_id();
        $_SESSION['image'] = $image;
        $_SESSION['studSurname'] = $surname;
        $_SESSION['studOthername'] = $othernames;
        $_SESSION['dob'] = $dob;
        $_SESSION['studAddress'] = $studAddress;
        $_SESSION['studGender'] = $gender;
        $_SESSION['ailment'] = $ailment;
        $_SESSION['ailmentDes'] = $ailmentDes;
        $_SESSION['passport'] = $passport;
    if (!empty($_SESSION['studSurname']) && !empty($_SESSION['studOthername']) && !empty($_SESSION['dob']) && !empty($_SESSION['studAddress']) && !empty($_SESSION['studGender']) && !empty($_SESSION['passport'])) 
      {
        $url= base64_encode($_SESSION['regNum']);
         header("location: new-student-parent.php?userDetail=".$url);
         session_write_close();
      }
}
else
{
  header('location: new-student-profile.php?error=8');
    exit();
}

}


if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
   if($errmsg =='5'){
        $msgerror ='Warning: Student Date of Birth required';
    }
    elseif($errmsg =='6'){
        $msgerror ='Warning: Student Address required';
    }
   elseif($errmsg =='7'){
        $msgerror ='Warning: Student gender required';
    }

    elseif($errmsg =='8'){
        $msgerror ='Error: A fatal error occured while trying to process your request! If this error persists, contact admin for guidelines';
    }
    elseif ($errmsg == '9') {
      $msgerror ='Warning: Surname! required!';
    }
    
    elseif($errmsg =='10'){
        $msgerror ='Warning: Othernames required! ';
    }
    
    elseif($errmsg =='17'){
        $msgerror ='Warning: Image size too big! Your Picture should be less than 50KB';
    }
    elseif($errmsg =='18'){
        $msgerror ='Warning: Invalid image format! Only JPEG, JPG or PNG allowed';
    }
    elseif($errmsg == '40') {
      $msgerror ='Warning: You cannot proceed right now! Because it seems like we have lost the initial value you entered. Kindly refill this form and proceed. if this error persist, please contact admin for guidelines.';
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
    if (isset($_SESSION['regNum'])  && isset($_GET['userDetail']) && $_GET['userDetail'] != '')
      {
        $reg = base64_decode($_GET['userDetail']);
        if ($reg == $_SESSION['regNum']) 
        {
          $regNum = $_SESSION['regNum'];
        }
      }
      else
      {
        header('location:new-student.php?error=40');
      }
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
            <div class="progress progress-striped active">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                  
                </div>
               <span class="">2 Of 4 steps </span>
            </div>
            <br><br>
            <p class="pull-right">[<i style="color: red; font-weight: bolder; font-size: 20px">*</i> indicates required values]</p>
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">

              <h3><span class="label label-danger label-mini"><i class="fa fa-user" ></i> Personal Data</span></h3>
              <div class="form-group">
                  
                  <label class="control-label col-sm-2">Surname <i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="surname" id="surname" type="text">  
                    
                  </div>
                  <label class="control-label col-sm-2" >Othernames <i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                    <input class="form-control form-control-inline input-medium " name="othernames" id="othernames" type="text" >  
                    
                  </div>
                    
                    
                </div>
                
                  <!--start of address Div-->
                <div class="form-group">
                  <label class="control-label col-sm-2">Gender <i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4">
                    <select class="form-control form-control-inline input-medium " name="gender">
                      <option value="">----Select Students' Gender----</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>  
                    
                  </div>
                 
                  <label class="control-label col-sm-2">Date of Birth <i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-1">
                <select name="day" class="form-control form-control-inline input-medium " required="">
                  <?php 
                  for($day=1; $day <=31; $day++)
                  {
                    echo '<option value="'.$day.'">'.$day.'</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-1">
                <select name="month" class="form-control form-control-inline input-medium " required="">
                  <?php 
                  for($month=1; $month <=12; $month++)
                  {
                    echo '<option value="'.$month.'">'.$month.'</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-2">
                 <?php 
                  echo '<select name="year" class="form-control form-control-inline input-medium ">'.PHP_EOL;
                  for($year=date("Y"); $year >= date("1999"); $year--)
                  {
                     echo '<option value="'.$year.'">'.$year.'</option>'.PHP_EOL;
                  }
                  echo '</select>';
                 ?>
                <br>
              </div>
            </div>
                  

                <div class="form-group">
                   <label class="control-label col-sm-2" >Address<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                    <input class="form-control form-control-inline input-medium " required="" name="address" type="text" >  
                    
                  </div>
                  <label class="control-label col-sm-2">Any Known Ailment<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label><br>
                  <div class="col-md-4">
                    <select class="form-control form-control-inline input-medium " required="" name="ailment" onchange="description();">
                      <option value="No">No</option>
                      <option value="Yes">Yes</option>
                      
                    </select> 
                 
                  </div>
                 
                   
                </div>
                
                 
                <div class="form-group ">   
                
                  <div style="display: none;" id="des">
                     <label class="control-label col-sm-2">Ailment Description</label>
                    <div class="col-md-4">
                    <textarea class="form-control form-control-inline input-medium " rows="2" name="ailmentDes" placeholder="Describe Ailment"></textarea> 
                    
                    </div> 
                    </div> 
                    <div style="margin-left: 10px"  >                           
                  <label class="control-label col-md-2">Upload Students' Passport<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label><br>
                  <di class="col-md-4">
                  <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                        <img src="../assets/img/avatar.png" alt="" />
                      </div>
                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                        <span class="btn btn-theme02 btn-file">
                          <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select image</span>
                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                        <input type="file" class="default" name="studPics" />
                        </span>
                        <a href="#" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                      </div>
                    </div>
                    <span class="label label-info">NOTE!</span>
                    <span style="color: red">
                      Passport should either be in JPEG, JPG or PNG format and not more than 50KB
                      </span>
                  </div>
                  </div>
                  
                
                 <div class="form-group">
                  <div class="col-md-6">
                 <a  data-toggle="modal" class="btn btn-danger btn-sm pull-left" href="new-student-profile.php#back">&nbsp;<i class="fa fa-arrow-left"></i> Previous </a><br><br>  
                 </div>
                  <div class="col-md-6">
                 <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="new-student-profile.php#myModal">Next&nbsp;<i class="fa fa-arrow-right"></i> </a><br><br>  
                 </div>                
                </div>
                
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

         <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="back" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm!</h4>
              </div>
              <p style="font-size: 20px;">Are you sure you want to go back?</p>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                <a href="<?php echo 'new-student.php';?>" class="btn btn-theme" >Yes</a>
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
  </section><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


 <!-- js placed at the end of the document so the pages load faster -->
 <script src="../assets/lib/jquery/jquery.min.js"></script>
  <script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="../assets/lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="../assets/lib/jquery.scrollTo.min.js"></script>
  <script src="../assets/lib/jquery.nicescroll.js" type="text/javascript"></script>
  <!--common script for all pages-->
  <script src="../assets/lib/common-scripts.js"></script>
  <!--script for this page-->
  <script src="../assets/lib/jquery-ui-1.9.2.custom.min.js"></script>
  <script type="text/javascript" src="../assets/lib/bootstrap-fileupload/bootstrap-fileupload.js"></script>
  <script type="text/javascript" src="../assets/lib/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="../assets/lib/bootstrap-daterangepicker/date.js"></script>
  <script type="text/javascript" src="../assets/lib/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script type="text/javascript" src="../assets/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
  <script type="text/javascript" src="../assets/lib/bootstrap-daterangepicker/moment.min.js"></script>
  <script type="text/javascript" src="../assets/lib/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
  <script src="../assets/lib/advanced-form-components.js"></script>

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
mysqli_close($conn);
?>
</html>
