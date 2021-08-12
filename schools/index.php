<?php 
error_reporting(0);
session_start();
require '../db/db_con.php';


if(isset($_POST['signin'])){
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $pass = mysqli_real_escape_string($conn, $_POST['password']);
  //$userRole = mysqli_real_escape_string($conn, $_POST['userRole']);


  if(!empty(($username)) && !empty(($pass))){
    $sql = "SELECT * from users, schools where users.username = '$username' and users.password = '$pass' and users.schoolId=schools.id";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    
    if (mysqli_num_rows($query)==1) {
      session_regenerate_id();
      $_SESSION['user'] = $row['username'];
      $_SESSION['userId']= $row['id'];
      $_SESSION['schoolId']=$row['schoolId'];
      $_SESSION['userRole']=$row['roleId'];
      session_write_close();
      if (($_SESSION['userRole']==1) ){
        header('location: main-dashboard.php');
      }
      if (($_SESSION['userRole']==2)) {
        header('location: users-dashboard.php');
    }
    if (($_SESSION['userRole']=="") ) {
        header('location: index.php?error=2');
      }
 }
  else{
    
   header('location: index.php?error=3');
 
  }
}
}
  
if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
    if ($errmsg == '3') {
      $msgerror ='Oops! Such user does not exist !';
    }
    elseif($errmsg =='2'){
        $msgerror ='Invalid Username and Password !';
    }
    elseif($errmsg =='50'){
        $msgerror ='Oops! Your Subscription to SmartSchool has just expired. Please Contact the Admin for more Details !';
    }
    
}
 ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="login">
  <meta name="keyword" content="school management system, exam, grade, result, school">
  <title>SmartSchool - Staff Login</title>

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="../assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="../assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/style-responsive.css" rel="stylesheet">
 
</head>

<body>
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
  <div id="login-page">
    <div class="container">
      <form class="form-login" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
         
        <h2 class="form-login-heading">sign in now</h2>
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
           
            
         ?></div>
        <div class="login-wrap">

                    <!--select class="form-control form-control-inline " name="userRole" required="">
                      <option value="">--Select User Role--</option>
                     <?php /* 
                    $sql=mysqli_query($conn,"SELECT * from role");
                      if (mysqli_num_rows($sql)>0 ) {           
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['roleName']; }}else{echo "NO AVAILABLE ROLE FOUND";}*/?></option>
                    </select><br-->
          <input type="text" class="form-control" autocomplete="off" name="username" placeholder="Username" autofocus>
          <br>
          <input type="password" autocomplete="off" class="form-control" name="password" placeholder="Password">
          <label class="checkbox">
            <input type="checkbox" value="remember-me"> Remember me
            <span class="pull-right">
            <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
            </span>
            </label>
          <button class="btn btn-theme btn-block" type="submit" name="signin"><i class="fa fa-lock"></i> SIGN IN</button>
         
        </div>
        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Forgot Password ?</h4>
              </div>
              <div class="modal-body">
                <p>Enter your e-mail address below to reset your password.</p>
                <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
              </div>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                <button class="btn btn-theme" type="button">Submit</button>
              </div>
            </div>
          </div>
        </div>
        <!-- modal -->
      </form>
    </div>
  </div>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="../assets/lib/jquery/jquery.min.js"></script>
  <script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
</body>
<?php mysqli_close($conn); ?>
</html>
