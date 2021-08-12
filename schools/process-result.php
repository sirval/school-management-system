
<?php
//error_reporting(0);
session_start();
    require '../db/db_con.php';
    if (isset($_POST['updateRecord'])) 
    {
    	if (!empty($_POST['examYear']) && !empty($_POST['examTerm'])&& !empty($_POST['position']) && !empty($_POST['studId']) && !empty($_POST['studClass']) && is_array($_POST['examYear']) && is_array($_POST['examTerm']) && is_array($_POST['position']) && is_array($_POST['studId']) && is_array($_POST['studClass'])  && count($_POST['studId']) === count($_POST['examYear'])) {

     	$examYearArray= $_POST['examYear'];
     	$examTermArray= $_POST['examTerm'];
     	$studIdArray= $_POST['studId'];
     	$studClassArray= $_POST['studClass'];
     	
     	$totScoreArray= $_POST['gTotal'];
     	$totSubjectArray= $_POST['totSubject'];
     	$averageArray= $_POST['average'];
      $positionArray= $_POST['position'];
     	
     	for ($i=0; $i < count($studIdArray); $i++) { 
     	$f1= mysqli_real_escape_string($conn, $examYearArray[$i]);
     	$f2= mysqli_real_escape_string($conn, $examTermArray[$i]);
     	$f3= mysqli_real_escape_string($conn, $studIdArray[$i]);
     	//$f4= mysqli_real_escape_string($conn, $studClassArray[$i]);
     	$f5= mysqli_real_escape_string($conn, $totSubjectArray[$i]);
     	$f6= mysqli_real_escape_string($conn, $totScoreArray[$i]);
     	$f7= mysqli_real_escape_string($conn, $averageArray[$i]);
      $f8= mysqli_real_escape_string($conn, $positionArray[$i]);
     	
     	
     	$auth = mysqli_query($conn, "SELECT * FROM student_ranking WHERE  examYear='$f1' and examTerm='$f2' and studentId = '$f3' ");
     	if (mysqli_num_rows($auth) >0) {
     		echo "
     		<script>
     		var x = confirm('Result already exist. Update Anyway');
        if (x == true){
          window.location.href='update-result.php'
        } else
        {
          window.location.href='process-result.php'
        }
     		</script>";
     	}
     	$sql_query=mysqli_query($conn, "UPDATE `student_ranking` SET `gTotal`='$f6',`totsubject`='$f5',`average`='$f7', `position`='$f8' WHERE examYear='$f1' and examTerm='$f2' and studentId = '$f3' ");
     	if (mysqli_affected_rows($conn) >0) {
     		
     		echo "<script> 
     		var x = confirm('Result Updated Successfully. Upload Another?');
     		if (x == true){
     			window.location.href='result-processing.php'
     		} else
        {
     			window.location.href='update-result.php'
     		}
     		</script>";
     	}else
      {
     		echo "<script> alert 'An error occured while trying to upload result. If this error persists, please contact admin'; </script>";
     	}
     	}
     	
}else{
     		echo "<script> alert 'Fatal error. Please consider logging out and try again later'; </script>";
     	}
     }
     	

     if (isset($_POST['go'])) {
     	
     	if (!empty($_POST['examYear']) && !empty($_POST['examTerm'])  && !empty($_POST['position']) && !empty($_POST['studId']) && !empty($_POST['studClass']) && is_array($_POST['examYear']) && is_array($_POST['examTerm']) && is_array($_POST['studId']) && is_array($_POST['position']) && is_array($_POST['studClass'])  && count($_POST['studId']) === count($_POST['examYear'])) 
      {

      $examYearArray= $_POST['examYear'];
      $examTermArray= $_POST['examTerm'];
      $studIdArray= $_POST['studId'];
      $studClassArray= $_POST['studClass'];
      $totScoreArray= $_POST['gTotal'];
      $totSubjectArray= $_POST['totSubject'];
      $averageArray= $_POST['average'];
      $positionArray= $_POST['position'];
      
      for ($i=0; $i < count($studIdArray); $i++) 
      { 
      $f1= mysqli_real_escape_string($conn, $examYearArray[$i]);
      $f2= mysqli_real_escape_string($conn, $examTermArray[$i]);
      $f3= mysqli_real_escape_string($conn, $studIdArray[$i]);
      //$f4= mysqli_real_escape_string($conn, $studClassArray[$i]);
      $f5= mysqli_real_escape_string($conn, $totSubjectArray[$i]);
      $f6= mysqli_real_escape_string($conn, $totScoreArray[$i]);
      $f7= mysqli_real_escape_string($conn, $averageArray[$i]);
      $f8= mysqli_real_escape_string($conn, $positionArray[$i]);
      
      
      $auth = mysqli_query($conn, "SELECT * FROM student_ranking WHERE  examYear='$f1' and examTerm='$f2' and studentId = '$f3' ");
      if (mysqli_num_rows($auth) >0) 
      {
        echo "
        <script>var x = confirm('Total scores has already been generated for this term. If you think you never set this, please contact the admin');
        if (x == true){
          window.location.href='result-processing.php';
          
          } else{
          window.location.href='main-dashboard.php';
        }
        </script>";
     		
      }
      else
      {
        $query =mysqli_query($conn, "INSERT INTO `student_ranking`( `examYear`, `examTerm`, `studentId`, `gTotal`, `totsubject`, `average`, `position`) VALUES ('$f1', '$f2', '$f3', '$f6', '$f5', '$f7', '$f8')");
      if (mysqli_affected_rows($conn) >0) 
      {
        echo "<script> 
        
        var x = confirm('Result published. Upload Another');
        if (x == true){
          window.location.href='result-processing.php'
        } else{
          window.location.href='main-dashboard.php'
        }
        </script>";
      }
      else
      {
        echo "<script> alert 'An error occured while trying to upload result. If this error persists, please contact admin'; </script>";
        
      }
      }

     	}
     }
     else
     {
      echo "<script> alert ('A fatal error occured because some parameters where not set. Please try again later'); 
      window.location.href='process-result.php'
      </script>";

     }
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
if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 3 ) {
    echo"
     <script>alert('Access Denied for this User');
    window.location.href='logout.php';</script>";
   } 
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
   
    <section id="main-content">
      <section class="wrapper">
        <div class="col-md-12 mt">
          <div class="row content-panel">
            <div class="col-md-12">
              <div class="invoice-body">
                
                
               <?php
               if (isset($_SESSION["examYear"]) && isset($_SESSION["examTerm"]) && ($_SESSION["examYear"] !='') && ($_SESSION["examTerm"]) !='') {
	    	
        	$termId= $_SESSION['examTerm'];
        	$term=mysqli_query($conn,"SELECT * from term WHERE id='$termId'");
                    if (mysqli_num_rows($term)>0 ) {  
                       while($row = mysqli_fetch_array($term)){
                       	$examTermName=$row['termName'];
                       }
                      }
            $studClassId= $_SESSION['studClass'];//class id
        	$class=mysqli_query($conn,"SELECT * from class WHERE id='$studClassId'");
                    if (mysqli_num_rows($class)>0 ) {  
                       while($row = mysqli_fetch_array($class)){
                       	$classResult=$row['classCode'];
                       }
                      }
           

        echo '

             <div  class="adv-table padTable">
              <table id="marks"  class="table table-bordered" id="hidden-table-info">
              
                <caption>
                <h1 style="text-align: center;">RESULT SHEET</h1>
                <strong>Examination Year: </strong><label>'. $_SESSION['examYear'].'</label>
                <br><strong>Examination Term: </strong><label>'.$examTermName.'</label>
                <br><strong>Class: </strong><label>'.$classResult.'</label>
                </caption>
                <thead>
                  <tr>
                    <th>SN</th>
                    <th width="65%">Student Name</th>
                    <th width="10%">Grand Total</th>
                    <th width="10%">Average</th>
                    <th width="10%">position</th>
                   
                  </tr>
                </thead>

  <tbody>';
  ?>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="post" class="style-form" enctype="multipart/form-data">
  <?php
  $sn=0;
  ?>
  
  <?php
  $getClass=mysqli_query($conn, "SELECT * from students where class='$studClassId'");    
  while ($res=mysqli_fetch_array($getClass)) 
  {
  	$id=$res['id'];
  	$year = $_SESSION['examYear'];
  	$getSubject = mysqli_query($conn, "SELECT * FROM subjects WHERE classId='$studClassId'");
       if (mysqli_num_rows($getSubject)>0) 
       { 
          $totSubject = mysqli_num_rows($getClass);//get total number of subject to calculate average
          //while ($result=mysqli_fetch_array($sql2)) {
            
          $getStudPosition=mysqli_query($conn,"SELECT  sum(sr.total) AS gtot FROM  student_result sr WHERE   sr.studentId='$id' ORDER BY resId DESC");
            while ($r=mysqli_fetch_array($getStudPosition)) 
            {
                $students = array($gTotal=$r['gtot']);// convert to array
                $pos = $real_pos = 0;
                $prev_score = -1;
              foreach ($students as $exam_n => $score) 
                {
                  $real_pos += 1;
                  $pos = ($prev_score != $score) ? $real_pos: $pos;
                  $prev_score = $score;
                }
                $average = $score/$totSubject; //getting students average
            }
            
        }

    echo  '
    <tr>
     
      <td>
        <input type="text" class="form-control form-control-inline input-medium position" id="position" name="position[]" value="'.$pos.'"  readonly="" >
      </td>        
        </div>
      </div>
    </tr>
    
    ' ;
  }
 
  ?>
                
        	<div class="form-group"></div>

        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirmation!</h4>
              </div>
              <p style="font-size: 20px;">This action is not reversible. Once generated, no other score could be added. Proceed Anyway?</p>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                <button class="btn btn-theme" type="submit" name="go">Yes</button>
              </div>
            </div>
          </div>
      </div>
      <?php
   
  echo '
  <tr>
  <td colspan="7">
  <div class="form-group">
       
          <a  class="btn btn-primary btn-sm " href="result-processing.php">New Result&nbsp;<i class="fa fa-plus"></i> </a> 
          
            <a  data-toggle="modal" class="btn btn-theme btn-sm pull-right" href="result-upload.php#myModal">Save Generated Grand Total &nbsp;<i class="fa fa-save"></i> </a> 
            <button type="submit" name="updateRecord"  class="btn btn-warning  btn-sm ">Update&nbsp;<i class="fa fa-edit"></i>
            </button> 
        
      
 </div>  
  </td>
  </tr>

  </tbody>
  </table>
 
  ';
  ?>
  </form>
  <?php
 }else{
 	echo 
 	"<script> alert ('Class Not Found!');
 	</script>

 	";
 }
?>
                
                <br>
                <br>
              </div>
              <!--/col-lg-12 mt -->
      </section>
      <!-- /wrapper -->
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
    <!--footer start-->
    <footer class="site-footer">
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

  <script type="text/javascript">
    
/*$('table input').on('input', function() {
  var $tr = $(this).closest('tr');
  var tot = 0;
  $('input:not(:last)',$tr).each(function() {
    tot += Number($(this).val()) || 0;
  });
  $('td:last input', $tr).val(tot);
}).trigger('input');


  $(document).on("change", ".score", function() {
    var sum = 0;
    var parent = $(this).closest('tr');
    parent.find($(".score")).each(function() {
      sum += +$(this).val();
    });
    $(".totScore").val(sum);
    if ((".totScore").val() > 89) {
       $(".grade").val("Excellent");
    }
  });
  */

</script>
   
</body>

</html>
<?php
mysqli_close($conn);
?>

</body>

</html>