<?php
require '../db/db_con.php';
if (isset($_POST['go'])) {
  $name=strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['name'])));
  $motto= strip_tags(mysqli_real_escape_string($conn, $_POST['motto']));
  $address=strip_tags(mysqli_real_escape_string($conn, $_POST['address']));
  $shortCode=strip_tags(mysqli_real_escape_string($conn, $_POST['shortCode']));
   $username= strip_tags(mysqli_real_escape_string($conn, $_POST['username']));
  $password=strip_tags(mysqli_real_escape_string($conn, $_POST['password']));
  $username1= strip_tags(mysqli_real_escape_string($conn, $_POST['username1']));
  $password1=strip_tags(mysqli_real_escape_string($conn, $_POST['password1']));
  $username2= strip_tags(mysqli_real_escape_string($conn, $_POST['username2']));
  $password2=strip_tags(mysqli_real_escape_string($conn, $_POST['password2']));
  $strdate= strip_tags(mysqli_real_escape_string($conn, $_POST['strdate']));
  $enrdate=strip_tags(mysqli_real_escape_string($conn, $_POST['enrdate']));
  $phone = strip_tags(mysqli_real_escape_string($conn, $_POST['phone']));
  $id=$_POST['id'];
  $roleId=$_POST['roleId'];
  $roleId1=$_POST['roleId1'];
  $roleId2=$_POST['roleId2'];


  $logo=$_FILES['logo']['name'];
  $logoSize=$_FILES['logo']['size'];
  $logoType=$_FILES['logo']['type'];
  $maxSize= 51200;//50Kb
  $accepted=array('jpeg','jpg', 'png');

  if (!isset($id) || strlen($id)=='') {
    echo "<script>alert('Registration number not found');</script>";
    exit();
  }
   if (!isset($strdate) || strlen($strdate)=='') {
    echo "<script>alert('Installed Date field cannot be empty');</script>";
    exit();
  }
  if (!isset($enrdate) || strlen($enrdate)=='') {
     echo "<script>alert('End Date field cannot be empty');</script>";
    exit();
  }
  if (preg_match('/^[0-9]{11}+$/', $phone)== false) {
  echo "<script>alert('Phone number is required and must be exactly 11 digits');</script>";
    exit();
  }

   if (!isset($username) || strlen($username)<4) {
     echo "<script>alert('username field cannot be empty');</script>";
    exit();
  }
  $uppercase= preg_match('@[A-Z]@', $password);
  $lowercase= preg_match('@[a-z]@', $password);
  
   if (!$uppercase || !$lowercase) {
    echo "<script>alert('Password field cannot be empty and must contain at least 1 uppercase and lowercase');</script>";
    exit();
  }

  if (!isset($name) || strlen($name)<10) {
     echo "<script>alert('School name field cannot be empty or less than characters');</script>";
    exit();
  }

   if (!isset($motto) || strlen($motto)<5) {
     echo "<script>alert('School motto field cannot be empty or less than 5 characters');</script>";
  }

   if (!isset($address) || strlen($address)<5) {
    echo "<script>alert('Address field cannot be empty or less than 5 characters');</script>";
    exit();
  }

   if (!isset($shortCode) || strlen($shortCode)<3) {
     echo "<script>alert('Short code field cannot be empty or less than 3 characters');</script>";
    exit();
  }
  if (isset($logo) && ($logo)!='') {
   if ($logoSize>=$maxSize)  {
      echo "<script>alert('School logo field cannot be more 50KB');</script>";
    exit();
  }
 
  if (($accepted)==false){
     echo "<script>alert('Invalid file format. Only jpeg, jpg or png is accepted');</script>";
    exit();
  }
  $extension=explode('.', $logo);    
    $extension=strtolower(end($extension));
    $logoUpload='schools_'.$shortCode.'_'.uniqid().'_LOGO'.'.'.$extension;

  if(move_uploaded_file($_FILES['logo']['tmp_name'],"../schools/logo/$logoUpload"))
  {  
  $query=mysqli_query($conn, "UPDATE `schools` SET `name`='$name',`motto`='$motto',`address`='$address',`code`='$shortCode',`logo`='$logoUpload', `schPhone`='$phone' WHERE `id`='$id'");
  $query2=mysqli_query($conn, "UPDATE `users` SET `username`='$username',`password`='$password' WHERE `roleId`='$roleId' and schoolId='$id'");
  $query4=mysqli_query($conn, "UPDATE `users` SET `username`='$username1',`password`='$password1' WHERE `roleId`='$roleId1' and schoolId='$id'");
  $query5=mysqli_query($conn, "UPDATE `users` SET `username`='$username2',`password`='$password2' WHERE `roleId`='$roleId2' and schoolId='$id'");
  $query3=mysqli_query($conn, "UPDATE `elapse_time` SET `startDate`='$strdate',`endDate`='$enrdate' WHERE `schoolId`='$id'");

  if (mysqli_affected_rows($conn)>0) {
     echo "<script>alert('Update Successful');
     window.location.href='all-registered-school.php';
     </script>";
     exit();
  }
  else{
      echo "<script>alert('An error occured while trying to process your request. Click ok to Complete your request ');</script>";
    exit();
  }
}
else{
    echo "<script>alert('File upload failed');</script>";
    exit();
}
}
if (isset($logo) && ($logo)=='') {
   
     $query=mysqli_query($conn, "UPDATE `schools` SET `name`='$name',`motto`='$motto',`address`='$address',`code`='$shortCode', `schPhone`='$phone' WHERE `id`='$id'");

  $query2=mysqli_query($conn, "UPDATE `users` SET `username`='$username',`password`='$password' WHERE `roleId`='$roleId'");
  $query4=mysqli_query($conn, "UPDATE `users` SET `username`='$username1',`password`='$password1' WHERE `roleId`='$roleId1' and schoolId='$id'");
  $query5=mysqli_query($conn, "UPDATE `users` SET `username`='$username2',`password`='$password2' WHERE `roleId`='$roleId2' and schoolId='$id'");
  $query3=mysqli_query($conn, "UPDATE `elapse_time` SET `startDate`='$strdate',`endDate`='$enrdate' WHERE `schoolId`='$id'");

  if (mysqli_affected_rows($conn)>0) {
     echo "<script>alert('Update Successful');
     window.location.href='all-registered-school.php';
     </script>";
     exit();
  }
  else{
      echo "<script>alert('An error occured while trying to process your request. Click ok to Complete your request');
      window.location.href='all-registered-school.php';</script>";
    exit();
  }

  }else{

  echo "<script>alert('Error: er');</script>";
  header('location: all-registered-school.php');
    exit();
  }
}

