<?php
error_reporting(0);
session_start();
require '../db/db_con.php';
if (isset($_POST['pay'])) {
  
$paid = strip_tags(mysqli_real_escape_string($conn, $_POST['paid']));
  $balance = strip_tags(mysqli_real_escape_string($conn, $_POST['balance']));
  $paymentMode = strip_tags(mysqli_real_escape_string($conn, $_POST['paymentMode']));
  
  $term= strip_tags(mysqli_real_escape_string($conn, $_POST['term']));
  $studId = strip_tags(mysqli_real_escape_string($conn, $_POST['studId']));
  $prePayment = strip_tags(mysqli_real_escape_string($conn, $_POST['prePayment']));
 
  $file_name=$_FILES['payment']['name'];
  $file_size=$_FILES['payment']['size'];
  $file_type=$_FILES['payment']['type'];
  $maxSize= 51200;
  $accepted=array('jpeg','jpg', 'png', 'pdf');
  
  
  if (!isset($paid) || trim(strlen($paid)) =='') {
    echo "<script>alert('Amount Paid field cannot be empty');</script>";
    exit();
 }
 if (!isset($term) || trim(strlen($term)) =='') {
    echo "<script>alert('Payment term field is cannot be empty');</script>";
    exit();
 }
  if (!isset($balance) || trim(strlen($balance)) =='') {
    echo "<script>alert('Balance field cannot be empty. If you think this is an error, Please contact the admin');</script>";
    exit();
}
if (($balance) < 0) {
    echo "<script>alert('Invalid Payment Entry');
    window.location.href='paid-students.php'
    </script>";
    exit();
}
 if (!isset($paymentMode) || trim(strlen($paymentMode)) =='') {
    echo "<script>alert('Please selected your mode of payment');</script>";
    exit();
 }
 if (!isset($studId) || trim(strlen($studId)) =='') {
    echo "<script>alert('Oops! students payment Id not found');
    window.location.href='payment-registration.php'
    </script>";
    exit();
 }
 $date=date('d-m-Y h:i:s');

$total=$prePayment+$paid;
if ($paymentMode="Cash") {
  $sql=mysqli_query($conn, "UPDATE `student_fees` SET `amountPaid`='$total',`currentPayment`='$paid',`balance`='$balance',`paymentMode`='$paymentMode',`datePaid`='$date',`payTerm`='$term' WHERE id='$studId'");
  
 if (mysqli_affected_rows($conn)>0) {
 
    header('location: paid-students.php?confirm=success');
    exit();
  }else
  {
   echo "<script>alert(' Oops! An error occurred while trying to process your request.');</script>";
    exit();
  }
}
if (($file_size>=$maxSize) || ($file_size==0)) {
    echo "<script>alert('File size is either too big or nothing is selected');</script>";
    exit();
  }
 
  if ((($accepted)==false) || (empty($file_type))){
    echo "<script>alert('Invalid file type only JPEG, JPG, PNG or PDF is accepted');</script>";
    exit();
    
  }
 $extension=explode('.', $file_name);
    
    $extension=strtolower(end($extension));
    
    $pop='POP_'.uniqid().'.'.$extension;
    
if (move_uploaded_file($_FILES['payment']['tmp_name'],"payment_proof/$pop")) {
  $sql=mysqli_query($conn, "UPDATE `student_fees` SET `amountPaid`='$total',`currentPayment`='$paid',`balance`='$balance',`paymentMode`='$paymentMode',`pop`='$pop',`datePaid`='$date',`payTerm`='$term', WHERE `id`='$studId'");
 if (mysqli_affected_rows($conn)>0) {
 
    header('location: paid-students.php?confirm=success');
    exit();
  }else
  {
   echo "<script>alert(' Oops! An error occurred while trying to process your request.');</script>";
    exit();
  }
}else{
echo "<script>alert('File upload failed');</script>";
    exit();
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
siteTitle(mysite, ' || ', ' Admin'.' || ' . $_SESSION['user']);
   meta();
    pageHeader();
   sideBar();

   if (!$_GET['id'] && $_GET['id']=='') {
    echo "<script>alert('An error occured due to system modification. Click okay to proceed');
    window.location.href='payment-registration.php';</script>";
   }
   $studId= gzinflate(base64_decode(strtr($_GET['id'], '-_', '+/')));
   if (isset($_SESSION['userRole']) && $_SESSION['userRole'] != 1) {
    echo"
     <script>alert('Access Denied for this User');
    window.location.href='paid-students.php';</script>";
   
   }
   
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
         $sql=mysqli_query($conn,"SELECT * 
                    FROM 
                    class,
                    students 
                    INNER JOIN student_fees
                    ON students.id=student_fees.studentId
                    WHERE student_fees.id='$studId' AND class.id=students.class");
                       while($row = mysqli_fetch_array($sql)){
                        $name=$row['surname'].' '.$row['othernames'];
                        $reg = $row['regNum'];
                        $class=$row['name'];
                        $passport=$row['studPics'];
                        $classCode=$row['classCode'];
                        $amountPaid=(int)$row['amountPaid'];
                        $balance=$row['balance'];
                        $curPay=$row['currentPayment'];
                        $payTerm=$row['payTerm'];}
                       
                       
                      ?>
        
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                
              <h4><span class="label label-primary label-mini"><i class="fa fa-graduation-cap" > </i> Student Details</span></h4><br>
               <div class="form-group">
                <img style="display: block; margin-left: auto; margin-right: auto; width: 120px; height: 120px; border: 2px solid red" src="<?php echo 'student_passport/'.$passport;?>"  alt="Passport">
                
               
                </div>

                <div class="form-group ">

                  <label class="control-label col-sm-2">Payment Term</label>
                 
                  <div class="col-md-3">
                    <select readonly="" class="form-control form-control-inline " name="term" id="term">
                      <option value="<?php echo $payTerm; ?>"><?php echo $payTerm; ?></option>                      
                      <?php
                      $sql=mysqli_query($conn,"SELECT * from term WHERE termName != '$payTerm'");
                      if (mysqli_num_rows($sql)>0 ) {           
               
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['termName']; ?>"><?php echo $row['termName']; }}?></option>
                      ?>
                    </select>
                  </div>
                  <label class="control-label col-sm-1">Year</label>
                  <div class="col-md-2">
                    <select class="form-control form-control-inline " name="year" id="year">
                      <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                      
                    </select>
                  </div>
                  <label class="control-label col-sm-1">Registration Number:</label>
                  <div class="col-md-3 col-xs-11">
                    <input type="hidden" name="studId"  value="<?php echo $studId; ?>">
                      <input type="text" autocomplete="off" placeholder="Enter Registration Number here" name="regNum" class="form-control" value="<?php echo $reg; ?>" readonly="">
                      
                  </div>

              </div>
                

                  <div class="form-group">
                <label class="control-label col-sm-2" >Student Name</label>
                  <div class="col-md-3">
                    <input class="paid form-control form-control-inline input-medium " readonly="" type="text" value="<?php echo $name;?>" >
                  </div>
                  <label class="control-label col-sm-1">Class</label>
                  
                  <div class="col-md-3">
                    <select class="form-control form-control-inline " name="class" id="class" required="">
                      <option value="<?php echo $class; ?>"><?php echo $class; ?></option>
                      
                    </select>
                  </div>
                   
                </div>
                 
                
              <h4><span class="label label-success label-mini"><i class="fa fa-money" > </i> Payment Details</span></h4><br>
             
                  <div class="form-group text-center">
                    <label class="control-label col-sm-2">Total Paid</label>
                 
                  <div class="col-md-3">
                    <input class=" form-control form-control-inline input-medium " readonly="" value="<?php echo $amountPaid; ?>"   type="text" name="prePayment" id="prePayment" > 
                     
                  </div>

                  <label class="control-label col-sm-2">Previous Payment</label>
                 
                  <div class="col-md-3">
                    <input class=" form-control form-control-inline input-medium " readonly="" value="<?php echo $curPay; ?>"   type="text" name="previousPayment" id="previousPayment" > 
                     
                  </div>
                  </div>
              
                <div class="form-group">
                   <label class="control-label col-sm-1">Fee Own</label>
                 
                  <div class="col-md-2">
                    <input class=" form-control form-control-inline input-medium" readonly="" value="<?php echo $balance; ?>"  type="text" name="total" id="total" > 
                     
                  </div>
                  <label class="control-label col-sm-2" >Amount Paid</label>
                  <div class="col-md-2">
                    <input class="paid form-control form-control-inline input-medium "  id="paid" name="paid" onchange="pop(); validate();" oninput="calculate()" type="text"  required="" onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57" >
                  </div>

                  
                    <label class="control-label col-sm-1">Balance</label>
                  
                  <div class="col-md-2">
                    <input class="balance form-control form-control-inline input-medium " type="text"  name="balance" id="balance" readonly="" oninput="calculate()">
                    <p id="notif"></p> 
                    
                  </div>
                </div>
                

                <div class="form-group "> 
                <label class="control-label col-sm-2">Mode of Payment</label>
                  <div class="col-md-3">
                    <select class="form-control form-control-inline input-medium " name="paymentMode" id="paymentMode">
                      <option value="">--Select Mode of Payment</option>
                      <option value="Cash">Cash</option>
                      <option value="Bank Deposit/Transfer">Bank Deposit/Transfer</option>
                      <option value="Cheque">Cheque</option>
                      
                    </select> 
                  </div>                                 
                  <label class="control-label col-md-3">Upload Payment Proof</label><br>
                  <div class="col-md-6">
                    
                        <input type="file" class="default" name="payment" /><br>
                        
                    
                    <span class="label label-info">NOTE!</span>
                    <span style="color: red">
                      File should either be in JPEG, JPG, PNG or PDF format and not more than 50KB
                      </span>
                  </div>
              </div>
                <div class="form-group">
                  <div class="col-md-12">
                    <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" onmouseenter="validate()" href="payment-registration.php#myModal">Update Payment&nbsp;<i class="fa fa-arrow-right"></i> </a><br><br>  
                 </div>                
                </div>

                 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm Payment Update!</h4>
              </div>
              <p style="font-size: 20px;">Are you sure you want to proceed?</p>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                <button class="btn btn-theme" type="submit" name="pay">Yes</button>
              </div>
            </div>
          </div>
        </div>
                 <div class="form-group"><br><br></div>
               
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
     function calculate() {
      var response=document.getElementById('notif');
      var paid= document.getElementById('paid').value;
      var total = document.getElementById('total').value;
      var balance =document.getElementById('balance');

      var newBalance=total-paid;
      balance.value=newBalance;
      
      if (balance.value < 0) {
       var txt1='Invalid Payment';
       var er=txt1.fontcolor('red');
       response.innerHTML=er;
      }
      if (balance.value == 0) {
        var txt2= 'Payment Completed ';
        var suc =txt2.fontcolor('green');
       response.innerHTML=suc;
      }
      if (balance.value >0) {
        var txt3='Balance';
        var psuc =txt3.fontcolor('blue');
       response.innerHTML=psuc;
      }
      
    }
function pop() {
  var balance =document.getElementById('balance');
  var paid= document.getElementById('paid');
  var total = document.getElementById('total');
  if ((total.value=='')  && paid.value !='') {
  alert('Please enter FEE OWN first for exact precision');
  balance.value='';
  paid.value='';
  total.focus();
}
}
function validate() {
  var term=document.getElementById('term');
  var balance= document.getElementById('balance');
  var total = document.getElementById('total');
  if ((term.selectedIndex=='2') && balance.value==0) {
    alert('You Selected Partment and it seems you have paid all your fees. If this is the payment for the year, consider setting Payment Term to All Payment');
    term.focus();
  }

}

function check() {
 var pr=document.getElementById('term');
}

  </script>

</body>

</html>
