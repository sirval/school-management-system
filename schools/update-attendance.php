
<?php
error_reporting(0);
session_start();
    require '../db/db_con.php';
     if (isset($_POST['updateRollCall'])) 
     {
      
       
     	if ((isset($_POST['vSession']) && !empty($_POST['vSession']) && ($_POST['vSession']) == "Morning") && !empty($_POST['year']) && !empty($_POST['date']) && !empty($_POST['term']) && !empty($_POST['studId']) && is_array($_POST['year']) && is_array($_POST['date']) && is_array($_POST['term']) && is_array($_POST['studId']) && count($_POST['studId'])) {
         $class_id = mysqli_real_escape_string($conn, $_POST['class_id']);
      
       
     	$myearArr= $_POST['year'];
     	$mtermArr= $_POST['term'];
     	$mstudIdArr= $_POST['studId'];
     	//$studClassArray= $_POST['studClass'];
     	$mDateArr= $_POST['date'];
     	$mpresentArr= $_POST['pre'];
     	

     	
     	 
     	for ($i=0; $i < count($mstudIdArr); $i++) { 
     	$myear= mysqli_real_escape_string($conn, $myearArr[$i]);
     	$mterm= mysqli_real_escape_string($conn, $mtermArr[$i]);
     	$mstudId= mysqli_real_escape_string($conn, $mstudIdArr[$i]);
     	//$class_id= mysqli_real_escape_string($conn, $studClassArray[$i]);
     	//$section= mysqli_real_escape_string($conn, $morAfterArr[$i]);
      $mDate= mysqli_real_escape_string($conn, $mDateArr[$i]);
     	$mpresent= mysqli_real_escape_string($conn, $mpresentArr[$i]);
     
     if (empty($mpresent)) {
      echo "<script> alert ('Error');</script>";
     }
      
     
      $query =( "UPDATE `attendance_morning` SET `present`='$mpresent' WHERE `date`='$mDate' and `studentId`='$mstudId' and `term`='$mterm'");
      if (mysqli_query($conn, $query)) {
        echo "<script> 
        window.location.href='update-attendance.php?confirm=successful'
        </script>";

      }else{
        echo "<script> 
        window.location.href='update-attendance.php?error=2'
        
        </script>";
        exit();
      }
      }
    }
     //mark register for afternoon
       elseif ((isset($_POST['vSession']) && !empty($_POST['vSession']) && ($_POST['vSession']) == "Afternoon")) 
       {
        $class_id = mysqli_real_escape_string($conn, $_POST['class_id']);
      
        if (!empty($_POST['year']) && !empty($_POST['date']) && !empty($_POST['term']) && !empty($_POST['studId']) && is_array($_POST['year']) && is_array($_POST['date']) && is_array($_POST['term']) && is_array($_POST['studId']) && count($_POST['studId'])) {
       
          
      $afyearArr= $_POST['year'];
      $aftermArr= $_POST['term'];
      $afStudId= $_POST['studId'];
      //$studClassArray= $_POST['studClass'];
      $aftDateArr= $_POST['date'];
      $afPre= $_POST['pr'];

      
       
      for ($i=0; $i < count($afStudId); $i++) { 
      $year= mysqli_real_escape_string($conn, $afyearArr[$i]);
      $term= mysqli_real_escape_string($conn, $aftermArr[$i]);
      $studId= mysqli_real_escape_string($conn, $afStudId[$i]);
      //$class_id= mysqli_real_escape_string($conn, $studClassArray[$i]);
      //$section= mysqli_real_escape_string($conn, $morAfterArr[$i]);
      $date= mysqli_real_escape_string($conn, $aftDateArr[$i]);
      $present= mysqli_real_escape_string($conn, $afPre[$i]);
     
      $query2 =( "UPDATE `attendance_afternoon` SET `present`='$present' WHERE `date`='$date' and `mId`='$studId'  and `term`='$term'");
      if (mysqli_query($conn, $query2)) {
        echo "<script> 
        window.location.href='update-attendance.php?confirm=successful'
        </script>";

      }else{
        echo "<script> 
        window.location.href='update-attendance.php?error=2'
        
        </script>";
        exit();
      }
      }
    
      }else{
        echo "<script> 
        window.location.href='update-attendance.php?error=3'
        
        </script>";
        exit();
      }
     }else{
        echo "<script> 
        window.location.href='update-attendance.php?error=6'
        
        </script>";
        exit();
      
     	
}
}

