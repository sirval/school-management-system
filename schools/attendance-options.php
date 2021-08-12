
<?php
//error_reporting(0);
session_start();
require '../db/db_con.php';
  if (isset($_POST['proceed'])) 
{
      $day = strip_tags(mysqli_real_escape_string($conn, $_POST['day']));
      $month = strip_tags(mysqli_real_escape_string($conn, $_POST['month']));
      $year = strip_tags(mysqli_real_escape_string($conn, $_POST['year']));
      $term = strip_tags(mysqli_real_escape_string($conn, $_POST['term']));
      $studClass = strip_tags(mysqli_real_escape_string($conn, $_POST['studClass']));
      $Mor_After = strip_tags(mysqli_real_escape_string($conn, $_POST['session']));
      $attDate = $day."-".$month."-".$year;
    if ((!empty($attDate)) && (!empty($term)) && (!empty($studClass)) && (!empty($Mor_After))) 
    {
       //session_regenerate_id();
      $_SESSION['attDate'] = $attDate;
      $_SESSION['term']= $term;
      $_SESSION['studClass']=$studClass;//student class
      $_SESSION['Mor_After']=$Mor_After;
      $_SESSION['year']=$year;
    if ($_SESSION['Mor_After'] == "Morning") 
    {
     echo 
        "
        <script>
        window.location.href='student-attendance-morning.php';
        </script>
        ";
      }
      elseif ($_SESSION['Mor_After'] == "Afternoon") 
      {
        echo 
        "
        <script>
        window.location.href='student-attendance-afternoon.php';
        </script>
        ";
      }
        
    }
    else
    {
      echo "<script> alert('Kindly supply all required data');
      window.location.href='attendance-options.php';
       </script>";
       exit();
    }
  }

  if (isset($_POST['update'])) 
{
      $day = strip_tags(mysqli_real_escape_string($conn, $_POST['day']));
      $month = strip_tags(mysqli_real_escape_string($conn, $_POST['month']));
      $year = strip_tags(mysqli_real_escape_string($conn, $_POST['year']));
      $term = strip_tags(mysqli_real_escape_string($conn, $_POST['term']));
      $studClass = strip_tags(mysqli_real_escape_string($conn, $_POST['studClass']));
      $Mor_After = strip_tags(mysqli_real_escape_string($conn, $_POST['session']));
      $attDate = $day."-".$month."-".$year;
    if ((!empty($attDate)) && (!empty($term)) && (!empty($studClass)) && (!empty($Mor_After))) 
    {
       //session_regenerate_id();
      $_SESSION['attDate'] = $attDate;
      $_SESSION['term']= $term;
      $_SESSION['studClass']=$studClass;//student class
      $_SESSION['Mor_After']=$Mor_After;
      $_SESSION['year']=$year;
    
     echo 
        "
        <script>
        window.location.href='update-attendance.php';
        </script>
        ";
        
    }
    else
    {
      echo "<script> alert('Kindly supply all required data');
      window.location.href='attendance-options.php';
       </script>";
       exit();
    }
  }

  if (isset($_POST['view'])) 
{
      $day = strip_tags(mysqli_real_escape_string($conn, $_POST['day']));
      $month = strip_tags(mysqli_real_escape_string($conn, $_POST['month']));
      $year = strip_tags(mysqli_real_escape_string($conn, $_POST['year']));
      $term = strip_tags(mysqli_real_escape_string($conn, $_POST['term']));
      $studClass = strip_tags(mysqli_real_escape_string($conn, $_POST['studClass']));
      $Mor_After = strip_tags(mysqli_real_escape_string($conn, $_POST['session']));
      $attDate = $day."-".$month."-".$year;
    if ((!empty($attDate)) && (!empty($term)) && (!empty($studClass)) && (!empty($Mor_After))) 
    {
       //session_regenerate_id();
      $_SESSION['attDate'] = $attDate;
      $_SESSION['term']= $term;
      $_SESSION['studClass']=$studClass;//student class
      $_SESSION['Mor_After']=$Mor_After;
      $_SESSION['year']=$year;
    
     echo 
        "
        <script>
        window.location.href='view-attendance-morning.php';
        </script>
        ";
        
    }
    else
    {
      echo "<script> alert('Kindly supply all required data');
      window.location.href='attendance-options.php';
       </script>";
       exit();
    }
  }
    

  if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 1) 
  {
      require '../controller/required.php'; 
  }
    else
    {
      require '../controller/users_required.php'; 
    }
   /*if (!isset($_SESSION['userId']) && !isset($_SESSION['user'])) {
    header('location:index.php');
}
$userId=$_SESSION['userId'];
$userSchool=$_SESSION['schoolId'];*/
siteTitle(mysite, ' || ', '  Admin'.' || ' . $_SESSION['user']);
   meta();
    pageHeader();
   sideBar();
   
   ?>
  <link href="../assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="../assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  
  <link href="../assets/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
  
  <!-- Custom styles for this template -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/style-responsive.css" rel="stylesheet">
  <style type="text/css">
    .padTable{
      margin: 10px;
    }
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="col-md-12 mt">
          <div class="row content-panel">
            <div class="col-md-12">
             
            
              
 <div class="invoice-body">
   
         <div>
          <?php
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

        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
            Select the Session[Morning or Afternoon], Day, Month, Year, Term, Class and click on proceed to view students inorder to mark roll call  
        </div>
      
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="post" class="style-form" enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="col-md-1">
            <strong>Session: </strong>
          </div>
                
          <div class="col-md-4">
                  <select name="session" class="form-control" required="">
                  <option value="">--Select Session--</option>
                  <option value="Morning">Morning</option>
                  <option value="Afternoon">Afternoon</option>
                </select><br>
      </div>
                    <div class="col-md-1" >
                      <strong>Date: </strong>
                    </div>
                 <div class="col-md-2">
                <select name="day" class="form-control form-control-inline input-medium " required="">
                  <?php 
                  for($day=1; $day <=31; $day++)
                  {
                    echo '<option value="'.$day.'">'.$day.'</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-2">
                <select name="month" class="form-control form-control-inline input-medium " required="">
                  <?php 
                  for($month=1; $month <=12; $month++)
                  {
                    echo '<option value="'.$month.'">'.$month.'</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-2">
                 <?php 
                  echo '<select name="year" class="form-control form-control-inline input-medium ">'.PHP_EOL;
                  for($year=date("Y"); $year <=date("Y")+10; $year++)
                  {
                     echo '<option value="'.$year.'">'.$year.'</option>'.PHP_EOL;
                  }
                  echo '</select>';
                 ?>
                <br>
              </div>
            </div>

            <div class="form-group">

              <div class="col-md-2">
                <strong>Term: </strong>
              </div>
              <div class="col-md-4">
                    <select class="form-control form-control-inline input-medium "  name="term" id="term" required="">
                      <option>--Select Term--</option>
                      <?php 
                      require '../db/db_con.php';
                    $sql=mysqli_query($conn,"SELECT * from term");
                      if (mysqli_num_rows($sql)>0 ) {           
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['termName']; }}else{echo "NO AVAILABLE TERM FOUND";}?></option>
                    </select><br>  
                     
                  </div>
                  <div class="col-md-2">
                <strong>Class: </strong>
              </div>
                
                <div class="col-md-4">
              <select name="studClass" id="studClasses" required="" class="form-control">
                <option value="">--Select Class--</option>
                    <?php 
                        $sqlClass = mysqli_query($conn,"select * from class ");
                            if (mysqli_num_rows($sqlClass)) {
                                while($result = mysqli_fetch_array($sqlClass)){
                                  $classId=$result['id'];
                    ?>
                <option value="<?php echo $classId; ?>"><?php echo $result['classCode'] ;}}else{echo "No Available Class Found";}?></option>
                               
            </select><br>
              
            </div>
          </div>
    <div class="form-group">
      <div class="col-md-4">
       <button class="btn btn-primary btn-sm pull-right" name="proceed">Take New Roll Call&nbsp;<i class="fa fa-arrow-right"></i> </button>
    </div>
    <div class="col-md-4">
    <button class="btn btn-danger btn-sm pull-right" name="update"> Update Roll Call &nbsp;<i class="fa fa-edit"></i></button> 
   </div>
   <div class="col-md-4">
    <button class="btn btn-theme btn-sm pull-right" name="view"> View Roll Call &nbsp;<i class="fa fa-eye"></i></button><br><br><br><br><br><br>
   </div>
 </div>
         
</form>

              <!--/col-lg-12 mt -->
      </section>
      <!-- /wrapper -->
    </section><br><br>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
    <!--footer start-->
    <footer class="">
      <div class="text-center">
                
      <?php footer();
      ?>
      </div>
    </footer>
    <!--footer end-->
  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="../assets/lib/jquery/jquery.min.js"></script>

<script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../assets/lib/jquery.dcjqaccordion.2.7.js"></script>
<script src="../assets/lib/jquery.scrollTo.min.js"></script>
<script src="../assets/lib/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../assets/lib/jquery.sparkline.js"></script>
<script src="../assets/lib/common-scripts.js"></script>
<script type="text/javascript" src="../assets/lib/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="../assets/lib/gritter-conf.js"></script>
 <script type="text/javascript">
 

$(window).on('load', function() {
  $('myModalLoader').modal('show');
});

</script>
   
</body>

</html>
<?php
mysqli_close($conn);
?>

</body>

</html>