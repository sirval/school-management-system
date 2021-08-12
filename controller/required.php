<?php
//session_start();
require 'restricted.php';
  require '../db/db_con.php';
if (!isset($_SESSION['userId']) && !isset($_SESSION['user']) && !isset($_SESSION['schoolId']) && !isset($_SESSION['userRole']) && (($_SESSION['userRole']) == "")) {
    header('location:index.php');
}

$userRole=$_SESSION['userRole'];
 $schoolId=$_SESSION['schoolId'];
    $sql=mysqli_query($conn, "SELECT * FROM elapse_time where schoolId='$schoolId'");
    if (mysqli_num_rows($sql)>0) {
      while ($row=mysqli_fetch_array($sql)) {
        $strD=$row['startDate'];
        $enDate=$row['endDate'];
        $curDate=date('d-m-Y');
        if ($curDate==$enDate) {
          header('location: index.php?error=50');
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
        <div class="fa fa-bars tooltips" data-placement="right"></div>
      </div>
      <!--logo start-->
      <a href="<?php echo base_dir ?>" class="logo"><b><span>Smart</span>Schools</b></a>
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
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="../assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="../assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="../assets/css/zabuto_calendar.css">
  <link rel="stylesheet" type="text/css" href="../assets/lib/gritter/css/jquery.gritter.css" />
  <!-- Custom styles for this template -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/style-responsive.css" rel="stylesheet">
   <link href="../assets/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
   <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-fileupload/bootstrap-fileupload.css" />

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
          <?php
          require '../db/db_con.php';
          $schoolId=$_SESSION['schoolId'];
          $sql=mysqli_query($conn, "SELECT * FROM schools WHERE id='$schoolId'");
          while ($res=mysqli_fetch_array($sql)) {
            $logo=$res['logo'];
          }
          ?>
          <p class="centered"><a href="#"><img src="<?php echo '../schools/logo/'.$logo; ?>" class="img-circle" width="80"></a></p>
          <h5 class="centered"><?php echo $_SESSION['user']; ?> &nbsp;<i class="label label-success">Online</i></h5>
          <li class="mt">
            <a class="active" href="main-dashboard.php">
              <i class="fa fa-dashboard"></i>
              <span>Dashboard</span>
              </a>
          </li>
          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-users"></i>
              <span>Student Management</span>
              </a>
            <ul class="sub">
              <li><a href="main-dashboard.php"><i class="fa fa-refresh"></i> Import Old Students</a></li>
              <li><a href="new-student.php"><i class="fa fa-plus-square"></i> New Student</a></li>
              <li><a href="view-admitted-students.php"><i class="fa fa-eye"></i>All Admitted Students</a></li>

              <!--<li><a href="font_awesome.html">Font Awesome</a></li>-->
            </ul>
          </li>

          <li class="">
            <a href="result-processing.php">
              <i class="fa fa-book"></i>
              <span>Result Management</span>
              </a>
            
          </li>

          <li class="">
            <a href="attendance-options.php">
              <i class="fa fa-check-square"></i>
              <span>Student Attendance</span>
              </a>
            
          </li>


          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-cogs"></i>
              <span>Class Management</span>
              </a>
            <ul class="sub">
              <li><a href="new-class.php">Add Class</a></li>
                          
            </ul>
          </li>
          
          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-money"></i>
              <span>Finance</span>
              </a>
            <ul class="sub">
              <li><a href="payment-registration.php">Register New Payment</a></li>
              <li><a href="paid-students.php">All Paid Students</a></li>
              <li><a href="daily-expenses.php">Daily Expenses</a></li>
              <li><a href="view-expenses.php">View Expenses</a></li>
            </ul>
          </li>
         <li class="mt">
            <a  href="report.php">
              <i class="fa fa-book"></i>
              <span>Report</span>
              </a>
          </li>
          <li>
            <a href="./logout.php">
              <i class="fa fa-lock"></i>
              <span>Logout</span>
              </a>
          </li>
        </ul>
        <br><br><br>
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
        <p style="color: #fff">
          &copy; Copyrights <?php echo date('Y'); ?> <strong>SmartSchool</strong>. All Rights Reserved
        </p>
        <p style="color: blue; text-align: center;">
          <a href="../terms-of-service.php">Terms of Service</a> | <a href="../privacy-policy.php">Privacy Policy</a>
        </p>
        <div class="credits">
         
          <label style="color: #fff"> Powered by </label>&nbsp;<a href="http://wa.me/2348082646718" target="_blank">Outsmart Ideas</a>
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
function mainJs()
{
  ?>
   <!-- js placed at the end of the document so the pages load faster -->
  <script src="../assets/lib/jquery/jquery.min.js"></script>

  <script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="../assets/lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="../assets/lib/jquery.scrollTo.min.js"></script>
  <script src="../assets/lib/jquery.nicescroll.js" type="text/javascript"></script>
  <script src="../assets/lib/jquery.sparkline.js"></script>
  <!--common script for all pages-->
  <script src="../assets/lib/common-scripts.js"></script>
  <script type="text/javascript" src="../assets/lib/gritter/js/jquery.gritter.js"></script>
  <script type="text/javascript" src="../assets/lib/gritter-conf.js"></script>
  <!--script for this page-->
  <script src="../assets/lib/sparkline-chart.js"></script>
  <script src="../assets/lib/zabuto_calendar.js"></script>
 
  <?php
}
function tableMeta()
{
  ?>
  <script src="../assets/lib/jquery/jquery.min.js"></script>
  <script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="../assets/lib/jquery.scrollTo.min.js"></script>
  <script src="../assets/lib/jquery.nicescroll.js" type="text/javascript"></script>
  <!--common script for all pages-->
  <script src="../assets/lib/jquery/jquery.min.js"></script>
  <script type="text/javascript" language="javascript" src="../assets/lib/advanced-datatable/js/jquery.js"></script>
  <script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="../assets/lib/jquery.dcjqaccordion.2.7.js"></script>
 
  <script type="text/javascript" language="javascript" src="../assets/lib/advanced-datatable/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="../assets/lib/advanced-datatable/js/DT_bootstrap.js"></script>
  <!--common script for all pages-->
  <script src="../assets/lib/common-scripts.js"></script>
  <?php
}
?>