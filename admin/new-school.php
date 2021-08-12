<?php
require '../db/db_con.php';
if (isset($_POST['go'])) {
  $name=strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['name'])));
  $motto= strip_tags(mysqli_real_escape_string($conn, $_POST['motto']));
  $address=strip_tags(mysqli_real_escape_string($conn, $_POST['address']));
  $shortCode=strip_tags(mysqli_real_escape_string($conn, $_POST['shortCode']));
  $phone = strip_tags(mysqli_real_escape_string($conn, $_POST['phone']));
  
  $schoolCode = mt_rand(0, 9999);
  $logo=$_FILES['logo']['name'];
  $logoSize=$_FILES['logo']['size'];
  $logoType=$_FILES['logo']['type'];
  $maxSize= 51200;//50Kb
  $accepted=array('jpeg','jpg', 'png');


   if (($logoSize>=$maxSize) || ($logoSize==0)) {
     header('location: new-school.php?error=1');
    exit();
  }
  if (preg_match('/^[0-9]{11}+$/', $phone)== false) {
   header('location: nnew-school.php?error=12');
    exit();
  }
 
  if ((($accepted)==false) || (empty($logoType))){
     header('location: new-school.php?error=2');
    exit();
  }
  if (!isset($name) || strlen($name)<10) {
    header('location: new-school.php?error=3');
    exit();
  }

   if (!isset($motto) || strlen($motto)<5) {
    header('location: new-school.php?error=4');
    exit();
  }

   if (!isset($address) || strlen($address)<5) {
    header('location: new-school.php?error=5');
    exit();
  }

   if (!isset($shortCode) || strlen($shortCode)<3) {
    header('location: new-school.php?error=6');
    exit();
  }
  $extension=explode('.', $logo);    
    $extension=strtolower(end($extension));
    $logoUpload='schools_'.$shortCode.'_'.uniqid().'_LOGO'.'.'.$extension;

    $auth=mysqli_query($conn, "SELECT * FROM schools WHERE name='$name' and schPhone='$phone'");
    if (mysqli_num_rows($auth)>0) {
       header('location: new-school.php?error=9');
    exit();
    }
  if(move_uploaded_file($_FILES['logo']['tmp_name'],"../schools/logo/$logoUpload"))
  {  
  $query=mysqli_query($conn, "INSERT INTO `schools`(`id`,`name`, `motto`, `address`, `code`, `logo`, `schPhone`) VALUES ('$schoolCode','$name', '$motto' , '$address' , '$shortCode' , '$logoUpload', '$phone')");
  if (mysqli_affected_rows($conn)>0) {
    header('location: new-school-users.php');
  }
  else{
     header('location: new-school.php?error=7');
    exit();
  }
}
else{
   header('location: new-school.php?error=8');
    exit();
}
}
if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
    if ($errmsg == '1') {
      $msgerror ='Error: School Logo must not be more than 50KB!';
    }
    elseif($errmsg =='2'){
        $msgerror ='Error: Logo format is not accepted! ';
    }
    elseif($errmsg =='3'){
        $msgerror ='Error: School name is too short!';
    }

    elseif($errmsg =='4'){
        $msgerror ='Error: School Motto is too short!';
    }
     elseif($errmsg =='5'){
        $msgerror ='Error: School Address is too short! ';
    }
    elseif($errmsg =='6'){
        $msgerror ='Error: School short code is too short!';
    }
    elseif($errmsg =='7'){
        $msgerror ='Error: A fatal error occured while trying to process your request! If this error persists, contact admin for guidelines!';
    }
    elseif($errmsg =='8'){
        $msgerror ='Error: Logo upload failed! If this persists, contact admin for more details';
    }
    elseif($errmsg =='9'){
        $msgerror ='Error: Seems this school already exists';
    }
    elseif($errmsg =='12'){
        $msgerror ='Error: Phone Number is required and must be exactly 11 digits';
    }
  }

require '../controller/admin_required.php'; 
  
$userId=$_SESSION['usersn'];
siteTitle(mysite, ' || ', ' Super Admin'.' || ' . $_SESSION['username']);
//  $pagename='new-school';
   meta();
    pageHeader();
   sideBar();
    
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
       
        <h3><span class="label label-primary label-mini"><i class="fa fa-university" ></i> School Data</span></h3><br>
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
              	
              <div class="form-group">
                  
                  <label class="control-label col-sm-2">School Name</label>
                  <div class="col-md-10">
                    <input class="form-control form-control-inline input-medium " name="name" id="name" type="text" placeholder="Outsmart Ideas" required="">  
                    
                  </div>
                </div>

                <div class="form-group">
                  
                  <label class="control-label col-sm-2">School Motto</label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="motto" id="motto" type="text" placeholder="Working Smart" required="">
                  </div>
                  <label class="control-label col-sm-2">School Phone</label>
                  <div class="col-md-4">
                    <input type="tel" required="" class="form-control form-control-inline input-medium" name="phone"  onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57">
                  </div>
                </div>

                <div class="form-group">
                  
                  <label class="control-label col-sm-2">School Address</label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="address" id="address" type="text" placeholder="#55 example road" required="">  
                    
                  </div>

                   <label class="control-label col-sm-2">School Short Code</label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="shortCode" id="shortCode" type="text" placeholder="OSID" required="">  
                    
                  </div>
                </div>
                 
                <div class="form-group ">                                  
                  <label class="control-label col-md-3"> School Logo</label><br>
                  <div class="col-md-4">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                        <img src="img/outsmart.png" alt="" />
                      </div>
                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                        <span class="btn btn-theme02 btn-file">
                          <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select School Logo</span>
                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change Logo</span>
                        <input type="file" class="default" name="logo" />
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
                 	<div class="col-md-12">
                    
                 <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="new-school.php#myModal">Register&nbsp;<i class="fa fa-arrow-right"></i> </a><br><br>  
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

</body>

</html>
