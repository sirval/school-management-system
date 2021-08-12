<?php
require '../db/db_con.php';
if (isset($_POST['go'])) {
  $schoolId=strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['schoolId'])));
  $strdate= strip_tags(mysqli_real_escape_string($conn, $_POST['strdate']));
  $enrdate=strip_tags(mysqli_real_escape_string($conn, $_POST['enrdate']));
  
  if (!isset($schoolId) || strlen($schoolId)=='') {
    header('location: timeframe.php?error=1');
    exit();
  }

   if (!isset($strdate) || strlen($strdate)=='') {
    header('location: timeframe.php?error=2');
    exit();
  }
  if (!isset($enrdate) || strlen($enrdate)=='') {
    header('location: timeframe.php?error=3');
    exit();
  }
   
  $query=mysqli_query($conn, "INSERT INTO `elapse_time`(`startDate`, `endDate`, `schoolId`) VALUES ('$strdate', '$enrdate' , '$schoolId')");
  if (mysqli_affected_rows($conn)>0) {
    header('location: timeframe.php?confirm=success');
  }
  else{
     header('location: timeframe.php?error=5');
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
        $msgerror ='Error: Users Password must contain at one uppercase, lowercase, number and special characters and not less than 8 characters!';
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
              <p>Select the Day, Month and Year this Application will Expire. We use the system time to match with the date you have provided. That means even if the School is not using this application, their time goes.</p>
              </div>
       
        <h3><span class="label label-primary label-mini"><i class="fa fa-clock-o" ></i> System Time</span></h3><br>
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
              	
              <div class="form-group">
                  
                  <label class="control-label col-sm-2">School Name</label>
                  <div class="col-md-9">
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
                </div>
                <div class="form-group ">
                  <label class="control-label col-sm-2">Installed Date</label>
                  <div class="col-md-8 col-xs-11">
                    <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="01-09-2020" class="input-append date dpYears">
                      <input type="text" readonly="" name="strdate" size="16" class="form-control">
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
                      <input type="text" readonly="" name="enrdate" size="16" class="form-control">
                      <span class="input-group-btn add-on">
                        <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                  </div>
              </div>
                 <div class="form-group">
                 	<div class="col-md-12">
                 <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="timeframe.php#myModal">Register&nbsp;<i class="fa fa-arrow-right"></i> </a><br><br>  
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
