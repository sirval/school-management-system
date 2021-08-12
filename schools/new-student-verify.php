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
  
  $surname =strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['surname'])));
  $othernames = strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['othernames'])));
  $dob = strip_tags(mysqli_real_escape_string($conn, $_POST['dob']));
  $gender = strip_tags(mysqli_real_escape_string($conn, $_POST['gender']));
  $studAddress = strip_tags(mysqli_real_escape_string($conn, $_POST['address']));
  $ailment = strip_tags(mysqli_real_escape_string($conn, $_POST['ailment']));
  $ailmentDes = strip_tags(mysqli_real_escape_string($conn, $_POST['ailmentDes']));
  $passport = strip_tags(mysqli_real_escape_string($conn, $_POST['passport']));

   
 $parentFname = strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['parentFname'])));
  $parentOthers = strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['parentOthers'])));
  $relation = strip_tags(mysqli_real_escape_string($conn, $_POST['childRelationship']));
  $parentOccup = strip_tags(mysqli_real_escape_string($conn, $_POST['parentOccup']));
  $parentReligion = strip_tags(mysqli_real_escape_string($conn, $_POST['parentReligion']));
  $phone = strip_tags(mysqli_real_escape_string($conn, $_POST['phone']));
  $altPhone = strip_tags(mysqli_real_escape_string($conn, $_POST['altPhone']));
  $email = strip_tags(mysqli_real_escape_string($conn, $_POST['email']));
  $numChild = strip_tags(mysqli_real_escape_string($conn, $_POST['numChild']));
  $parentApp = strip_tags(mysqli_real_escape_string($conn, $_POST['parentApp']));
  $term = strip_tags(mysqli_real_escape_string($conn, $_POST['term']));

  //student detail
  $studPics=$_FILES['studPics']['name'];
  $studPics_size=$_FILES['studPics']['size'];
  $studPics_type=$_FILES['studPics']['type'];
  $maxSize= 51200; //50KB
  $accepted=array('jpeg','jpg', 'png');

  if (!isset($regNum) || trim(strlen($regNum)) =='') 
  {
    header('location: new-student-verify.php?error=1');
    exit();
  }
   if (!isset($term) || trim(strlen($term)) =='') 
  {
    header('location: new-student-verify.php?error=60');
    exit();
  }
  if (!isset($studClass) || trim(strlen($studClass)) =='') 
  {
    header('location: new-student-verify.php?error=2');
    exit();
  }

  if (!isset($surname) || trim(strlen($surname)) =='') 
  {
    header('location: new-student-verify.php?error=9');
    exit();
  }
  if (!isset($othernames) || trim(strlen($othernames)) =='') 
  {
    header('location: new-student-verify.php?error=10');
    exit();
  }
 
 	//parent detail
 if (!isset($parentFname) || trim(strlen($parentFname)) =='') 
 {
    header('location: new-student-verify.php?error=31');
    exit();
  }
  if (!isset($parentOthers) || trim(strlen($parentOthers)) =='') 
  {
    header('location: new-student-verify.php?error=32');
    exit();
  }
  if (preg_match('/^[0-9]{11}+$/', $phone)== false) 
  {
   header('location: new-student-verify.php?error=33');
    exit();
  }
   if (!isset($relation) || trim(strlen($relation)) =='') 
   {
    header('location: new-student-verify.php?error=34');
    exit();
  } 
  if (!isset($parentApp) || trim(strlen($parentApp)) =='') 
  {
    header('location: new-student-verify.php?error=35');
    exit();
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      header('location: new-student-verify.php?error=36');
    exit();
  }  

  //check if student is saved to database
  $auth_stud = mysqli_query($conn, "SELECT students.regNum, parents.phone FROM students, parents WHERE students.regNum='$regNum' and parents.phone='$phone'");
  if (mysqli_num_rows($auth_stud)>0) 
  {
  	header('location: new-student-verify.php?error=44');
    exit();
  }
  