if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
    if ($errmsg == '1') {
      $msgerror ='Select only 1 box for each student';
    }
    elseif($errmsg =='2'){
        $msgerror ='A fatal error occured while trying to process your request! Kindly Contact the admin for details';
    }
    elseif($errmsg =='3'){
        $msgerror ='System internal error. Click <a href="main-dashboard.php"> Here </a> to get you back. ';
    }
    
    elseif($errmsg =='6'){
        $msgerror ='An unknown error occured. Click  <a href="main-dashboard.php"> Here </a> to complete your action. If this error persists, please contact the system Admin';
    }
  }
  if (isset($_GET['confirm']) && $_GET['confirm']=='successful') {
  $msgsucc="Attendance Updated Successfully";
}
  if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 1) {
      require '../controller/required.php'; 
    }else{
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
              if (isset($_SESSION["year"]) && isset($_SESSION["attDate"]) && isset($_SESSION["term"]) && ($_SESSION["studClass"]!='') && isset($_SESSION["Mor_After"]) && ($_SESSION["Mor_After"] !='')  ) 
               {
                  $myYear= $_SESSION['year'];
                  $vSession= $_SESSION['Mor_After'];
                  $attDate = $_SESSION['attDate'];
                  $classId = $_SESSION['studClass'];
                  $termId= $_SESSION['term'];

                  $term=mysqli_query($conn,"SELECT * from term WHERE id='$termId'");
                    if (mysqli_num_rows($term)>0 )
                    {  
                       while($row = mysqli_fetch_array($term))
                       {
                        $termName=$row['termName'];
                       }
                    }
                      else
                      {
                        echo "<script> alert ('An Error Occured!');
                               window.location.href='attendance-options.php';</script>
                              ";
                      }
         
                 $class=mysqli_query($conn,"SELECT * from class WHERE id='$classId'");
                    if (mysqli_num_rows($class)>0 ) 
                    {  
                       while($row = mysqli_fetch_array($class))
                       {
                        $classResult=$row['classCode'];
                       }
                    }
                 
                    ?>
       </div>
             <div  class="adv-table padTable">
              
              <table id="marks"  class="table table-bordered" id="hidden-table-info">
              
                <caption>
                <h3 style="text-align: center; text-decoration: underline; "><?php echo ($classResult."&nbsp;".$vSession. ' Roll Call Update For'."&nbsp;".$attDate) ;?></h3>
                </caption>
                <thead>
                  <tr>
                    <th>SN</th>
                    <th width="45%">Student Name</th>
                    <th width="25%">Admission Number</th>
                    <th width="20%">Present</th>

                    
                    
                  </tr>
                  <?php
                   if ($vSession == 'Morning') 
                  {
                    
                   
                  $sql=mysqli_query($conn, "SELECT st.id AS sid, st.surname AS sur, st.othernames AS other, st.gender AS sex, st.regNum AS reg, am.date AS da, am.term AS term, am.present AS pre, am.time AS ti
                        FROM 
                        students st
                        INNER JOIN attendance_morning am
                          ON st.id = am.studentId
                        
                        WHERE 
                        st.class='$classId' and am.term='$termId' and am.date = '$attDate' and am.studentId=st.id");
                      
                $sn=0;
                $curTime = date('h:i:s A');
                if (mysqli_num_rows($sql)>0) {
                  
                while ($getRes=mysqli_fetch_array($sql)) {
                    $studName = $getRes['sur'].' '. $getRes['other'];
                    $gender = $getRes['sex'];
                    $reg = $getRes['reg'];
                    $mpresent = $getRes['pre'];
                     $time = $getRes['ti'];
                    $term = $getRes['term'];
                    $sId=$getRes['sid'];
                  ?>
         <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="post" class="style-form" enctype="multipart/form-data">
               <input type="hidden"  value="<?php echo $vSession; ?>"  name="vSession">
               <input type="hidden"  value="<?php echo $classId ?>"  name="class_id">
           
              <tr>
              <td><?php echo ++$sn; ?></td>
              <input type="hidden"  value="<?php echo $myYear; ?>"  name="year[]">
              <input type="hidden"  value="<?php echo $attDate; ?>"  name="date[]">
            <input type="hidden"  value="<?php echo $termId; ?>"  name="term[]">
            <input type="hidden"  value="<?php echo $curTime; ?>"  name="time[]">
           
               <input type="hidden" value="<?php echo $sId; ?>"  name="studId[]">
               
              <td><?php echo $studName; ?></td>
              <td><?php echo $reg; ?></td>
                    <div class="form-group">
                      <td>
                  
                      <select class="form-control form-control-inline" name="pre[]">
                        <option value="
                        <?php 
                        if ($mpresent == 1) 
                        {
                          echo 1;
                        } 
                        else
                        {
                          echo 0;
                        } 
                        ?>"> <?php 
                        if ($mpresent == 1) 
                        {
                          echo 'Yes';
                        } 
                        else
                        {
                          echo 'No';
                        } 
                        ?></option>

                        <option value="
                        <?php 
                        if ($mpresent == 1) 
                        {
                          echo 0;
                        } 
                        else
                        {
                          echo 1;
                        } 
                        ?>"> <?php 
                        if ($mpresent == 1) 
                        {
                          echo 'No';
                        } 
                        else
                        {
                          echo 'Yes';
                        } 
                        ?></option>
                        
                      </select>
                     
                      </td>
                      
                      </div>

              </tr>
              <?php }
              
            }
          }
            elseif ($vSession == 'Afternoon') 
                  {
                    
                  
                 $sql=mysqli_query($conn, "SELECT st.id AS sid, st.surname AS sur, st.othernames AS other, st.gender AS sex, st.regNum AS reg, af.date AS da, af.term AS term, af.present AS pre, af.time AS ti
          FROM 
          attendance_morning am,
          students st
          INNER JOIN attendance_afternoon af
            ON st.id = af.mId
          WHERE 
          st.class='$classId' and af.term='$termId' and af.date = '$attDate' and af.morningId=am.id ");
                      
                $sn=0;
                $curTime = date('h:i:s A');
                if (mysqli_num_rows($sql)>0) {
                  
                while ($getRes=mysqli_fetch_array($sql)) {
                    $studName = $getRes['sur'].' '. $getRes['other'];
                    $gender = $getRes['sex'];
                    $reg = $getRes['reg'];
                    $mpresent = $getRes['pre'];
                     $time = $getRes['ti'];
                    $term = $getRes['term'];
                    $sId=$getRes['sid'];
                  ?>
         <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="post" class="style-form" enctype="multipart/form-data">
               <input type="hidden"  value="<?php echo $vSession; ?>"  name="vSession">
               <input type="hidden"  value="<?php echo $classId ?>"  name="class_id">
           
              <tr>
              <td><?php echo ++$sn; ?></td>
              <input type="hidden"  value="<?php echo $myYear; ?>"  name="year[]">
              <input type="hidden"  value="<?php echo $attDate; ?>"  name="date[]">
            <input type="hidden"  value="<?php echo $termId; ?>"  name="term[]">
            <input type="hidden"  value="<?php echo $curTime; ?>"  name="time[]">
           
               <input type="hidden" value="<?php echo $sId; ?>"  name="studId[]">
               
              <td><?php echo $studName; ?></td>
              <td><?php echo $reg; ?></td>
                    <div class="form-group">
                      <td>
                  
                      <select class="form-control form-control-inline" name="pr[]">
                        <option value="
                        <?php 
                        if ($mpresent == 1) 
                        {
                          echo 1;
                        } 
                        else
                        {
                          echo 0;
                        } 
                        ?>"> <?php 
                        if ($mpresent == 1) 
                        {
                          echo 'Yes';
                        } 
                        else
                        {
                          echo 'No';
                        } 
                        ?></option>

                        <option value="
                        <?php 
                        if ($mpresent == 1) 
                        {
                          echo 0;
                        } 
                        else
                        {
                          echo 1;
                        } 
                        ?>"> <?php 
                        if ($mpresent == 1) 
                        {
                          echo 'No';
                        } 
                        else
                        {
                          echo 'Yes';
                        } 
                        ?></option>
                        
                      </select>
                     
                      </td>
                      
                      </div>

              </tr>

              <?php }
              
            }else{
            echo "An error occured. That's all I know ";
          }
        }
      }
        else{
  echo 
  "<script> alert ('An Error Occured!');
  window.location.href='attendance-options.php';</script>

  ";
 }


               ?>
               <tr>
                 <td colspan="4">
                   
                 <div class="pull-left">
                    
                 <a class="btn btn-theme btn-sm pull-left" href="view-attendance.php"> View Roll Call <i class="fa fa-eye"></i></a>
                 </div> 
                  <div class="pull-right">
                    
                 <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="update-attendance.php#updateModal">Update Roll Call&nbsp;<i class="fa fa-edit"></i> </a><br><br>  
                 </div>  
                
                 </td>
               </tr>

          </tbody>
          </table>

  </tbody>
  </table>

        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm Roll Call Update!</h4>
              </div>
              <p style="font-size: 20px;">Are you sure you want to proceed?</p>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                <button class="btn btn-theme" type="submit" name="updateRollCall">Yes</button>
              </div>
            </div>
          </div>
      </div>
      
  </form>            
                <br>
                <br>
              </div>
              <!--/col-lg-12 mt -->
      </section>
    
    <footer class="">
      <div class="text-center">
                
      <?php footer();
      ?>
      </div>
    </footer>
    <!--footer end-->
  </section>
  <script src="../assets/lib/jquery/jquery.min.js"></script>

<script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../assets/lib/jquery.dcjqaccordion.2.7.js"></script>
<script src="../assets/lib/jquery.scrollTo.min.js"></script>
<script src="../assets/lib/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../assets/lib/jquery.sparkline.js"></script>
<script src="../assets/lib/common-scripts.js"></script>
<script type="text/javascript" src="../assets/lib/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="../assets/lib/gritter-conf.js"></script>
<!--common script for all pages-->
<script src="../assets/lib/jquery/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/lib/advanced-datatable/js/jquery.js"></script>
<script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../assets/lib/jquery.dcjqaccordion.2.7.js"></script>
     
</body>

</html>
<?php
mysqli_close($conn);
?>

</body>

</html>