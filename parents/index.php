<?php 
error_reporting(0);
session_start();
require '../db/db_con.php';


if(isset($_POST['signin'])){
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $pass = mysqli_real_escape_string($conn, $_POST['password']);
  //$userRole = mysqli_real_escape_string($conn, $_POST['userRole']);
  if(!empty(($phone)) && !empty(($pass)))
  {
    $sql = mysqli_query($conn, "SELECT parent_user.phone, parent_user.username, students.school, parents.id, parent_user.stud_id FROM parent_user, students, parents WHERE parent_user.phone = '$phone' and parent_user.password = '$pass' and students.id = parent_user.stud_id and parents.regNum = parent_user.stud_id ");
    
      $row = mysqli_fetch_array($sql);
      if (mysqli_num_rows($sql)==1) 
      {
      session_regenerate_id();
      $_SESSION['username'] = $row['username'];
      $_SESSION['phone']= $row['phone'];
      $_SESSION['schoolId']= $row['school'];
      $_SESSION['parentId']= $row['id'];
      $_SESSION['studId']= $row['stud_id'];

      session_write_close();
      
        header('location: parent-dashboard.php');
      
      }
      
        else
        {
    
          header('location: index.php?error=1');
  }
}
else
        {
    
          header('location: index.php?error=2');
 
  }

}
  
if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
    if ($errmsg == '1') {
      $msgerror ='Oops! Such Username does not exist !';
    }
    elseif($errmsg =='2'){
        $msgerror ='Username or Password cannot be empty !';
    }
    elseif($errmsg =='3'){
        $msgerror ='Some parameters were not set! Please try again later';
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
  <title>SmartSchool - Parent Login</title>

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
          <input type="tel" class="form-control"  name="phone" placeholder="Registered Phone Number" autofocus onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57">
          <br>
          <input type="password" autocomplete="off" class="form-control" name="password" placeholder="Password">
          <label class="checkbox">
            <input type="checkbox" value="remember-me"> Remember me
            <span class="pull-right">
            <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
            </span>
            </label>
          <button class="btn btn-theme btn-block" type="submit" name="signin"><i class="fa fa-lock"></i> SIGN IN</button>

          <hr>
         
          <div class="registration">
            Don't have an account yet?<br/>
            <a class="" href="parent-registration.php">
              Create an account
              </a>
          </div>
         
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
 
  </script>
</body>
<?php 
mysqli_close($conn);
?>
</html>