if (empty($studPics)) {
	//move the passport from temporary folder to a permanent folder
	rename("student_temp_passport/".$passport, "student_passport/".$passport);
 
$query2=mysqli_query($conn, "INSERT INTO `students`( `surname`, `othernames`, `dob`, `gender`, `address`, `ailment`, `ailmentDes`, `admDate`, `admTime`, `class`, `school`, `studPics`, `regNum`) VALUES ('$surname', '$othernames','$dob','$gender','$studAddress','$ailment','$ailmentDes','$admDate','$admTime','$studClass','$schoolCode','$passport','$regNum')");
if (mysqli_affected_rows($conn)>0) {
  $lastId= mysqli_insert_id($conn);

$query3=mysqli_query($conn, "INSERT INTO `parents`(`parentFname`, `parentOthers`, `parentOccup`, `parentReligion`, `numChild`, `relationship`, `phone`, `altPhone`, `email`, `appActivation`, `term` ,`regNum`) VALUES ('$parentFname','$parentOthers','$parentOccup','$parentReligion','$numChild','$relation','$phone','$altPhone','$email','$parentApp','$term','$lastId')");

if (mysqli_affected_rows($conn)>0) 
{
$url=base64_encode($regNum);
 header('location: new-student-registration.php?reg-successful='.$url);
 exit();
}
}else{
  header('location: new-student-verify.php?error=8');
    exit();
}
}
//if user changes the preselected image
else
{
  if (($studPics_size>=$maxSize) || $studPics_size=='' ) {
     header('location: new-student-verify.php?error=17');
    exit();
  }
 
  if ((($accepted)==false) || (empty($studPics_type))){
     header('location: new-student-verify.php?error=18');
    exit();
 
}
    $extension=explode('.', $studPics);
    
    $extension=strtolower(end($extension));
    $pass=substr(md5($regNum), 0,5) ;
    $passport=$passport='SMARTSCHOOL_'.$surname.'_'.$othernames.'_'.$pass.'_'.$passportDate.'.'.$extension;
         
      
   (move_uploaded_file($_FILES['studPics']['tmp_name'],"student_passport/$passport"));

$query2=mysqli_query($conn, "INSERT INTO `students`( `surname`, `othernames`, `dob`, `gender`, `address`, `ailment`, `ailmentDes`, `admDate`, `admTime`, `class`, `school`, `studPics`, `regNum`) VALUES ('$surname', '$othernames','$dob','$gender','$studAddress','$ailment','$ailmentDes','$admDate','$admTime','$studClass','$schoolCode','$passport','$regNum')");
if (mysqli_affected_rows($conn)>0) {
  $last_Id = mysqli_insert_id($conn);

$query3=mysqli_query($conn, "INSERT INTO `parents`(`parentFname`, `parentOthers`, `parentOccup`, `parentReligion`, `numChild`, `relationship`, `phone`, `altPhone`, `email`, `appActivation`,`term`, `regNum`) VALUES ('$parentFname','$parentOthers','$parentOccup','$parentReligion','$numChild','$relation','$phone','$altPhone','$email','$parentApp','$term','$lastId')");

  if (mysqli_affected_rows($conn)>0) {
 $url=base64_encode($regNum);
 header('location: new-student-registration.php?reg-successful='.$url);
 exit();
}
}else{
  header('location: new-student.php?error=8');
    exit();
}
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
    
    //parent details error notification
    elseif($errmsg =='31'){
        $msgerror ='Warning: Parent Firstname required! ';
    }
    elseif($errmsg =='32'){
        $msgerror ='Warning: Parent Othernames required! ';
    }
    elseif($errmsg =='33'){
        $msgerror ='Warning: Parent Phone Number required! And must be exactly 11 digits';
    }
    elseif($errmsg =='34'){
        $msgerror ='Warning: The Relationship between parent and student is required';
    }
    elseif($errmsg =='35'){
        $msgerror ='Warning: Please select if you would like to activate our parent App';
    }
    elseif($errmsg =='36'){
        $msgerror ='Warning: Valid Email Required';
    }

   //student detail error notification
    elseif($errmsg =='8'){
        $msgerror ='Error: A fatal error occured while trying to process your request! If this error persists, contact admin for guidelines';
    }
    elseif ($errmsg == '9') {
      $msgerror ='Warning: Student Surname! required!';
    }
    elseif ($errmsg == '6') {
      $msgerror ='Warning: This Admission Number has already been assigned to a student! Consider entering anoher value';
    }
    elseif($errmsg =='10'){
        $msgerror ='Warning: Student Othernames required! ';
    }
    elseif($errmsg =='60'){
        $msgerror ='Warning: Enter the term for Notification';
    }
    elseif($errmsg =='17'){
        $msgerror ='Warning: Image size too big or too small! Your Picture should be less than 50KB';
    }
    elseif($errmsg =='18'){
        $msgerror ='Warning: Invalid image format! Only JPEG, JPG or PNG allowed';
    }
    
    elseif($errmsg =='30'){
        $msgerror ='Warning: passport upload failed ';
    }
    elseif($errmsg =='44'){
        $msgerror ='Warning: Seems this student has already been registered. Click<a class="btn btn-danger btn-sm" href="view-admitted-students.php"> Here</a> to confirm';
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
        $studClass=$_SESSION['studClass'];
         $sql=mysqli_query($conn,"SELECT * from class WHERE id = $studClass");
            if (mysqli_num_rows($sql)>0 ) 
            {           
               while($getClass = mysqli_fetch_array($sql))
               {
               	$className=$getClass['name'];
               }
           }


        $admDate=$_SESSION['admDate'];
        $admTime=$_SESSION['admTime'];
        $schoolCode=$_SESSION['schoolCode'];
        $surname=$_SESSION['studSurname'];
        $othernames=$_SESSION['studOthername'];
        $dob=$_SESSION['dob'];
        $studAddress=$_SESSION['studAddress'];
        $gender=$_SESSION['studGender'];
        $ailment=$_SESSION['ailment'];
        $ailmentDes=$_SESSION['ailmentDes'];
        $passport=$_SESSION['passport'] ;
        $image=$_SESSION['image'] ;
        $parentFname=$_SESSION['parentFname'] ;
        $parentOthers=$_SESSION['parentOthers'];
        $phone=$_SESSION['phone'];
        $altPhone=$_SESSION['altPhone'] ;
        $relation=$_SESSION['relation'];
        $parentApp=$_SESSION['parentApp'];
        $email=$_SESSION['email'];
        $numChild=$_SESSION['numChild'] ;
        $parentReligion=$_SESSION['parentReligion'];
        $parentOccup=$_SESSION['parentOccup'];
        $term = $_SESSION['notiTerm'];
      }
      else
      {
        header('location:new-student-parent.php?error=40');
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
        <div>
          
        </div>
        
              <div class="progress progress-striped active">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%">
                  
                </div>
               <span class="">4 Of 4 steps Complete</span>
            </div>
            <br><br>
            <h1 style="text-align: center;"><span class="label label-info label-mini"><span class="badge bg-important"><i class="fa fa-info" ></i></span> Input Verification</span></h1><br>
            <p class="pull-right">[<i style="color: red; font-weight: bolder; font-size: 20px">*</i> indicates required values]</p>
            
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
              	<input type="hidden" name="passport" value="<?php echo $passport ?>">
              	 <h3><span class="label label-primary label-mini"><i class="fa fa-university" ></i> Admission Data</span></h3><br>
              	<div class="form-group">
                  <label class="control-label col-sm-1">Class <i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-5">                    
                    <select readonly="" class="form-control form-control-inline " name="studClass" id="userClass" required="">
                    	<option value="<?php echo $studClass; ?>"><?php echo $className;?></option>
                      
                    </select>
            		</div>
                <label class="control-label col-sm-1">Admission Date</label>
                  <div class="col-md-5 ">
                    <input class="form-control form-control-inline input-medium " name="admDate" id="admissionDate" type="text" readonly="" value="<?php echo $admDate; ?>">  
                    
                  </div>
                  <input  name="schIdCode"   type="hidden"  value="<?php echo $userSchool; ?>"/>  
                  
                </div>


                <div class="form-group">
                   <label class="control-label col-sm-1">Admission Time</label> 
                  <div class="col-md-5">
                     
                    <input class="form-control form-control-inline input-medium " name="admTime" id="admissionTime"  type="text" readonly="" value="<?php echo $admTime; ?>">  
                    
                  </div>

                    <label class="control-label col-sm-1">Admission Number <i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-5">
                    <div class="input-append">
                    <input readonly="" autocomplete="off" class="form-control form-control-inline input-medium " placeholder="Admission Number" name="regNum" id="regNum"  type="text" required="" id="regNum" value="<?php echo strtoupper($regNum); ?>" >  
                    
                        
                       
                  </div>
                  </div>
            </div>
              	<!--End of Admission Detail-->
              	<h3><span class="label label-danger label-mini"><i class="fa fa-user" ></i> Personal Data</span></h3><br>
              <div class="form-group">
                  
                  <label class="control-label col-sm-2">Surname <i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="surname" id="surname" type="text" value="<?php echo $surname; ?>">  
                    
                  </div>
                  <label class="control-label col-sm-2" >Othernames <i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                    <input class="form-control form-control-inline input-medium " name="othernames" id="othernames" type="text" value="<?php echo $othernames; ?>" >  
                    
                  </div>
                    
                    
                </div>
                
                  <!--start of address Div-->
                <div class="form-group">
                  <label class="control-label col-sm-2">Gender <i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4">
                    <select class="form-control form-control-inline input-medium " name="gender">
                      
                      <option value="<?php if($gender == 'Male') 
                    {
                    	echo 'Male';
                    }else{
                    	echo 'Female';
                    } ?>"><?php 
                    if($gender == 'Male') 
                    {
                    	echo 'Male';
                    }else{
                    	echo "Female";
                    } ?></option>
                    <option value="<?php 
                    if($gender == 'Male') 
                    {
                    	echo 'Female';
                    }else{
                    	echo 'Male';
                    }  ?>"><?php 
                    if($gender == 'Male') 
                    {
                    	echo 'Female';
                    }else{
                    	echo "Male";
                    } ?></option>
                  </select>
                    
                  </div>
                  <label class="control-label col-sm-2">Date of Birth <i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-3 col-xs-11">
                    <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="01-01-2000" class="input-append date dpYears">
                      <input type="text"  name="dob" size="16" class="form-control" pattern="^([1-9]|[12][0-9]|3[01])[-]([1-9]|1[012])[-](19|20)\d\d$" placeholder="dd-mm-yyyy" value="<?php echo $dob; ?>">
                      <span class="input-group-btn add-on">
                        <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                  </div>
                 
                </div>

                <div class="form-group">
                   <label class="control-label col-sm-2" >Address<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                    <input class="form-control form-control-inline input-medium " required="" name="address" type="text" value="<?php echo $studAddress; ?>">  
                    
                  </div>
                  <label class="control-label col-sm-2">Any Known Ailment<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label><br>
                  <div class="col-md-4">
                    <select class="form-control form-control-inline input-medium " required="" name="ailment" onchange="description();">
                      <option value="<?php if($ailment == 'Yes') 
                    {
                    	echo 'Yes';
                    }else{
                    	echo 'No';
                    } ?>"><?php 
                    if($ailment == 'Yes') 
                    {
                    	echo 'Yes';
                    }else{
                    	echo "No";
                    } ?></option>
                    <option value="<?php 
                    if($ailment == 'Yes') 
                    {
                    	echo 'No';
                    }else{
                    	echo 'Yes';
                    }  ?>"><?php 
                    if($ailment == 'Yes') 
                    {
                    	echo 'No';
                    }else{
                    	echo "Yes";
                    } ?></option>
                      
                    </select> 
                 
                  </div>
                 
                   
                </div>
                
                 
                <div class="form-group ">   
                
                  <div id="des">
                     <label class="control-label col-sm-2">Ailment Description</label>
                    <div class="col-md-4">
                    <textarea class="form-control form-control-inline input-medium " rows="2" name="ailmentDes" placeholder="Describe Ailment"><?php echo $ailmentDes; ?></textarea> 
                    
                    </div> 
                    </div>                              
                  <label class="control-label col-md-2">Upload Students' Passport<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label><br>
                  <div class="col-md-4">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                        <img src="<?php echo 'student_temp_passport/'.$passport;?>"  alt="Passport"> 
                      </div>
                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                        <span class="btn btn-danger btn-file">
                          <span class="fileupload-new"><i class="fa fa-undo"></i> Change Passport</span>
                        
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
                
                <!--End of students Profile-->
              	<!--Parents Details-->
                <h3><span class="label label-primary label-mini"><i class="fa fa-users" ></i> Parents'/Guidians' Data</span></h3><br><br>
                <!--start of parents Div-->
                <div class="form-group">
                  <label class="control-label col-sm-1">Firstname<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-5">
                    <input class="form-control form-control-inline input-medium " name="parentFname" type="text" required="" value="<?php echo($parentFname); ?>" > <br> 
                    
                  </div>
                  <label class="control-label col-sm-1" >Othernames<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-5 ">
                    <input class="form-control form-control-inline input-medium " name="parentOthers" type="text" required="" value="<?php echo($parentOthers); ?>"><br>  
                    
                  </div>
                   
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-1">Relationship<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-5">
                    <select required="" class="form-control form-control-inline input-medium " name="childRelationship" >
                    	<?php if ($relation=='Parent')
                    	{
                    	echo'
                    	<option value="Parent">'.'Parent'.'</option>';
                    	
                    	?>
                    	<option value="Guidian">Guidian</option>
                    	<option value="Relative">Relative</option>
                    	<?php
                    }?>
                    <?php if ($relation=='Guidian')
                    	{
                    	echo'
                    	<option value="Guidian">'.'Guidian'.'</option>';
                    	
                    	?>
                    	<option value="Guidian">Parent</option>
                    	<option value="Relative">Relative</option>
                    	<?php
                    }?>
                    <?php if ($relation=='Relative')
                    	{
                    	echo'
                    	<option value="Relative">'.'Relative'.'</option>';
                    	
                    	?>
                    	<option value="Guidian">Guidian</option>
                    	<option value="Parent">Parent</option>
                    	<?php
                    }?>
                      
                    </select>                  
                 
                  </div>

                    <label class="control-label col-sm-1">Occupation</label>
                  <div class="col-md-5">
                    <input class="form-control form-control-inline input-medium "  name="parentOccup" type="text" value="<?php echo($parentOccup); ?>"><br>  
                    
                  </div>
              </div>

              <div class="form-group">

                  <label class="control-label col-sm-1">Religion</label>
                  <div class="col-md-5">
                    <input class="form-control form-control-inline input-medium " name="parentReligion" type="text" value="<?php echo($parentReligion); ?>" ><br>  
                    
                  </div> 

                <label class="control-label col-sm-3">Number of Child in our School</label>
                  <div class="col-md-3">
                    <select class="form-control form-control-inline input-medium " name="numChild">
                    <?php if ($numChild=='1')
                    	{
                    	echo'
                    	<option value="1">'.'1'.'</option>';
                    	
                    	?>
                    	<option value="2">2</option>
                    	<option value="3">3</option>
                    	<option value="4">4</option>
                    	<option value="5">5</option>
                    	<?php
                    }?>
                    <?php if ($numChild=='2')
                    	{
                    	echo'
                    	<option value="2">'.'2'.'</option>';
                    	
                    	?>
                    	<option value="1">1</option>
                    	<option value="3">3</option>
                    	<option value="4">4</option>
                    	<option value="5">5</option>
                    	<?php
                    }?>
                    <?php if ($numChild=='3')
                    	{
                    	echo'
                    	<option value="3">'.'3'.'</option>';
                    	
                    	?>
                    	<option value="1">1</option>
                    	<option value="2">2</option>
                    	<option value="4">4</option>
                    	<option value="5">5</option>
                    	<?php
                    }?>
                    <?php if ($numChild=='4')
                    	{
                    	echo'
                    	<option value="4">'.'4'.'</option>';
                    	
                    	?>
                    	<option value="1">1</option>
                    	<option value="2">2</option>
                    	<option value="3">3</option>
                    	<option value="5">5</option>
                    	<?php
                    }?>

                    <?php if ($numChild=='5')
                    	{
                    	echo'
                    	<option value="5">'.'5'.'</option>';
                    	
                    	?>
                    	<option value="1">1</option>
                    	<option value="2">2</option>
                    	<option value="4">4</option>
                    	
                    	<?php
                    }?>
                    </select> <br>
                  </div> 
                

                </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Phone Number<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4">
                  <input type="tel" required="" class="form-control form-control-inline input-medium" name="phone" value="<?php echo($phone); ?>" onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57">
                                                 
                    
                  </div>

                <label class="control-label col-sm-2">Alternate Phone</label>
                  <div class="col-md-4">
                  <input type="tel" value="<?php echo($altPhone); ?>" class="form-control form-control-inline input-medium" name="altPhone"  onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57">
                                                 
                    
                  </div>
                  
                  
              </div>

              
                 <div class="form-group">
                  <label class="control-label col-sm-1">Email<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-2">
                  <input required="" type="email" class="form-control form-control-inline input-medium" name="email" value="<?php echo($email); ?>" >
                     </div>                            
                    <label class="control-label col-sm-3">Would you like to be notified about your child?<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-2">
                  <select required="" class="form-control form-control-inline" name="parentApp">
                    <option value="<?php if($parentApp == 1) 
                    {
                    	echo 1;
                    }else{
                    	echo 0;
                    } ?>"><?php 
                    if($parentApp == 1) 
                    {
                    	echo 'Yes';
                    }else{
                    	echo "No";
                    } ?></option>
                    <option value="<?php 
                    if($parentApp == 0) 
                    {
                    	echo 0;
                    }else{
                    	echo 1;
                    }  ?>"><?php 
                    if($parentApp == 0) 
                    {
                    	echo 'Yes';
                    }else{
                    	echo "No";
                    } ?></option>
                  </select>         
                </div>
                <label class="control-label col-sm-2">Notification Term:<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                <div class="col-md-2">
                    <select class="form-control form-control-inline input-medium "  name="term" id="term" required="">
                      <option>--Select Term--</option>
                       <?php if ($term != '')
                      {
                        echo '
                      <option selected="" value="'.$term.'">1st Term
                      </option>';
                      if ($term == '1') 
                      {
                        echo '
                      <option value="2">2nd Term</option>
                      <option value="3">3rd Term</option>';
                      }
                      if ($term == '2') 
                      {
                        echo '
                      <option value="1">1st Term</option>
                      <option value="3">3rd Term</option>';
                      }
                      if ($term == '3') 
                      {
                        echo '
                      <option value="1">1st Term</option>
                      <option value="2">2nd Term</option>';
                      }
                      
                    }
                    else
                    {
                      echo '
                      <option value="1">1st Term</option>
                      <option value="2">2nd Term</option>
                      <option value="3">3rd Term</option>';
                  }
                  ?>
                    </select><br>  
                     
                  </div> 
              </div>

                <div class="form-group">
                	<div class="col-md-6">
                 <a  data-toggle="modal" class="btn btn-danger btn-sm pull-left" href="new-student-verify.php#back">&nbsp;<i class="fa fa-arrow-left"></i> Previous </a><br><br>  
                 </div>
                 
                  <div class="col-md-6">
                 <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="new-student-verify.php#myModal">Save&nbsp;<i class="fa fa-save"></i> </a><br><br>  
                 </div>

                </div>
                <div class="form-group"></div>

                 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm!</h4>
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
                <a href="<?php echo 'new-student-parent.php?userDetail='.base64_encode($regNum); ?>" class="btn btn-theme" >Yes</a>
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
