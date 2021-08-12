<?php 
session_start();
require '../db/db_con.php';


if(isset($_POST['signin'])){
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $pass = mysqli_real_escape_string($conn, $_POST['password']);

  if(!empty(trim($username)) && !empty(trim($pass))){
    $sql = "SELECT * from admin_account where username = '$username' and password = '$pass' ";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    
    if (mysqli_num_rows($query)==1) {
      session_regenerate_id();
      $_SESSION['username'] = $row['username'];
      $_SESSION['usersn']= $row['id'];
      session_write_close();
     header('location: dashboard.php');
    }
    else{
   header('location: index.php?error=2');
 }

  }
  else{
    
   header('location: index.php?error=3');
 
  }
}
  
if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
    if ($errmsg == '3') {
      $msgerror ='Oops! An error was encountered while trying to process your request !';
    }
    elseif($errmsg =='2'){
        $msgerror ='Invalid Username and Password !';
    }

    elseif($errmsg =='38'){
        $msgerror ='The System needs to be Upgraded. Contact Outsmart Ideas for More Details';
    }
    
}

 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>SmartSchool - System Admin Login</title>

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">
 
</head>

<body>
  
  <div id="login-page">
    <div class="container">
      <div>
      <form class="form-login" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <h2 class="form-login-heading">system admin sign in</h2>
        <div class="login-wrap">
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
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
                <?php echo $msgsucc; ?></div>
        <?php
            }
         ?>
       </div>
          <input type="text" class="form-control" name="username" placeholder="Username" required="" autocomplete="off" autofocus>
          <br>
          <input type="password" autocomplete="off" required="" class="form-control" name="password" placeholder="Password">
          <label class="checkbox">
            <input required="" title="Please Accept Terms of Service and Privacy Policy" type="checkbox" value="remember-me"> I Accept <a href="../terms-of-service.php">Terms of Service</a> and <a href="../privacy-policy.php" > Privacy Policy<br><br><br>
            <span class="pull-right">
            <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
            </span>
            </label>
          <button class="btn btn-theme btn-block" name="signin" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
          <hr>
         
          <div class="registration">
            Don't have an account yet?<br/>
            <a class="" href="#">
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
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <!--BACKSTRETCH-->
  <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
  <script type="text/javascript" src="lib/jquery.backstretch.min.js"></script>
  <script>
    $.backstretch("img/login-bg.jpg", {
      speed: 500
    });
  </script>
</body>

</html>
