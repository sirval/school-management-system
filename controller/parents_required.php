<?php
//session_start();
require 'restricted.php';
  require '../db/db_con.php';
if (!isset($_SESSION['username']) && !isset($_SESSION['phone']) && !isset($_SESSION['schoolId']) ) {
    header('location:index.php');
}

    $studSchool=$_SESSION['schoolId'];
    $sql=mysqli_query($conn, "SELECT * FROM elapse_time where schoolId='$studSchool'");
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
        <div class="fa fa-bars tooltips" data-placement="right" ></div>
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
  <meta name="keyword" content="student, teachers,pin generation result, payment,school, management, parent">
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
  <link href="css/style-responsive.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-fileupload/bootstrap-fileupload.css" />
  <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-datepicker/css/datepicker.css" />
  <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-timepicker/compiled/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-datetimepicker/datertimepicker.css" />
  <script src="../assets/lib/chart-master/Chart.js"></script>

  </head>
</html>
<?php
}
function tableMeta()
{
  ?>
<link href="lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
  <link href="lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">
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
          $studSchool=$_SESSION['schoolId'];
          $sql=mysqli_query($conn, "SELECT * FROM schools WHERE id='$studSchool'");
          while ($res=mysqli_fetch_array($sql)) {
            $logo=$res['logo'];
          }
          ?>
          <p class="centered"><a href="#"><img src="<?php echo '../schools/logo/'.$logo; ?>" class="img-circle" width="80"></a></p>
          <h5 class="centered"><?php echo $_SESSION['username']; ?> &nbsp;<i class="label label-success">Online</i></h5>
          <li class="mt">
            <a class="active" href="parent-dashboard.php">
              <i class="fa fa-dashboard"></i>
              <span>Dashboard</span>
              </a>
          </li>
          <li class="">
            <a href="attendance-option.php">
              <i class="fa fa-eye"></i>
              <span>View Attendance </span>
              </a>
             
            
          </li>
          <li class="">
            <a href="result-checker.php">
              <i class="fa fa-book"></i>
              <span>Check Result </span>
              </a>
            
          </li>
          <li class="">
            <a href="parent-dashboard.php?warning=unavailable gateway">
              <i class="fa fa-money"></i>
              <span>Make Payment </span>
              </a>
            
          </li>

          

          
          
          <li>
            <a href="logout.php">
              <i class="fa fa-lock"></i>
              <span>Logout</span>
              </a>
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
        <p style="color: #fff">
          &copy; Copyrights <?php echo date('Y'); ?> <strong>SmartSchool</strong>. All Rights Reserved
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

?>