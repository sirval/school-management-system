<?php 
session_start();
require '../db/db_con.php';
//require '../controller/restricted.php';
if (isset($_POST['checkResult'])) 
{
      $examYear = strip_tags(mysqli_real_escape_string($conn, $_POST['examYear']));
      $examTerm = strip_tags(mysqli_real_escape_string($conn, $_POST['examTerm']));
      $adminNum = strip_tags(mysqli_real_escape_string($conn, $_POST['adminNum']));
      $pin = strip_tags(mysqli_real_escape_string($conn, $_POST['pin']));
      $studId = strip_tags(mysqli_real_escape_string($conn, $_POST['studId']));
      $schoolId = strip_tags(mysqli_real_escape_string($conn, $_POST['studSch']));
    if (empty($examYear)) 
    {
      header('location: result-checker.php?error=1');
        exit();
      echo "<script> alert('Select Examination Year') </script>";
    }
    if (empty($examTerm) ) {
      echo "<script> alert('Select Examination Term') </script>";
    }
    if (empty($adminNum)) {
      echo "<script> alert('Enter Admission Number') </script>";
    }
    if (empty($pin) ) {
      echo "<script> alert('Enter PIN') </script>";
    }
    

      //check if pin has been used 
    $pin_auth = mysqli_query($conn, "SELECT * FROM pin WHERE pin = '$pin' and validity = '1' and studentId != '$studId' ");
    if (mysqli_num_rows($pin_auth)>0) 
    {
       echo "<script> alert ('This PIN has already been used!') ; 
      </script>";
    }
    //check if student has previously check result
    $checkUser = mysqli_query($conn, "SELECT *  FROM pin WHERE pin='$pin' and studentId = '$studId' and validity= '1' and sch = '$schoolId' ");
          if (mysqli_num_rows($checkUser) > 0) 
          {
          
           $query = mysqli_query($conn, "SELECT * FROM student_result, students, pin WHERE students.id ='$studId' and pin.pin= '$pin' and pin.studentId ='$studId' and student_result.examYear='$examYear' and student_result.examTerm='$examTerm' and students.school = '$schoolId'");
           if (mysqli_num_rows($query)>0) 
           {
            session_regenerate_id();
            $url_data = base64_encode($pin);
            $_SESSION['examTerm'] = $examTerm;
            $_SESSION['examYear'] =$examYear;
            $_SESSION['reg'] =$adminNum; 
            echo "
                <script>
                  window.location.href='myResult-Checker.php?StudentId=".($url_data)."'
                </script>";
            session_write_close();
           }
           else
           {
            echo 
            "
            <script> 
                  alert ('Seems you entered an Invalid detail. Make sure your exam year, term or Admission number are correct');
            </script>
            ";
           }
       }
         //Student have not checked result before, update pin table first
         else
         {
           
          $update = mysqli_query($conn, "UPDATE `pin` SET `validity`= '1',`studentId`='$studId', `dtime` = NOW(), `sch` = '$schoolId' WHERE pin='$pin' and validity != 1");
          if (mysqli_affected_rows($conn)>0) 
          {
                       
           $query = mysqli_query($conn, "SELECT * FROM student_result, students, pin WHERE students.id ='$studId' and pin.pin= '$pin' and pin.studentId ='$studId' and student_result.examYear='$examYear' and student_result.examTerm='$examTerm' and students.school = '$schoolId'");
           if (mysqli_num_rows($query)>0) 
           {
            session_regenerate_id();
            $url_data = base64_encode($pin);
            $_SESSION['examTerm'] = $examTerm;
            $_SESSION['examYear'] =$examYear;
            $_SESSION['reg'] =$adminNum; 
            echo "
                <script>
                  window.location.href='myResult-Checker.php?StudentId=".($url_data)."'
                </script>";
            session_write_close();
           }
           else
           {
            echo 
            "
            <script> 
                  alert ('Seems you entered an Invalid detail. Make sure your exam year, term or Admission number are correct');
            </script>
            ";
           } 
          }
          
         }


}

