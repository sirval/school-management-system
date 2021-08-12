<?php
//error_reporting(0);
session_start();
require '../db/db_con.php';
if (isset($_POST['go'])) 
{
  $surname =strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['surname'])));
  $othernames = strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['othernames'])));
  $dob = strip_tags(mysqli_real_escape_string($conn, $_POST['dob']));
  $gender = strip_tags(mysqli_real_escape_string($conn, $_POST['gender']));
  $studAddress = strip_tags(mysqli_real_escape_string($conn, $_POST['address1']));
  //$address2 = strip_tags(mysqli_real_escape_string($conn, $_POST['address2']));
  $ailment = strip_tags(mysqli_real_escape_string($conn, $_POST['ailment']));
  $ailmentDes = strip_tags(mysqli_real_escape_string($conn, $_POST['ailmentDes']));
  $studId = strip_tags(mysqli_real_escape_string($conn, $_POST['studId']));
  $urlEncode = rtrim(strtr(base64_encode(gzdeflate($studId, 9)), '+/','-_'),'=') ;
  $schoolCode = strip_tags(mysqli_real_escape_string($conn, $_POST['schIdCode']));
  
  $studPics=$_FILES['studPics']['name'];
  $studPics_size=$_FILES['studPics']['size'];
  $studPics_type=$_FILES['studPics']['type'];
  $maxSize= 51200; //50KB
  $accepted=array('jpeg','jpg', 'png');

  
  if (!isset($surname) || (strlen($surname)) =='') {
    echo "<script>alert('Error:Surname field is empty');</script>";
    header("location: update-student-personal-detail.php?id=".$urlEncode."");
  }
  if (!isset($othernames) || (strlen($othernames)) =='') {
    echo "<script>alert('Error: Othernames field is empty');</script>";
    header("location: update-student-personal-detail.php?id=".$urlEncode."");
  }
  if (isset($studPics) && ($studPics)!='') 
  {
    if (($studPics_size>=$maxSize) ) {
     echo "<script>alert('Error: File size too big only files less than 50KB is accepted');</script>";
     header("location: update-student-personal-detail.php?id=".$urlEncode."");
  }
 
  if (($accepted)==false){
     echo "<script>alert('Error: Invalid file format only jpeg, jpg or png is accepted');</script>";
    header("location: update-student-personal-detail.php?id=".$urlEncode."");
 
}
    $passportDate = date("d-m-Y");
    $extension=explode('.', $studPics);
    
    $extension=strtolower(end($extension));
    $pass=uniqid() ;
    $passport='SMARTSCHOOL_'.$surname.'_'.$othernames.'_'.$pass.'_'.$passportDate.'.'.$extension;
      
    if (!empty($studId)) 
  {
     $getPassport=mysqli_query($conn, "SELECT * FROM students WHERE id='$studId'");
    if ($getPassport) 
    {
      while ($result=mysqli_fetch_assoc($getPassport)) 
      {
        $studPass=$result['studPics'];
      }
        if (!empty($studPass)) 
        {
        $path='student_passport/'.$studPass;
         unlink($path);
       }
     }
   if (move_uploaded_file($_FILES['studPics']['tmp_name'],"student_passport/$passport"))
   {

    $update=mysqli_query($conn, "UPDATE `students` SET `surname`='$surname',`othernames`='$othernames',`dob`='$dob',`gender`='$gender',`address`='$studAddress', `ailment`='$ailment',`ailmentDes`='$ailmentDes', `studPics`='$passport' WHERE `school`='$schoolCode' and `id`='$studId'");
    if (mysqli_affected_rows($conn) >0) 
    {
       echo "<script>
       var resp = confirm('Students personal detail updated Successfully. Continue Update');
       if (resp == true)
       {
        window.location.href='update-student-personal-detail.php?id=".$urlEncode."'
       }
       else
       {
        window.location.href='view-admitted-students.php'
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
        echo "<script>alert('Passport could not be uploaded that is all we know. If this persists, please contact the admin');
         window.location.href='update-student-personal-detail.php?id=".$urlEncode."'
         </script>";
       }
  }
      else
      {
        echo "<script>alert('Error: Your request could not be processed. This might be as a result of invalid parameters');</script>";
        header("location: update-student-personal-detail.php?id=".$urlEncode."");
      }



}
if (isset($studPics) && ($studPics)=='') 
{
  if (!empty($studId)) 
  {
     $update2 = mysqli_query($conn, "UPDATE `students` SET `surname`='$surname',`othernames`='$othernames',`dob`='$dob',`gender`='$gender',`address`='$studAddress',`ailment`='$ailment',`ailmentDes`='$ailmentDes' WHERE `school`='$schoolCode' and `id`='$studId'");
    if (mysqli_affected_rows($conn) > 0) 
    {
       
       echo "<script>
       var resp = confirm('Students personal detail updated Successfully. Continue Update');
       if (resp == true)
       {
        window.location.href='update-choice.php?id=".$urlEncode."'
       }
       else
       {
        window.location.href='view-admitted-students.php'
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
        header("location: update-student-personal-detail.php?id=".$urlEncode."");
      }
}
}



if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
    if ($errmsg == '1') {
      $msgerror ='Error: Registration Number cannot be empty!';
    }
   
    elseif($errmsg =='8'){
        $msgerror ='Error: A fatal error occured while trying to process your request! If this error persists, contact admin for guidelines';
    }
    if ($errmsg == '9') {
      $msgerror ='Error: Surname! required!';
    }
    if ($errmsg == '6') {
      $msgerror ='Error: This Registration has already been assigned to another student!';
    }
    elseif($errmsg =='10'){
        $msgerror ='Error: Othernames required! ';
    }
    elseif($errmsg =='12'){
        $msgerror ='Error: Image Upload failed! ';
    }
    
    elseif($errmsg =='17'){
        $msgerror ='Error: Image size too big or too small! Your Picture should be less than 50KB';
    }
    elseif($errmsg =='18'){
        $msgerror ='Error: Invalid image format! Only JPEG, JPG or PNG allowed';
    }
    
    elseif($errmsg =='30'){
        $msgerror ='Error: passport upload failed ';
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
        
      $sql=mysqli_query($conn,"SELECT s.regNum AS reg, s.surname AS sur, s.othernames AS other, s.dob AS dob, s.gender AS sex,s.address AS address, s.ailment AS ail, s.ailmentDes AS aildes, s.admDate AS adate, s.admTime AS atime, s.class AS ac, s.school AS ssc,s.studPics AS pics, c.id AS cid, c.classCode AS cco, c.name AS cn,  sch.id AS schid, sch.name AS schname, sch.motto AS schmo, sch.address AS schad, sch.code AS schco, sch.logo AS schlog
                    from students s
                    INNER JOIN class c
                    ON s.class=c.id 
                    
                    INNER JOIN schools sch
                    ON s.school = sch.id
                    WHERE s.school='$userSchool' and s.id='$studId'");
                      if (mysqli_num_rows($sql)) { 
                        while ($row=mysqli_fetch_assoc($sql)) {
                           
                           
                            $surname=$row['sur'];
                            $others=$row['other'];
                            $reg=$row['reg'];
                            $gender=$row['sex'];
                            $dob=$row['dob'];
                            $address1=$row['address'];
                           
                            $ailment=$row['ail'];
                            $ailmentDes=$row['aildes'];
                            $passport=$row['pics'];
                            

                }
              }
             
               
        ?> 
         
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
              	
                    
                <input type="hidden" name="studId" value="<?php echo $studId; ?>">
                  <input  name="schIdCode"   type="hidden"   value="<?php echo $userSchool; ?>"/>  
               <h3><span class="label label-danger label-mini"><i class="fa fa-user" ></i> Personal Data</span></h3><br>
              <div class="form-group">
                  
                  <label class="control-label col-sm-2">Surname<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="surname" id="surname" type="text" value="<?php echo $surname; ?>" required="">  
                    
                  </div>
                  <label class="control-label col-sm-2" >Othernames<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                    <input class="form-control form-control-inline input-medium " name="othernames" id="othernames" type="text" value="<?php echo $others; ?>"  required="">  
                    
                  </div>
                    
                    
                </div>
                <div class="form-group ">
                   <label class="control-label col-sm-2">Gender<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4">
                    <select class="form-control form-control-inline input-medium " name="gender">
                      <option value="<?php echo $gender; ?>"><?php echo $gender; ?></option>                      
                      <option value="<?php if ($gender=='Male'){
                        echo 'Female';
                      }else
                      {
                        echo('Male');
                      } ?>"><?php if ($gender=='Male'){
                        echo 'Female';
                      }else{echo('Male');
                    } ?>
                        
                      </option>
                    </select>  
                    
                  </div>

                  <label class="control-label col-sm-2">Date of Birth<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-3 col-xs-11">
                    <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="01-01-2000" class="input-append date dpYears">
                      <input type="text" value="<?php echo $dob; ?>" name="dob" size="16" class="form-control" pattern="^(0[1-9]|[12][0-9]|3[01])[-](0[1-9]|1[012])[-](19|20)\d\d$" placeholder="dd-mm-yyyy">
                      <span class="input-group-btn add-on">
                        <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                  </div>
              </div>
                <!--DOB Address and Religion Div--> 
               
                  <!--start of address Div-->
                <div class="form-group">
                 
                  <label class="control-label col-sm-2" >Address <i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                    <input class="form-control form-control-inline input-medium " name="address1" required="" value="<?php echo $address1; ?>" type="text" >  
                    
                  </div><label class="control-label col-sm-2">Any Known Ailment<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label><br>
                  <div class="col-md-4">
                    <select id="ailment" class="form-control form-control-inline input-medium " required="" name="ailment" onchange="description();">
                      <option value="">--Select Option--</option>
                     
                      <?php if ($ailment != '')
                      {
                        
                        echo '
                      <option selected="" value="'.$ailment.'">'.
                      $ailment.'
                      </option>';
                      if ($ailment == 'Yes') 
                      {
                        echo '
                      <option value="No">No</option>';
                      }
                      if ($ailment == 'No') 
                      {
                        echo '
                      <option value="Yes">Yes</option>';
                      }
                     
                    }
                    else
                    {
                      echo '
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>';
                    }
                    ?>
                    </select> 
                 
                  </div>
                 
                   
                </div>
                
                 
                <div class="form-group ">   
                
                  <div style="display: none;" id="describe" class="describe" >
                     <label class="control-label col-sm-2">Ailment Description</label>
                    <div class="col-md-4">
                    <textarea class="form-control form-control-inline input-medium " rows="2" name="ailmentDes" placeholder="Describe Ailment"><?php echo $ailmentDes; ?></textarea> 
                    
                    </div>
                    </div> 
                                  
                  <label class="control-label col-md-3">Upload Students' Picture</label><br>
                  <div class="col-md-4">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                        <img src="student_passport/<?php echo $passport; ?>" alt="" />
                      </div>
                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                        <span class="btn btn-theme02 btn-file">
                          <span class="fileupload-new"><i class="fa fa-undo"></i> Change image</span>
                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                        <input type="file" class="default" name="studPics" />
                        </span>
                        <a href="#" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                      </div>
                    </div>
                    <span class="label label-info">NOTE!</span>
                    <span style="color: red">
                      Picture should either be in JPEG, JPG or PNG format and not more than 50KB
                      </span>
                  </div>
                  
                </div>

              
                 <div class="form-group">
                  <div class="col-md-6">
                 <a  class="btn btn-danger btn-sm pull-left" href="update-choice.php?id=<?php  $urlEncode = rtrim(strtr(base64_encode(gzdeflate($studId, 9)), '+/','-_'),'=') ;
             echo $urlEncode; ?>">&nbsp;<i class="fa fa-arrow-left"></i> Previous </a><br><br>  
                 </div>
                 	<div class="col-md-6">
                 <button type="submit" name='go'  class="btn btn-primary btn-sm pull-right">Update&nbsp;<i class="fa fa-refresh"></i> </button><br><br>  
                 </div>                
                </div>
                <div class="form-group"></div>

                
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
    
    <?php footer();
mysqli_close($conn);
?>
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
 
$(document).ready(function() {
      $('#ailment').on('change', function() {
        if (this.value == 'Yes') {
          $('#describe').show()
        }
        else
        {
          $('#describe').hide()
        }
      })
    })
  	function description() {
  		var x=document.getElementById('des');
      var y=document.getElementById('ailment').value;
  		if (y.value == 'Yes') {
  			x.style.display='block';
  		}else{
  			x.style.display='none';
  		}
  	}
  
  </script>

</body>

</html>