require '../controller/admin_required.php'; 
  
$userId=$_SESSION['usersn'];
siteTitle(mysite, ' || ', ' Super Admin'.' || ' . $_SESSION['username']);
 $pagename='new-school';
   meta();
    pageHeader();
   sideBar();
    if ($_GET['id'] && $_GET['id']!='') {
            
     $id=$_GET['id'];
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
         <?php 


                  $sql=mysqli_query($conn,"SELECT s.id AS si, s.name as sn,s.motto as sm,s.address as sa,s.code as sc, s.logo as sl, u.id as ui, u.username as uu, u.roleId as rId, u.password as up,u.schoolId as us, et.endDate as ete, et.schoolId as ets, et.startDate as etsd
                    FROM 
                    schools s 
                    INNER JOIN users u
                    ON s.id=u.schoolId
                    INNER JOIN elapse_time et
                    ON s.id=et.schoolId
                    WHERE s.id='$id' AND u.schoolId='$id' AND u.roleId=1");
                      if (mysqli_num_rows($sql)) {
                        
                       while($row = mysqli_fetch_array($sql)){
                        $name=$row['sn'];
                        $logo=$row['sl'];
                        $motto=$row['sm'];
                        $address=$row['sa'];
                        $code=$row['sc'];
                        $password=$row['up'];
                        $roleId=$row['rId'];
                        $username=$row['uu'];
                        $startDate=$row['etsd'];
                        $endDate=$row['ete'];
                        $id=$row['si'];
                      }}
                      ?>
       
        <h3><span class="label label-primary label-mini"><i class="fa fa-university" ></i> School Data</span></h3><br>
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                <input type="text" hidden="hidden" value="<?php echo $id; ?>" name="id">
                <input type="text" hidden="hidden" value="<?php echo $roleId; ?>" name="roleId">
              	
              <div class="form-group">
                  
                  <label class="control-label col-sm-2">School Name</label>
                  <div class="col-md-10">
                    <input class="form-control form-control-inline input-medium " name="name" id="name" value="<?php echo $name; ?>" type="text" placeholder="Outsmart Ideas" required="">  
                    
                  </div>
                </div>

                <div class="form-group">
                  
                  <label class="control-label col-sm-2">School Motto</label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="motto" value="<?php echo $motto; ?>" id="motto" type="text" placeholder="Working Smart" required=""> 
                  </div>
                  <label class="control-label col-sm-2">School Phone</label>
                  <div class="col-md-4">
                    <input type="tel" required="" class="form-control form-control-inline input-medium" name="phone"  onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57">
                  </div>
                </div>

                <div class="form-group">
                  
                  <label class="control-label col-sm-2">School Address</label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="address" id="address" value="<?php echo $address; ?>" type="text" placeholder="#55 example road" required="">  
                    
                  </div>

                   <label class="control-label col-sm-2">School Short Code</label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="shortCode" value="<?php echo $code; ?>" id="shortCode" type="text" placeholder="OSID" required="">  
                    
                  </div>
                </div>
                 
                <div class="form-group ">                                  
                  <label class="control-label col-md-3"> School Logo</label><br>
                  <div class="col-md-4">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                        <img src="../schools/logo/<?php echo $logo; ?>" alt="" />
                      </div>
                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                        <span class="btn btn-theme02 btn-file">
                          <span class="fileupload-new"><i class="fa fa-undo"></i> Change Logo</span>
                       
                        <input type="file" class="default" name="logo" />
                        </span>
                        
                      </div>
                    </div>
                    <span class="label label-info">NOTE!</span>
                    <span style="color: red">
                      Picture should either be in JPEG, JPG or PNG format and not more than 50KB
                      </span>
                  </div>
                </div>
                <h3><span class="label label-danger label-mini"><i class="fa fa-user" ></i> User 1- Main User</span></h3><br>
                  <div class="form-group">
                  
                  <label class="control-label col-sm-1">Username</label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="username" id="username" value="<?php echo $username; ?>" type="text" placeholder="username" required="">  
                    
                  </div>

                   <label class="control-label col-sm-1">Password</label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="password" value="<?php echo $password; ?>" id="password" type="password" placeholder="Password" required="">  
                    
                  </div>
                </div>
                <button  class="btn btn-theme02 btn-sm" type="button" onclick="updateAll();"> Update All Users</button><br><br><br>
                <div id="allUsers" style="display: none">
                  <?php

                  $sql=mysqli_query($conn,"SELECT s.id AS si, s.name as sn,s.motto as sm,s.address as sa,s.code as sc, s.logo as sl, u.id as ui, u.username as uu, u.roleId as rId, u.password as up,u.schoolId as us, et.endDate as ete, et.schoolId as ets, et.startDate as etsd
                    FROM 
                    schools s 
                    INNER JOIN users u
                    ON s.id=u.schoolId
                    INNER JOIN elapse_time et
                    ON s.id=et.schoolId
                    WHERE s.id='$id' AND u.schoolId='$id' AND u.roleId=2");
                      if (mysqli_num_rows($sql)) {
                        
                       while($row = mysqli_fetch_array($sql)){
                        
                        $password1=$row['up'];
                        $roleId1=$row['rId'];
                        $username1=$row['uu'];
                        
                      }}
                      ?>
                  <h3><span class="label label-theme label-mini"><i class="fa fa-user" ></i> User 2- School Clerk</span></h3><br>
                  <div class="form-group">
                  <label class="control-label col-sm-1">Username</label>
                  <div class="col-md-4">
                    <input type="text" hidden="" name="roleId1"  value="<?php echo $roleId1; ?>">
                    <input class="form-control form-control-inline input-medium " name="username1" id="username" value="<?php echo $username1; ?>" type="text" placeholder="username1" >  
                    
                  </div>

                   <label class="control-label col-sm-1">Password</label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="password1" value="<?php echo $password1; ?>" id="password1" type="password" placeholder="Password" required="">  
                    
                  </div>
                </div>
                <h3><span class="label label-primary label-mini"><i class="fa fa-user" ></i> User 3- Other Staff</span></h3><br>
                <?php

                  $sql=mysqli_query($conn,"SELECT s.id AS si, s.name as sn,s.motto as sm,s.address as sa,s.code as sc, s.logo as sl, u.id as ui, u.username as uu, u.roleId as rId, u.password as up,u.schoolId as us, et.endDate as ete, et.schoolId as ets, et.startDate as etsd
                    FROM 
                    schools s 
                    INNER JOIN users u
                    ON s.id=u.schoolId
                    INNER JOIN elapse_time et
                    ON s.id=et.schoolId
                    WHERE s.id='$id' AND u.schoolId='$id' AND u.roleId=3");
                      if (mysqli_num_rows($sql)) {
                        
                       while($row = mysqli_fetch_array($sql)){
                        
                        $password2=$row['up'];
                        $roleId2=$row['rId'];
                        $username2=$row['uu'];
                        
                      }}
                      ?>
                <div class="form-group">
                  <label class="control-label col-sm-1">Username</label>
                  <div class="col-md-4">
                    <input type="text" hidden="" name="roleId2"  value="<?php echo $roleId2; ?>">
                    <input class="form-control form-control-inline input-medium " name="username2" id="username2" value="<?php echo $username2; ?>" type="text" placeholder="username" >  
                    
                  </div>

                   <label class="control-label col-sm-1">Password</label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="password2" value="<?php echo $password2; ?>" id="password2" type="password" placeholder="Password" > 
                  </div>
                </div>
                </div>
                <div class="form-group ">
                  <label class="control-label col-sm-2">Installed Date</label>
                  <div class="col-md-8 col-xs-11">
                    <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="01-09-2020" class="input-append date dpYears">
                      <input type="text" value="<?php echo $startDate; ?>" readonly="" name="strdate" size="16" class="form-control">
                      <span class="input-group-btn add-on">
                        <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                  </div>
              </div>
                 <div class="form-group ">
                  <label class="control-label col-sm-2">Expiration Date</label>
                  <div class="col-md-8 col-xs-11">
                    <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="01-01-2021" class="input-append date dpYears">
                      <input type="text" readonly="" value="<?php echo $endDate; ?>" name="enrdate" size="16" class="form-control">
                      <span class="input-group-btn add-on">
                        <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                  </div>
              </div>
                 <div class="form-group">
                 	<div class="col-md-12">
                    
                 <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="new-school.php#myModal">Update&nbsp;<i class="fa fa-arrow-right"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>  
                 </div>                
                </div>

                 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm Update!</h4>
              </div>
              <p style="font-size: 20px;">Are you sure you want to proceed?</p>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                <button class="btn btn-theme" type="submit" name="go">Yes</button>
              </div>
            </div>
          </div>
        </div>
              </form><br><br>
            <?php }else{echo "<script>alert('error');
            window.location.href='all-registered-school.php';

            </script>";}?>
          </div>
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

   <!-- js placed at the end of the document so the pages load faster -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="lib/jquery.scrollTo.min.js"></script>
  <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
  <!--common script for all pages-->
  <script src="lib/common-scripts.js"></script>
  <!--script for this page-->
  <script src="lib/jquery-ui-1.9.2.custom.min.js"></script>
  <script type="text/javascript" src="lib/bootstrap-fileupload/bootstrap-fileupload.js"></script>
  <script type="text/javascript" src="lib/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="lib/bootstrap-daterangepicker/date.js"></script>
  <script type="text/javascript" src="lib/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script type="text/javascript" src="lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
  <script type="text/javascript" src="lib/bootstrap-daterangepicker/moment.min.js"></script>
  <script type="text/javascript" src="lib/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
  <script src="lib/advanced-form-components.js"></script>
<script type="text/javascript">
  function updateAll() {
      var x=document.getElementById('allUsers');
      if (x.style.display==='none') {
        x.style.display='block';
      }else{
        x.style.display='none';
      }
    }
</script>
</body>

</html>
