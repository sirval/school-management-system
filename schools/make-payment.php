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
  if (!isset($paid) || trim(strlen($paid)) =='') {
    echo "<script>alert('Amount Paid field cannot be empty');</script>";
    exit();
 }
 if (($balance) < 0) {
    echo "<script>alert('Invalid Payment Entry');
    window.location.href='make-payment.php'
    </script>";
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
 
 if (!isset($studId) || trim(strlen($studId)) =='') {
    echo "<script>alert('Oops! students registration number not found');
    window.location.href='payment-registration.php'
    </script>";
    exit();
 }
 $date=date('d-m-Y h:i:s');
  if (!empty($file_name)) {
    $file_name=$_FILES['payment']['name'];
  $file_size=$_FILES['payment']['size'];
  $file_type=$_FILES['payment']['type'];
  $maxSize= 51200;
  $accepted=array('jpeg','jpg', 'png', 'pdf');
  
  if (($file_size>=$maxSize) || ($file_size==0)) {
    echo "<script>alert('File size is too big');</script>";
    exit();
  }
 
  if ((($accepted)==false) || (empty($file_type))){
    echo "<script>alert('Invalid file type only JPEG, JPG, PNG or PDF is accepted');</script>";
    exit();
$extension=explode('.', $file_name);
    
    $extension=strtolower(end($extension));
    
    $pop='POP_'.uniqid().'.'.$extension;

if (move_uploaded_file($_FILES['payment']['tmp_name'],"payment_proof/$pop")) {
  $sql=mysqli_query($conn, "INSERT INTO `student_fees`(`amountPaid`,`currentPayment`, `balance`, `paymentMode`, `pop`, `datePaid`,`payTerm`, `studentId`) VALUES ('$paid','$paid','$balance','$paymentMode','$pop','$date','$term', '$studId')");
  $sql2=mysqli_query($conn, "INSERT INTO `student_fees_backup`(`amountPaid`, `balance`, `paymentMode`, `pop`, `datePaid`,`payTerm`, `studentId`) VALUES ('$paid','$balance','$paymentMode','$pop','$date','$term', '$studId')");

  if (mysqli_affected_rows($conn)>0) {
    header('location: paid-students.php?confirm=success');
    exit();
  }else
  {
   echo "<script>alert(' Oops! An error occurred while trying to process your request lkw.');</script>";
    exit();
  }
}else{
echo "<script>alert('File upload failed');</script>";
    exit();
}
    
  }
  }else
  {
 $sql=mysqli_query($conn, "INSERT INTO `student_fees`(`amountPaid`,`currentPayment`, `balance`, `paymentMode`, `pop`, `datePaid`,`payTerm`, `studentId`) VALUES ('$paid','$paid','$balance','$paymentMode','','$date','$term', '$studId')");
  $sql2=mysqli_query($conn, "INSERT INTO `student_fees_backup`(`amountPaid`, `balance`, `paymentMode`,`pop`, `datePaid`,`payTerm`, `studentId`) VALUES ('$paid','$balance','$paymentMode','','$date','$term', '$studId')");

  if (mysqli_affected_rows($conn)>0) {
    header('location: paid-students.php?confirm=success');
    exit();
  }else
  {
   echo "<script>alert(' Oops! An error occurred while trying to process your request.');</script>";
    exit();
  }
  
  

    
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
   }else{
    $studId= gzinflate(base64_decode(strtr($_GET['id'], '-_', '+/')));


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
          <div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                </button>
                  <p><span class="label label-info">NOTE!</span> To register students' payment select term of payment, the year and student registration number is fetchd automatically for proper precision</p>
            </div>
        </div>
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                
              <h4><span class="label label-primary label-mini"><i class="fa fa-graduation-cap" > </i> Student Details</span></h4><br>
              <?php
         $sql=mysqli_query($conn,"SELECT * 
                    FROM 
                    class,
                    students
                    WHERE students.id='$studId' AND class.id=students.class");
                       while($row = mysqli_fetch_array($sql)){
                        $stud_name=$row['surname'].' '.$row['othernames'];
                        $reg =$row['regNum'];
                        $stud_class=$row['name'];
                        $passport=$row['studPics'];
                        $classCode=$row['classCode'];
                        }
                      ?>
               <div class="form-group">
                <img style="display: block; margin-left: auto; margin-right: auto; width: 120px; height: 120px; border: 2px solid red" src="<?php echo 'student_passport/'.$passport;?>"  alt="Passport">
                
               
                </div>

                <div class="form-group ">
                  <input type="hidden" name="studId" value="<?php echo( $studId) ?>">

                  <label class="control-label col-sm-2">Payment Term</label>
                  <div class="col-md-3">
                    <select class="form-control form-control-inline " name="term" id="term">
                      <option value="">--Select Payment Term--</option>
                      <?php 
                    $sql=mysqli_query($conn,"SELECT * from term");
                      if (mysqli_num_rows($sql)>0 ) {           
               
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['termName']; ?>"><?php echo $row['termName']; }}?></option>
                    </select>
                  </div>
                  <label class="control-label col-sm-1">Year</label>
                  <div class="col-md-2">
                    <select class="form-control form-control-inline " name="year" id="year">
                      <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                      
                    </select>
                  </div>
                  <label class="control-label col-sm-1">Admission Number:</label>
                  <div class="col-md-3 col-xs-11">
                    
                      <input type="text" autocomplete="off" placeholder="Enter Registration Number here" name="regNum" class="form-control" value="<?php echo $reg; ?>" readonly="">
                      
                  </div>

              </div>
                

                  <div class="form-group">
                <label class="control-label col-sm-2" >Student Name</label>
                  <div class="col-md-3">
                    <input class="paid form-control form-control-inline input-medium " readonly="" type="text" value="<?php echo $stud_name;?>" >
                  </div>
                  <label class="control-label col-sm-1">Class</label>
                  
                  <div class="col-md-3">
                    <select class="form-control form-control-inline " name="class" id="class" required="">
                      <option value="<?php echo $stud_class; ?>"><?php echo $stud_class; ?></option>
                      
                    </select>
                   
                    
                  </div>
                   
                </div>
                 
                
              <h4><span class="label label-success label-mini"><i class="fa fa-money" > </i> Payment Details</span></h4><br>

              <div class="alert alert-info alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                              </button>
                   Always enter Fee Own First for proper precision. Fee own should always be summation of all payment per year.
                  </div>
              
                <div class="form-group">
                  
                   <label class="control-label col-sm-1">Fee Own</label>
                 
                  <div class="col-md-2">
                    <input class=" form-control form-control-inline input-medium "  type="text" name="total" id="total" > 
                    
                  </div>
                  <label class="control-label col-sm-1" >Amount Paid</label>
                  <div class="col-md-2">
                    <input class="paid form-control form-control-inline input-medium " id="paid" name="paid" onchange="pop(); validate();" oninput="calculate()" type="text"  required="" onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57" >
                  </div>
                  
                    <label class="control-label col-sm-1">Balance</label>
                  
                  <div class="col-md-2">
                    <input class="balance form-control form-control-inline input-medium " type="text" name="balance" id="balance" readonly="" oninput="calculate()">
                    <p id="notif"></p> 
                    
                  </div>
                    
                </div>
                

                <div class="form-group "> 
                <label class="control-label col-sm-2">Mode of Payment</label>
                  <div class="col-md-3">
                    <select class="form-control form-control-inline input-medium " name="paymentMode">
                      <option value="">--Select Mode of Payment</option>
                      <option value="Cash">Cash</option>
                      <option value="Bank Deposit/Transfer">Bank Deposit/Transfer</option>
                      <option value="Cheque">Cheque</option>
                      
                    </select> 
                  </div>                                 
                  <label class="control-label col-md-3">Upload Payment Proof</label><br>
                  <div class="col-md-6">
                    
                        <input type="file" class="default" name="payment"><br>
                        
                    
                    <span class="label label-info">NOTE!</span>
                    <span style="color: red">
                      File should either be in JPEG, JPG, PNG or PDF format and not more than 50KB
                      </span>
                  </div>
              </div>

                <div class="form-group">
                  <div class="col-md-12">
                    <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" onmouseenter="validate()" href="payment-registration.php#myModal">Make Payment&nbsp;<i class="fa fa-arrow-right"></i> </a><br><br>  
                 </div>                
                </div>

                 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm Payment!</h4>
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
  <?php mainJs();
     ?>
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
    alert('You Selected Part payment and it seems you have paid all your fees. If this is the payment for the year, consider setting Payment Term to All Payment');
    term.focus();
  }

}

  </script>

</body>

</html>
