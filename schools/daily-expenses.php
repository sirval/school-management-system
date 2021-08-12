<?php
error_reporting(0);
session_start();
require '../db/db_con.php';
if (isset($_POST['go'])) {
  
  $date = strip_tags(mysqli_real_escape_string($conn, $_POST['date']));
  $time = strip_tags(mysqli_real_escape_string($conn, $_POST['time']));
  $product = strip_tags(mysqli_real_escape_string($conn, $_POST['proName']));
  $qty = strip_tags(mysqli_real_escape_string($conn, $_POST['qty']));
  $price= strip_tags(mysqli_real_escape_string($conn, $_POST['cost']));
  $totalExp= strip_tags(mysqli_real_escape_string($conn, $_POST['totalExp']));
  $authBy = strip_tags(mysqli_real_escape_string($conn, $_POST['authBy']));
  $purBy = strip_tags(mysqli_real_escape_string($conn, $_POST['purBy']));
  $term = strip_tags(mysqli_real_escape_string($conn, $_POST['term']));

  if (!isset($product) || trim(strlen($product)) =='') {
    header('location: daily-expenses.php?error=1');
    exit();
 }
  if (!isset($qty) || trim(strlen($qty)) =='') {
    header('location: daily-expenses.php?error=2');
    exit();
}
 if (!isset($price) || trim(strlen($price)) =='') {
    header('location: daily-expenses.php?error=3');
    exit();
 }
 if (!isset($totalExp) || trim(strlen($totalExp)) =='') {
    header('location: daily-expenses.php?error=4');
    exit();
 }
 if (!isset($authBy) || trim(strlen($authBy)) =='') {
    header('location: daily-expenses.php?error=5');
    exit();
 }
 if (!isset($purBy) || trim(strlen($purBy)) =='') {
    header('location: daily-expenses.php?error=6');
    exit();
 }
 if (!isset($term) || trim(strlen($term)) =='') {
    header('location: daily-expenses.php?error=10');
    exit();
 }
$query=mysqli_query($conn, "INSERT INTO `expenses`(`date`, `time`,`termId`, `product`, `qty`, `price`, `totalCost`, `authBy`, `purBy`) VALUES ('$date', '$time','$term','$product','$qty','$price','$totalExp','$authBy','$purBy')");
$query2=mysqli_query($conn, "INSERT INTO `expenses_backup`(`date`, `time`,`termId`, `product`, `qty`, `price`, `totalCost`, `authBy`, `purBy`) VALUES ('$date', '$time','$term','$product','$qty','$price','$totalExp','$authBy','$purBy')");
if (mysqli_affected_rows($conn)>0) {
  echo "<script>alert 'Expenses Added Successfully';</script>";
  header('location: view-expenses.php');
  exit();

}else{
  header('location: daily-expenses.php?error=7');
    exit();
}
}
if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
    if ($errmsg == '1') {
      $msgerror ='Error: Product field cannot be empty!';
    }
    if ($errmsg == '2') {
      $msgerror ='Error: Quantity field cannot be empty!';
    }
     if ($errmsg == '3') {
      $msgerror ='Error: Price field cannot be empty!';
    }
     if ($errmsg == '4') {
      $msgerror ='Error: Total expenses required!';
    }
     if ($errmsg == '5') {
      $msgerror ='Error: Enter the name of the authoriser';
    }
     if ($errmsg == '6') {
      $msgerror ='Error: Enter name of buyer';
    }
    if ($errmsg == '10') {
      $msgerror ='Error: Select term for expenses';
    }
    if ($errmsg == '7') {
      $msgerror ='Error: Oops! An error occurred while trying to process your request.';
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
           
         ?>
        </div> 
       
        <h3><span class="label label-primary label-mini"><i class="fa fa-clock-o" ></i> DAILY EXPENSES</span></h3><br>
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
              	<div class="form-group">
                  
                  <div class="col-md-3 ">
                    <input class="form-control form-control-inline input-medium " name="date" id="date" type="text" readonly="" value="<?php echo date('d-m-Y D'); ?>">  
                    
                  </div>
                  <div class="col-md-3">
                    <input class="form-control form-control-inline input-medium " name="time" id="time"  type="text" readonly="" value="<?php echo date('h:i:s a'); ?>">  
                    
                  </div>


                  <label class="control-label col-sm-2">Expenses Term</label>
                  <div class="col-md-3">
                    <select required="" class="form-control form-control-inline " name="term" id="term">
                      <option value="">--Select Expenses Term--</option>
                      <?php 
                    $sql=mysqli_query($conn,"SELECT * from term");
                      if (mysqli_num_rows($sql)>0 ) {           
               
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['termName']; }}?></option>
                    </select>
                  </div>
                </div>

                 <div class="form-group">
                
                <label class="control-label col-sm-1">Product</label>
                  <div class="col-md-3">
                  <input class="form-control form-control-inline input-medium " name="proName" id="proName" required=""   placeholder="Product Name">
                  </div>
                  <label class="control-label col-sm-1">Authorised By</label>
                  <div id="total" class="col-md-3 ">
                  <input class="form-control form-control-inline input-medium" name="authBy" id="authBy" required="" placeholder="Authorised By">
                     
                  </div>
                   <label class="control-label col-sm-1">Purchased By</label>
                  <div id="total" class="col-md-3 ">
                  <input class="form-control form-control-inline input-medium" name="purBy" id="purBy" required=""  placeholder="Purchased By">
                     
                  </div>

              </div>

              <div class="form-group">
                
                <label class="control-label col-sm-1">Quantity</label>
                  <div class="col-md-2">
                  <input type="number" class="form-control form-control-inline input-medium toPay" name="qty" id="qty" required="" oninput="calculate()" onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57" placeholder="Quantity">
                                                 
                    
                  </div>
                  <label class="control-label col-sm-2">Cost-per-Unit</label>
                  <div class="col-md-2 ">
                  <input class="form-control form-control-inline input-medium toPay" name="cost" id="cost" required="" placeholder="Cost Per One" oninput="calculate()"  onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57">
                                              
                    
                  </div>

                  <label class="control-label col-sm-2">Total Expenses</label>
                  <div id="total" class="col-md-3 ">
                  <input class="form-control form-control-inline input-medium total" name="totalExp" id="totalExp" readonly=""  placeholder="Total Expenses">
                     
                  </div>

              </div>
             
                 <div class="form-group">
                 	<div class="col-md-12">
                 <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="new-school-users.php#myModal">Save&nbsp;<i class="fa fa-arrow-right"></i> </a><br><br>  
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

   <!-- js placed at the end of the document so the pages load faster -->
   <?php mainJs(); ?>
  <script type="text/javascript">
   function calculate() {
      var qty= document.getElementById('qty').value;
      var cost = document.getElementById('cost').value;
      var result =document.getElementById('totalExp');
      var totalExp=qty * cost;
      result.value=totalExp;
    }
   

  
  </script>

</body>

</html>
<?php mysqli_close($conn); ?>
