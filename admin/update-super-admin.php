<?php
require '../db/db_con.php';
if (isset($_POST['go'])) {
  $oldpass=strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['oldpass'])));
  $username= strip_tags(mysqli_real_escape_string($conn, $_POST['username']));
  $newpass=strip_tags(mysqli_real_escape_string($conn, $_POST['newpass']));
  $id=$_POST['id'];
 
  if (!isset($oldpass) || strlen($oldpass)=='') {
    header('location: update-super-admin.php?error=1');
    exit();
  }

   if (!isset($username) || strlen($username)<4) {
    header('location: update-super-admin.php?error=2');
    exit();
  }
  $uppercase= preg_match('@[A-Z]@', $newpass);
  $lowercase= preg_match('@[a-z]@', $newpass);
  
   if (!$uppercase || !$lowercase) {
    header('location: update-super-admin.php?error=3');
    exit();
  }
  $auth=mysqli_query($conn, "SELECT * FROM admin_account WHERE password != '$oldpass' and id='$id'");
  if (mysqli_num_rows($auth)) {
     header('location: update-super-admin.php?error=4');
    exit();
  }
   
  $query=mysqli_query($conn, " UPDATE `admin_account` SET `username`='$username',`password`='$newpass' WHERE id='$id'");
  if (mysqli_affected_rows($conn)>0) {
    echo "<script>alert('Username and Password Updated Successfully');</script>";

    require 'logout.php';
  }
  else{
     header('location: update-super-admin.php?error=5');
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
        $msgerror ='Error: Users Password must contain at one uppercase, lowercase and not less than 8 characters!';
    }
    elseif($errmsg =='4'){
        $msgerror ='Error: Old Password Does not Match!';
    }

    elseif($errmsg =='4'){
        $msgerror ='Error: this Username or Password exists for this School!';
    }
    
    elseif($errmsg =='5'){
        $msgerror ='Error: A fatal error occured while trying to process your request! If this error persists, contact admin for guidelines!';
    }
  
  }
if (isset($_GET['confirm']) && $_GET['confirm']=='success') {
  $msgsucc='Congratulations! You have finally set the system up. Consider Logging out<a href="logout.php">NOW</a>' ;
   }
  
require '../controller/admin_required.php'; 
   
$userId=$_SESSION['usersn'];
siteTitle(mysite, ' || ', ' Super Admin'.' || ' . $_SESSION['username']);
// $pagename='new-school';
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
            }elseif (isset($msgsucc) && $msgsucc !=='') 
            {
        ?>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
                <?php echo $msgsucc; ?></div>
        <?php
            }
         ?>
       </div>
            
              <div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <p>To update Username or Password, Enter the Previous Password Related to your Account</p>
              </div>
       
       
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">

                <div class="form-group">
                  
                  <label class="control-label col-sm-2">Old Password</label>
                  <div class="col-md-10">
                    <input class="form-control form-control-inline input-medium " name="oldpass" id="password" type="password" placeholder="Old Password" required="">  
                    
                  </div>
                </div>
              	
             <div class="form-group">
              <input type="text" hidden="" value="<?php echo $_SESSION['usersn']; ?>" name="id">
                  
                  <label class="control-label col-sm-2">New Username</label>
                  <div class="col-md-10">
                    <input class="form-control form-control-inline input-medium " name="username" autocomplete="off" id="username" type="text" placeholder="New Username" required="">  
                    
                  </div>
                </div>

                <div class="form-group">
                  
                  <label class="control-label col-sm-2">New Password</label>
                  <div class="col-md-10">
                    <input class="form-control form-control-inline input-medium " name="newpass" id="password" type="newpass" placeholder="New Password" required="">  
                    
                  </div>
                   
                </div>
                 
                 <div class="form-group">
                 	<div class="col-md-12">
                 <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="update-super-admin.php#myModal">Update&nbsp;<i class="fa fa-arrow-right"></i> </a><br><br>  
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
  

</body>

</html>
