<?php 
error_reporting(0);
session_start();
require '../db/db_con.php';


if(isset($_POST['signup']))
{
	  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
	  $email = mysqli_real_escape_string($conn, $_POST['email']);
	  $username = mysqli_real_escape_string($conn, $_POST['username']);
	  $password = mysqli_real_escape_string($conn, $_POST['password']);
	  //$userRole = mysqli_real_escape_string($conn, $_POST['userRole']);
if (preg_match('/^[0-9]{11}+$/', $phone)== false) {
    header('location: parent-registration.php?error=1');
    exit();
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  	 header('location: parent-registration.php?error=2');
    exit();
  }
   if (!isset($username) || trim(strlen($username)) =='') {
    header('location: parent-registration.php?error=3');
    exit();
 }

 $uppercase= preg_match('@[A-Z]@', $password);
  $lowercase= preg_match('@[a-z]@', $password);
  $digit= preg_match('@[0-9]@', $password);
  $specialChars= preg_match('@[^\w]@', $password);

   if (!$uppercase|| !$lowercase|| $digit) 
   {
    header('location: parent-registration.php?error=4');
    exit();
   }

   $auth_user = mysqli_query($conn,"SELECT * FROM `parent_user` WHERE phone='$phone'");
   if ( mysqli_num_rows($auth_user)>0) {
   	header('location: parent-registration.php?error=6');
    exit();
   }

   $getStudReg = mysqli_query($conn,"SELECT * FROM `parents` WHERE phone='$phone'");
   if ( mysqli_num_rows($getStudReg)>0) {
    while ($getReg = mysqli_fetch_array($getStudReg)) {
      $reg = $getReg['regNum'];
    }
  }
  else
  {
    header('location: parent-registration.php?error=7');
    exit();
  }
   
   $query=( "INSERT INTO `parent_user`(`email`, `username`, `password`, `phone`, `stud_id` ) VALUES ('$email', '$username', '$password', '$phone', '$reg')");
   if (mysqli_query($conn, $query)) {
   	header('location: parent-registration.php?registration=successful');
    exit();
   }
   else
   {
   	header('location: parent-registration.php?error=5');
    exit();
   }


}
  
if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
    if ($errmsg == '1') {
      $msgerror ='Error: Phone required and must be 11 digits!';
    }
    if ($errmsg == '2') {
      $msgerror ='Error: Invalid Email Address!';
    }
     if ($errmsg == '3') {
      $msgerror ='Error: Username cannot be empty!';
    }
     if ($errmsg == '4') {
      $msgerror ='Error: Password must be a combination of Uppercase, lowercase and digit or special characters!';
    }
    if ($errmsg == '5') {
      $msgerror ='Error: An error occured while trying to process your request! Try again later';
    } 
    if ($errmsg == '6') {
      $msgerror ='Error: This phone number has an account already with us <a style="color: blue; font-weight: bolder;" href="index.php"> LOGIN </a>  instead';
    }
    if ($errmsg == '7') {
      $msgerror ='Error: An error occured that is all we know!';
    }  
}

if (isset($_GET['registration']) && $_GET['registration']=='successful') {
  $msgsucc='Registration Successful! You can now <a style="color: blue; font-weight: bolder;" href="index.php"> LOGIN </a>  here';
}

require '../controller/restricted.php';

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
         
        <h2 class="form-login-heading">sign up now</h2>
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
        <div class="login-wrap">


                    <div class="input-append">
                    <input class="form-control form-control-inline " placeholder="Registered Phone Number" name="phone" id="phone"  type="tel" required="" onblur="checkAvailability()" onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57" autofocus> 

                    
                     <span class="input-group-btn add-on" >
                        <p><img height="30px" width="30px" src="img/loaderIcon.gif" id="loaderIcon" style="display: none;"></p>
                        </span>
                        <p id="userAvailability-status"></p>
                        
                       
                  </div><br>
                  <input type="email" class="form-control" name="email" placeholder="Email" autofocus><br>

            <input type="text" class="form-control" autocomplete="off" name="username" placeholder="Username" autofocus>
          <br>
          <input type="password" autocomplete="off" class="form-control" name="password" placeholder="Password"><br>
            </label>
          <button id="signup"  class="btn btn-theme btn-block" type="submit" name="signup"><i class="fa fa-lock"></i> SIGN UP</button>

          <hr>
         
          <div class="registration">
            Already have an account?<br/>
            <a class="" href="index.php">
             Sign In
              </a>
              <hr>
              <a class="" href="<?php echo base_dir  ?>">
             Back to Home
              </a>
          </div>
         
        </div>
       
      </form>
    </div>
  </div>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="../assets/lib/jquery/jquery.min.js"></script>
  <script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <!--BACKSTRETCH-->
  <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
  <script type="text/javascript" >
    function checkAvailability() {
  $("#loaderIcon").show();
  jQuery.ajax({
    url: "checkPhone.php",
    data: 'phone='+$("#phone").val(),
    type: "POST",
    success:function (data) {
      $("#userAvailability-status").html(data);
      $("#loaderIcon").hide();
     // $("#signup").removeAttr('disabled');
    },
    error:function () {
      
    }
  });
}
  </script>
}
</body>

</html>
<?php
mysqli_close($conn);
?>
