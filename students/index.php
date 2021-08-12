<?php 
session_start();
require '../db/db_con.php';


if(isset($_POST['signin']))
{
  $username = mysqli_real_escape_string($conn, $_POST['regNum']);
  $pass = mysqli_real_escape_string($conn, $_POST['password']);
  //$userRole = mysqli_real_escape_string($conn, $_POST['userRole']);


  if(!empty(strtoupper($username)) && !empty(($pass)))
  {
    $sql = ("SELECT students.surname, students.regNum, students.id , students.school FROM students, parents WHERE students.regNum = '$username' and parents.phone = '$pass' and students.id=parents.regNum");
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    if (mysqli_num_rows($query)==1) 
    {
    
      
      $_SESSION['student'] = $row['surname'];
      $_SESSION['reg']= $row['regNum'];
      $_SESSION['studSchool']=$row['school'];
      $_SESSION['studentId'] = $row['id'];
      if (!empty($_SESSION['student']) && !empty($_SESSION['studentId']) && !empty($_SESSION['studSchool'])) 
      {
        header('location: student-dashboard.php');
       
      }
      else
      {
        header('location: index.php?error=4');
        exit();
      }
      
    }
  else
  {
    
   header('location: index.php?error=3');
   exit();
  }
}
else
{
  header('location: index.php?error=5');
   exit();
}
}
  
if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
    if ($errmsg == '4') {
      $msgerror ='Error: Oops! A fatal error occcured while trying to process your request. Please try again later!';
    }
    elseif($errmsg =='3'){
        $msgerror ='Warning: Invalid Admission Number and Password !';
    }
    elseif($errmsg =='3'){
        $msgerror ='Warning: Either Admission Number or Password is Empty !';
    }
    elseif($errmsg =='50')
    {
        $msgerror ='Error: Oops! Your Subscription to SmartSchool has just expired. Please Contact your school Admin for more Details !';
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
  <title>SmartSchool - Student Login</title>

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
  <section class="banner-area relative">
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

          <input type="text" class="form-control" autocomplete="off" name="regNum" placeholder="Enter Admission Number" autofocus>
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
  
  </script>
</body>

</html>
