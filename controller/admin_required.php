<?php
session_start();
require 'restricted.php';
  require '../db/db_con.php';
if (!isset($_SESSION['usersn']) && !isset($_SESSION['username'])) {
    header('location:index.php');
}
$userId=$_SESSION['usersn'];
    $sql=mysqli_query($conn, "SELECT * FROM mnbvcxz where adminId='$userId'");
    if (mysqli_num_rows($sql)>0) {
      while ($row=mysqli_fetch_array($sql)) {
        $endr=$row['enrate'];
        $curDate=date('d-m-yy');
        if ($curDate==$endr) {
          header('location: index.php?error=38');
        }
      }
      }
function pageHeader()
{
	?>
	   <!--header start-->
     <body>
  <section id="container">
    <header class="header black-bg">
      <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
      </div>
      <!--logo start-->
      <a href="http://localhost/esquare" class="logo"><b><span>Smart</span>Schools</b></a>
      <!--logo end-->
      
      <div class="top-menu">
        <ul class="nav pull-right top-menu">
          <li><a class="logout" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </header>
    <!--header end-->
    <?php
}
function meta()
{
  ?>
  <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="student, teachers, report card, payment,school, management">
  <!-- Favicons -->
  <link href="../img/favicon.png" rel="icon">
  <link href="../img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="css/zabuto_calendar.css">
  <link rel="stylesheet" type="text/css" href="lib/gritter/css/jquery.gritter.css" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-fileupload/bootstrap-fileupload.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-datepicker/css/datepicker.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-timepicker/compiled/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-datetimepicker/datertimepicker.css" />
  <script src="lib/chart-master/Chart.js"></script>

  </head>
</html>
<?php
}

function sideBar()
 {
  ?>

  <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
          <p class="centered"><a href="#"><img src="img/avatar.png" class="img-circle" width="80"></a></p>
          <h5 class="centered"><?php echo $_SESSION['username']; ?> &nbsp;<i class="label label-success">Online</i></h5>
          <li class="mt">
            <a class="active" href="dashboard.php">
              <i class="fa fa-dashboard"></i>
              <span>Dashboard</span>
              </a>
          </li>
          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-cogs"></i>
              <span>Settings</span>
              </a>
            <ul class="sub">
              <li><a href="new-school.php"> Add School</a></li>
              <li><a href="new-school-users.php"> Add School Admin</a></li>
              <li><a href="timeframe.php"> Add Time Frame</a></li>
              <li><a href="all-registered-school.php"> All Registered Schools</a></li>

              
              <!--<li><a href="font_awesome.html">Font Awesome</a></li>-->
            </ul>
          </li>
           <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-pin"></i>
              <span>PIN</span>
              </a>
            <ul class="sub">
              <li><a href="pin-generator.php"> New PIN</a></li>
              <li><a href="pin-view-all.php"> View All PIN</a></li>
              <li><a href="used-pin.php"> Used PIN</a></li>
             
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-cloud"></i>
              <span>Backup</span>
              </a>
            <ul class="sub">
              <li><a href="expenses-backup.php"> Expenses</a></li>
              <li><a href="student-fees-backup.php"> Student Fees</a></li>
            
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-cog"></i>
              <span>Security Setting</span>
              </a>
            <ul class="sub">
              <li><a href="update-super-admin.php"> Update Account</a></li>
              <li><a href="logout.php"> Logout</a></li>
            
            </ul>
          </li>
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <?php
}
function footer()
{
?>
<style type="text/css">
    .footer{
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
      background-color: #2F323A;
      text-align: center;
    }
  </style>
<footer class="footer site-footer">
  
      <div class="text-center">
        <p>
          &copy; Copyrights <?php echo date('Y'); ?> <strong>Esquare</strong>. All Rights Reserved
        </p>
        <p style="float: right; margin-right: 5px; color: #4ECDC4"><i> Version: 1.1.0</i></p>
        <div class="credits">
         
          Powered by <a href="http://wa.me/2348082646718" target="_blank">Outsmart Ideas</a>
        </div>
        
      </div>
    </footer>
    <?php
}
function siteTitle($title1,$divider,$title2)
{
  $title='<title>'.$title1.$divider.$title2.'</title>';
  echo $title;
}


?>