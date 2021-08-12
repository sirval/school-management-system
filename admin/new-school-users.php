<?php
require '../db/db_con.php';
if (isset($_POST['go'])) {
  $schoolId=strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['schoolId'])));
  $userRole=strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['userRole'])));
  $username= strip_tags(mysqli_real_escape_string($conn, $_POST['username']));
  $password=strip_tags(mysqli_real_escape_string($conn, $_POST['password']));

  $userRole1=strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['userRole1'])));
  $username1= strip_tags(mysqli_real_escape_string($conn, $_POST['username1']));
  $password1=strip_tags(mysqli_real_escape_string($conn, $_POST['password1']));

  $userRole2=strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['userRole2'])));
  $username2= strip_tags(mysqli_real_escape_string($conn, $_POST['username2']));
  $password2=strip_tags(mysqli_real_escape_string($conn, $_POST['password2']));
  
  
  if (!isset($schoolId) || strlen($schoolId)=='') {
    header('location: new-school-users.php?error=1');
    exit();
  }
  if (!isset($userRole) || strlen($userRole)=='') {
    header('location: new-school-users.php?error=6');
    exit();
  }

   if (!isset($username) || strlen($username)<4 ) {
    header('location: new-school-users.php?error=2');
    exit();
  }
  $uppercase= preg_match('@[A-Z]@', $password);
  $lowercase= preg_match('@[a-z]@', $password);
  
  
   if (!$uppercase || !$lowercase ) {
    header('location: new-school-users.php?error=3');
    exit();
  }
  $auth=mysqli_query($conn, "SELECT * FROM users WHERE username='$username' and password = '$password' and roleId='$userRole' or username='$username1' and password = '$password1' and roleId='$userRole1' or username='$username2' and password = '$password2' and roleId='$userRole2' and schoolId = '$schoolId'");
    if (mysqli_num_rows($auth)>0) {
       header('location: new-school-users.php?error=4');
    exit();
    }
   
  $query=mysqli_query($conn, "INSERT INTO `users`(`username`, `password`, `roleId`, `schoolId`) VALUES ('$username', '$password' , '$userRole' ,'$schoolId')");

  $query=mysqli_query($conn, "INSERT INTO `users`(`username`, `password`, `roleId`, `schoolId`) VALUES ('$username1', '$password1' , '$userRole1' ,'$schoolId')");

  $query=mysqli_query($conn, "INSERT INTO `users`(`username`, `password`, `roleId`, `schoolId`) VALUES ('$username2', '$password2' , '$userRole2' ,'$schoolId')");
  if (mysqli_affected_rows($conn)>0) {
    header('location: timeframe.php');
  }
  else{
     header('location: new-school-users.php?error=5');
    exit();
  }
}

if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
    if ($errmsg == '1') {
      $msgerror ='Error: Please Select School!';
    }
    elseif($errmsg =='2'){
        $msgerror ='Error: Enter Username! Username must not be less than 3 characters ';
    }
    elseif($errmsg =='3'){
        $msgerror ='Error: Users Password must contain at least one uppercase, lowercase, number and special characters and not less than 8 characters!';
    }

    elseif($errmsg =='4'){
        $msgerror ='Error: this Username or Password exists for this School!';
    }
    
    elseif($errmsg =='5'){
        $msgerror ='Error: A fatal error occured while trying to process your request! If this error persists, contact admin for guidelines!';
    }
    elseif($errmsg =='6'){
        $msgerror ='Error: Select System User Role!';
    }
  
  }

require '../controller/admin_required.php'; 
   
$userId=$_SESSION['usersn'];
siteTitle(mysite, ' || ', ' Super Admin'.' || ' . $_SESSION['username']);
 //$pagename='new-school';
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
       
        <h3><span class="label label-primary label-mini"><i class="fa fa-user" ></i> User Data1 (Select Director for All Access) <i style="color: red"> *</i></span></h3><br>
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
              	
              <div class="form-group">
                  
                  <label class="control-label col-sm-2">School Name</label>
                  <div class="col-md-4">
                    <select class="form-control form-control-inline " name="schoolId" required="">
                      <option value="">--Select School--</option>
                      <?php 
                    $sql=mysqli_query($conn,"SELECT * from schools");
                      if (mysqli_num_rows($sql)>0 ) {           
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; }}else{echo "NO AVAILABLE SCHOOL FOUND";}?></option>
                    </select>
                  </div>
                  <label class="control-label col-sm-2">User Role</label>
                  <div class="col-md-4">
                  
                    <select class="form-control form-control-inline " name="userRole" required="">
                     
                      <?php 
                    $sql=mysqli_query($conn,"SELECT * from role");
                      if (mysqli_num_rows($sql)>0 ) {           
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['roleName']; }}else{echo "NO AVAILABLE ROLE FOUND";}?></option>
                    </select>
                  </div>
                </div>
                  
                <div class="form-group">
                  
                  <label class="control-label col-sm-2">School User</label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="username" id="username" type="text" placeholder="Username" required="">
                  </div>
                    <label class="control-label col-sm-2">School User Password</label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="password" id="password" type="password" placeholder="Password" required=""> 
                  </div>
                </div>

                <!--End of user1 info -->
                <div class="alert alert-info alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                              </button>
                  <p>This can be added later by going to All Registered School under settings, click on the pencil icon then click on Update Others Users to view a drop down of All Users then enter their username and password then click on Update</p>
                  </div>
                <h3><span class="label label-success label-mini"><i class="fa fa-user" ></i> User Data2 (Select School Clerk for limited Access)<i style="color: red"> Optional</i></span></h3><br>
              <div class="form-group">
                  <label class="control-label col-sm-2">User Role</label>
                  <div class="col-md-10">
                  
                    <select class="form-control form-control-inline " name="userRole1" >
                      <option value="">--Select User Role--</option>
                      
                      <?php 
                    $sql=mysqli_query($conn,"SELECT * from role WHERE id != 1");
                      if (mysqli_num_rows($sql)>0 ) {           
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option selected="" value="<?php echo $row['id']; ?>"><?php echo $row['roleName']; }}else{echo "NO AVAILABLE ROLE FOUND";}?></option>
                    </select>
                  </div>
                </div>
                  
                <div class="form-group">
                  
                  <label class="control-label col-sm-2">School User</label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="username1" id="username" type="text" placeholder="Username" >
                  </div>
                    <label class="control-label col-sm-2">School User Password</label>
                  <div class="col-md-4">
                    <input class="form-control form-control-inline input-medium " name="password1" id="password" type="password" placeholder="Password" > 
                  </div>
                </div>
                <!-- End of User3 info-->
                
                
                 <div class="form-group">
                 	<div class="col-md-12">
                 <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="new-school-users.php#myModal">Register&nbsp;<i class="fa fa-arrow-right"></i> </a><br><br>  
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
