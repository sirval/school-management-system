
<?php
error_reporting(0);
session_start();
   require '../db/db_con.php';
if (isset($_POST['delete'])) {
  $del_id=$_POST['feeId'];

   $sql=mysqli_query($conn, "SELECT * FROM student_fees WHERE id='$del_id'");
    if ($sql) {
      while ($res=mysqli_fetch_assoc($sql)) {
        
        $payProof=$res['pop'];
      if (!empty($payProof)) {
           
      $path1='payment_proof/'.$payProof;
       unlink($path1);
        
    $delete=mysqli_query($conn, "DELETE FROM student_fees WHERE id='$del_id'");
    if ($delete) {
      echo "<script>alert(' All information related to this student payment has been deleted successfully');
    window.location.href='paid-students.php';</script>";
    }else{
    echo "<script>alert(' An error occurred while trying to delete students information');
    window.location.href='delete-students-payment.php?userReg=".$del_id."';</script>";
   }
 }else{
  $delete=mysqli_query($conn, "DELETE FROM student_fees WHERE id='$del_id'");
    if ($delete) {
      echo "<script>alert(' All information related to this student payment has been deleted successfully');
    window.location.href='paid-students.php';</script>";
    }else{
    echo "<script>alert(' An error occurred while trying to delete students information');
    window.location.href='delete-students-payment.php?userReg=".$del_id."';</script>";
 }
      }
    }

}}
  if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 1) {
      require '../controller/required.php'; 
    }else{
      require '../controller/users_required.php'; 
    }
    if (isset($_SESSION['userRole']) && $_SESSION['userRole'] != 1) {
    echo"
     <script>alert('Access Denied for this User');
    window.location.href='paid-students.php';</script>";
   
   }
   siteTitle(mysite, ' || ', ' Admin'.' || ' . $_SESSION['user']);
   if (isset($_GET['userReg']) && $_GET['userReg'] !='') {
    $feeId= gzinflate(base64_decode(strtr($_GET['userReg'], '-_', '+/')));

    $sql=mysqli_query($conn, "SELECT * FROM student_fees, students WHERE student_fees.id='$feeId' and students.id=student_fees.studentId");
    while ($result=mysqli_fetch_array($sql)) {
    	$name=$result['surname'].' '.$result['othernames'];
      $reg=$result['regNum'];
    }
                     
    } 
 ?>

  <!-- Bootstrap core CSS -->
  <link href="../assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="../assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/style-responsive.css" rel="stylesheet">
 
</head>

<body>
  <div id="login-page">
    <div class="container">
      <form class="form-login" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
         
        <h2 class="form-login-heading">You're about deleting <?php echo '<strong style="color: red">'.  $name."'s</strong>"; ?> payment information</h2>
        <div><?php
                  
         ?></div>
        <div class="login-wrap">
        	<p>This action will erase all details relating to this student payment. Consider <a href="update-payment-details.php?id=<?php $urlEncode = rtrim(strtr(base64_encode(gzdeflate($feeId, 9)), '+/','-_'),'=') ; echo $urlEncode; ?>"> updating</a> details</p>
          <input readonly="" type="text" class="form-control" name="studReg" value="<?php echo $reg; ?>">
          
          <input type="hidden" name="feeId" value="<?php  echo( $feeId)  ?>">
          <br>
          <div>
          	<button onclick="cancel()"  class="btn btn-block" type="button"><i class="fa fa-times"></i> Cancel</button>
          <button class="btn btn-danger btn-block" type="submit" name="delete"><i class="fa fa-trash"></i> Continue Anyway</button>
      </div>
         
        </div>
        
      </form>
    </div>
  </div>
  <?php mainJs(); ?>
  
</body>

</html>
<?php mysqli_close($conn); ?>