if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
    if ($errmsg == '1') {
      $msgerror ='Warning: Examination Year is Required!';
    }
    elseif ($errmsg == '4') {
      $msgerror ='Error: Oops! A fatal error occcured while trying to process your request. Please try again later!';
    }
    elseif($errmsg =='3'){
        $msgerror ='Warning: Invalid Admission Number and Password !';
    }
    elseif($errmsg =='3'){
        $msgerror ='Warning: Either Admission Number or Password is Empty !';
    }
    elseif($errmsg =='50'){
        $msgerror ='Error: Oops! Your Subscription to SmartSchool has just expired. Please Contact your school Admin for more Details !';
    }
    
}


require '../controller/students_required.php'; 
   
   
   meta();
   siteTitle(mysite, " || ", " Student" ." || " . $_SESSION['student']."'s portal");
  $pagename='dashboard';
    pageHeader();
   sideBar();
   $reg = $_SESSION['reg'];
   $studId = $_SESSION['studentId'];
   $studSch = $_SESSION['studSchool'];

    
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
        
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="form-horizontal style-form" enctype="multipart/form-data">

              <h1 style="text-align: center; font-weight: bolder; "><span class="label label-success label-mini" ><i class="fa fa-book" ></i> RESULT CHECKER</span></h1><br><br>
              <?php 
                    //get school fees year
               $getFeeYear = mysqli_query($conn, "SELECT datePaid, balance, amountPaid from student_fees where studentId = '$studId'");
                  if (mysqli_num_rows($getFeeYear) >0) 
                  {
                    while ($paymentDetail = mysqli_fetch_array($getFeeYear)) 
                    {
                    $yearPart = substr($paymentDetail['datePaid'], -10, 4);
                    $paymentYear = substr($yearPart, -10, 4);
                    $balance = $paymentDetail['balance'];
                    $amountPaid = $paymentDetail['amountPaid'];
                    $totalFee = $amountPaid + $balance;
                    }
                    if ($balance == 0 ) 
                    {
                    ?>
                <div class="form-group">
                  <label class="control-label col-sm-2" >Exam Year<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                   <input type="hidden" name="studId" value="<?php echo($studId); ?>">
                   <input type="hidden" name="studSch" value="<?php echo($studSch); ?>">      
                    <select class="form-control form-control-inline " name="examYear" id="examYear"  required="">
                      <option value="">--Select Exam Year--</option>
                      <?php 
                    $sql=mysqli_query($conn,"SELECT * from examYear");
                      if (mysqli_num_rows($sql)>0 ) {           
               
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['year']; ?>"><?php echo $row['year']; }}else{echo "NO AVAILABLE YEAR FOUND";}?></option>
                    </select>
                </div>
                <label class="control-label col-sm-2" >Exam Term<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                <select class="form-control form-control-inline input-medium "  name="examTerm" id="term" required="">
                      <option>--Select Term--</option>
                      <?php 
                      require '../db/db_con.php';
                        $sql=mysqli_query($conn,"SELECT * from term");
                      if (mysqli_num_rows($sql)>0 ) {           
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['termName']; }}else{echo "NO AVAILABLE TERM FOUND";}?></option>
                    </select><br>
                 
              </div>
            </div>

                <div class="form-group">
                  <label class="control-label col-sm-2" >Admission Number<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                    
                      <input type="text" autocomplete="off" placeholder="Enter Admission Number" name="adminNum" class="form-control" readonly=""  required="" value="<?php echo($reg); ?>">
                      
                  </div>
                    <label class="control-label col-sm-2" >Card PIN<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                    
                      <input type="password" autocomplete="off" placeholder="Enter Card PIN" name="pin" class="form-control"  required="">
                      
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-6 pull-left"></div>
                  <div class="col-md-6 pull-right ">
                   <a  data-toggle="modal" class="btn btn-primary btn-sm col-md-6 pull-right " href="result-checker.php#myModal">Check Result&nbsp;<i class="fa fa-arrow-right"></i> </a>
                   <?php
                  }
                  else
                  {
                   echo 
                    '<h4 style="color: red; text-align: center;">You need to make or complete payment first before you can be eligible to check your result</h4><br>

                    <div class="form-group">
                  <label class="control-label col-sm-2" >Exam Year<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                   <input type="hidden" name="studId" value="'.$studId.'">
                   <input type="hidden" name="studSch" value="'.$studSch.'">      
                    <select readonly="" class="form-control form-control-inline " name="examYear" id="examYear"  required="">
                      <option  value="">--Select Exam Year--</option>
                    </select>
                </div>
                <label class="control-label col-sm-2" >Exam Term<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                <select class="form-control form-control-inline input-medium "  name="examTerm" id="term" required="" readonly="">
                      <option>--Select Term--</option>
                      
                    </select><br>
                 
              </div>
            </div>

                <div class="form-group">
                  <label class="control-label col-sm-2" >Admission Number<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                    
                      <input type="text" autocomplete="off" placeholder="Enter Admission Number" name="adminNum" class="form-control" readonly=""  required="" value="'.$reg.'">
                      
                  </div>
                    <label class="control-label col-sm-2" >Card PIN<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                    
                      <input readonly="" type="password" autocomplete="off" placeholder="Enter Card PIN" name="pin" class="form-control"  required="">
                      
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-6 pull-left"></div>
                  <div class="col-md-6 pull-right ">
                    
                    
                   <a   class="btn btn-primary btn-sm col-md-6 pull-right " href="result-checker.php">Check Balance &nbsp;<i class="fa fa-arrow-right"></i> </a>
                    '; 
                  }
                }
                  else
                  {
                    echo 
                    '<h4 style="color: red; text-align: center;">You need to make or complete payment first before you can be eligible to check your result</h4><br>

                    <div class="form-group">
                  <label class="control-label col-sm-2" >Exam Year<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                   <input type="hidden" name="studId" value="'.$studId.'">
                   <input type="hidden" name="studSch" value="'.$studSch.'">      
                    <select readonly="" class="form-control form-control-inline " name="examYear" id="examYear"  required="">
                      <option  value="">--Select Exam Year--</option>
                    </select>
                </div>
                <label class="control-label col-sm-2" >Exam Term<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                <select class="form-control form-control-inline input-medium "  name="examTerm" id="term" required="" readonly="">
                      <option>--Select Term--</option>
                      
                    </select><br>
                 
              </div>
            </div>

                <div class="form-group">
                  <label class="control-label col-sm-2" >Admission Number<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                    
                      <input type="text" autocomplete="off" placeholder="Enter Admission Number" name="adminNum" class="form-control" readonly=""  required="" value="'.$reg.'">
                      
                  </div>
                    <label class="control-label col-sm-2" >Card PIN<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4 ">
                    
                      <input readonly="" type="password" autocomplete="off" placeholder="Enter Card PIN" name="pin" class="form-control"  required="">
                      
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-6 pull-left"></div>
                  <div class="col-md-6 pull-right ">
                    
                    
                   <a   class="btn btn-primary btn-sm col-md-6 pull-right " href="result-checker.php">Check Balance &nbsp;<i class="fa fa-arrow-right"></i> </a>
                    ';
                  
                  }
                     ?>
                   
                </div>
                </div>
                 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirmation!</h4>
              </div>
              <p style="font-size: 20px;">Are you sure you want to proceed?</p>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                <button class="btn btn-theme" type="submit" name="checkResult">Yes</button>
              </div>
            </div>
          </div>
         
        </div>
                 <br><br>
               
              </form>
              <?php//}?>
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
<?php mysqli_close($conn); ?>
</body>

</html>
