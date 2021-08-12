<?php
error_reporting(0);
session_start();
require '../db/db_con.php';
if (isset($_POST['go'])) {
  
  $className = strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['className'])));
  $classCode = strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['classCode'])));
 
  if (!isset($className) || trim(strlen($className)) =='') {
    header('location: new-class.php?error=1');
    exit();
 }
  if (!isset($classCode) || trim(strlen($classCode)) =='') {
    header('location: new-class.php?error=2');
    exit();
}
$sql=mysqli_query($conn, "SELECT * FROM class WHERE classCode='$classCode' and name='$className' ");
if (mysqli_num_rows($sql)>0) {
  header('location: new-class.php?error=4');
    exit();

}
$query=mysqli_query($conn, "INSERT INTO `class`( `classCode`, `name`) VALUES ('$classCode','$className')");
if (mysqli_affected_rows($conn)>0) {
  header('location: new-class.php?success=0');
    exit();

}else{
  header('location: new-class.php?error=7');
    exit();
}
}
if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
    if ($errmsg == '1') {
      $msgerror ='Error: Enter class name!';
    }
    if ($errmsg == '2') {
      $msgerror ='Error: Enter class code!';
    }
    if ($errmsg == '4') {
      $msgerror ='Error: This  class already exist!';
    }
    if ($errmsg == '7') {
      $msgerror ='Error: A fatal error occured! Please contact Admin for more details';
    }
    
}
if (isset($_GET['success']) && $_GET['success']=='0') {
  $msgsucc="Upload Successful!";
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
            elseif (isset($msgsucc) && $msgsucc !=='') 
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
       
        <h3><span class="label label-primary label-mini"><i class="fa fa-clock-o" ></i> NEW CLASS</span></h3><br>
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
              	<div class="form-group">
                  
                
                <label class="control-label col-sm-1">Class Name</label>
                  <div class="col-md-3">
                  <input class="form-control form-control-inline input-medium " name="className"  required=""   placeholder="Class Name E.g GRADE ONE">
                  </div>
                  <label class="control-label col-sm-1">Class Code</label>
                  <div id="total" class="col-md-3 ">
                  <input class="form-control form-control-inline input-medium" name="classCode" required="" placeholder="Class Code E.g GRD1">
                     
                  </div>
                   
                  </div>

             
                 <div class="form-group">
                 	<div class="col-md-12">
                 <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="new-class-users.php#myModal">Save&nbsp;<i class="fa fa-arrow-right"></i> </a><br><br>  
                 </div>                
                </div>

                 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm Save!</h4>
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

</body>

</html>
