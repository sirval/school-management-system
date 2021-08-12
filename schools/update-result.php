
<?php
error_reporting(0);
session_start();
    require '../db/db_con.php';
     if (isset($_POST['saveResult'])) {
     	
     	if (!empty($_POST['examYear']) && !empty($_POST['resultId']) && !empty($_POST['examTerm']) && !empty($_POST['studId']) && !empty($_POST['studClass']) && !empty($_POST['subject']) && is_array($_POST['examYear']) && is_array($_POST['examTerm']) && is_array($_POST['studId']) && is_array($_POST['studClass']) && is_array($_POST['subject']) && count($_POST['studId']) === count($_POST['examYear'])) {

     	
     	$studIdArray= $_POST['resultId'];
     	
     	$catArray= $_POST['cat'];
     	$examScoreArray= $_POST['examScore'];
     	$totScoreArray= $_POST['totScore'];
     	$gradeArray= $_POST['grade'];
     	$remarkArray= $_POST['remark'];
     	$positionArray= $_POST['position'];
     	
     	for ($i=0; $i < count($studIdArray); $i++) { 
     	
     	$f3= mysqli_real_escape_string($conn, $studIdArray[$i]);
     	//$f4= mysqli_real_escape_string($conn, $studClassArray[$i]);
     	//$f5= mysqli_real_escape_string($conn, $subjectArray[$i]);
     	$f6= mysqli_real_escape_string($conn, $catArray[$i]);
     	$f7= mysqli_real_escape_string($conn, $examScoreArray[$i]);
     	$f8= mysqli_real_escape_string($conn, $totScoreArray[$i]);
     	$f10= mysqli_real_escape_string($conn, $gradeArray[$i]);
     	$f11= mysqli_real_escape_string($conn, $remarkArray[$i]);
     	$f12= mysqli_real_escape_string($conn, $positionArray[$i]);
     	
     	
     	$query =mysqli_query($conn, "UPDATE `student_result` SET `cat`='$f6',`exam`='$f7',`total`='$f8',`grade`='$f10',`remark`='$f11', `position`='$f12' WHERE resId='$f3'");
     	if (mysqli_affected_rows($conn) >0) {
     		
     		//$url_encode =md5($_SESSION['subject']);
     		echo "<script> 
     		var x = confirm('Result Updated Successfully. Upload Another?');
     		if (x == true){
     			window.location.href='result-processing.php'
     		} else{
     			window.location.href='main-dashboard.php'
     		}
     		</script>";
     	}else{
     		echo "<script> alert 'An error occured while trying to upload result. If this error persists, please contact admin'; </script>";
     	}
     	}
     	}else{
     		echo "<script> alert 'Fatal error. Please consider logging out and try again later'; </script>";
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
                
                
               <?php
               if (isset($_SESSION["studClass"]) &&  ($_SESSION["studClass"] !='')) {
	    	$classId=($_SESSION["studClass"]);
	    	
        	$termId= $_SESSION['examTerm'];
        	$term=mysqli_query($conn,"SELECT * from term WHERE id='$termId'");
                    if (mysqli_num_rows($term)>0 ) {  
                       while($row = mysqli_fetch_array($term)){
                       	$examTermName=$row['termName'];
                       }
                      }
            $studClassId= $_SESSION['studClass'];
        	$class=mysqli_query($conn,"SELECT * from class WHERE id='$studClassId'");
                    if (mysqli_num_rows($class)>0 ) {  
                       while($row = mysqli_fetch_array($class)){
                       	$classResult=$row['classCode'];
                       }
                      }
            $entrySubject= $_SESSION['subject'];
        	$enSubject=mysqli_query($conn,"SELECT * from subjects WHERE id='$entrySubject'");
                    if (mysqli_num_rows($enSubject)>0 ) {  
                       while($row = mysqli_fetch_array($enSubject)){
                       	$subjects=$row['subjectname'];
                       }
                      } 
        $sql=mysqli_query($conn, "SELECT * from students where class='$classId'");
        echo '

             <div  class="adv-table padTable">
              <table id="marks"  class="table table-bordered" id="hidden-table-info">
              
                <caption>
                <h1 style="text-align: center;">RESULT SHEET</h1>
                <strong>Examination Year: </strong><label>'. $_SESSION['examYear'].'</label>
                <br><strong>Examination Term: </strong><label>'.$examTermName.'</label>
                <br><strong>Class: </strong><label>'.$classResult.'</label>
                <br><strong>Subject: </strong><label>'.$subjects.'</label>
                </caption>
                <thead>
                  <tr>
                    <th>SN</th>
                    <th width="40%">Student Name</th>
                    <th width="10%">CAT</th>
                    <th width="10%">Exam Score</th>
                    <th width="10%">Total Score</th>
                    <th width="10%">Grade</th>
                    <th width="20%">Remark</th>
                    
                  </tr>
                </thead>

  <tbody>';
  ?>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="post" class="style-form" enctype="multipart/form-data">
  <?php
  $sn=0;
  ?>
  
  <?php
  while ($res=mysqli_fetch_array($sql)) {
  	$year = $_SESSION['examYear'];
                  $term = $_SESSION['examTerm'];
                  //$regNum = $_SESSION['reg'];
                  $sql=mysqli_query($conn,"SELECT sr.resId AS srId, sr.cat AS cat, sr.exam AS ex, sr.total AS tot, sr.grade AS gr, sr.remark AS rem, s.id AS si, s.surname AS fname, s.othernames AS lname, sub.subjectname AS sname
                    from students s, student_result sr, subjects sub
                    
                    WHERE   sr.examYear='$year' and sr.examTerm='$term'  and sub.id='$entrySubject' and sr.subjectId='$entrySubject' and s.id=sr.studentId");
                  
                      if (mysqli_num_rows($sql)>0) { 
                        while ($row=mysqli_fetch_array($sql)) {
                        	$id=$row['srId'];
                        	$fname=$row['fname'];
                           $lname=$row['lname'];
                           $cat=$row['cat'];
                           $exam=$row['ex'];
                           $total=$row['tot'];
                           $grade=$row['gr'];
                           $remark=$row['rem'];
                           $subject= $row['sname'];
                       
    echo  '
    <tr>
    <td>'.++$sn.'
    <input type="hidden"  value="'.$id.'"  name="resultId[]">
     <input type="hidden"  class="form-control form-control-inline input-medium position" id="position" name="position[]"  readonly="">
    <input type="hidden"  value="'.$_SESSION['examYear'].'"  name="examYear[]">
  <input type="hidden"  value="'. $_SESSION['examTerm'].'"  name="examTerm[]">
  <input type="hidden"  value="'. $_SESSION['studClass'].'"  name="studClass[]">
  <input type="hidden"  value="'.$_SESSION['subject'].'"  name="subject[]">
     <input type="hidden" value="'.$res['id'].'" hidden="" name="studId[]"></td>
    <td><input type="text" class="form-control form-control-inline input-medium " value="'.$fname.'&nbsp;&nbsp;&nbsp;'. $lname.'" readonly=""></td>
    <td> 
          <div class="form-group">
        
            <input type="number" class="form-control form-control-inline input-medium cat" id="cat" name="cat[]" value="'.$cat.'" min="0" max="40" onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57">
            </td>
            
            <td>
            <input type="number" class="form-control form-control-inline input-medium examScore" id="examScore" name="examScore[]" value="'.$exam.'" min="0" max="60"  onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57">
            </td>
            
             <td>
            <input type="text" class="form-control form-control-inline input-medium totScore" id="totScore" name="totScore[]" value="'.$total.'"  readonly="" min="0" max="100">
            </td>
            <td>
            <input type="text" class="form-control form-control-inline input-medium grade" id="grade" name="grade[]" value="'.$grade.'"  readonly="">
            </td>
            <td>
            <input type="text" class="form-control form-control-inline input-medium remark" id="remark" name="remark[]" value="'.$remark.'" readonly="">
           
            </td>
                 
                  </div>
              </div>

    
    </tr>
    
    ' ;
  }
}}
 
  ?>
  
                <div class="form-group"></div>

        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm Result Saving!</h4>
              </div>
              <p style="font-size: 20px;">Are you sure you want to save this result?</p>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                <button class="btn btn-theme" type="submit" name="saveResult">Yes</button>
              </div>
            </div>
          </div>
      </div>
  </form>
  <?php
   
  echo '
  <tr>
  <td colspan="7">
  <div class="form-group">
                  <div class="col-md-12">
                    <a  class="btn btn-primary btn-sm pull-left" href="result-processing.php">New Result&nbsp;<i class="fa fa-plus"></i> </a> 
                 <a  data-toggle="modal" class="btn btn-theme btn-sm pull-right" href="result-upload.php#myModal">Update Result&nbsp;<i class="fa fa-edit"></i> </a><br><br>  
                 </div>                
                </div>
  </td>
  </tr>
  </tbody>
  </table>
 
  ';
 }else{
 	echo 
 	"<script> alert ('Class Not Found!');
 	window.location.href='result-processing.php';</script>

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
  .js"></script>
  <!--script for this page-->
  <script type="text/javascript">
    function loadSubject() {
    var xmlhttp= new XMLHttpRequest();
    xmlhttp.open("GET", "class-request.php?classes="+document.getElementById("studClasses").value, false);
    xmlhttp.send(null);
    document.getElementById("classSubject").innerHTML=xmlhttp.responseText;
    
  }

  function loadResultSheet() {
    var xmlhttp= new XMLHttpRequest();
    xmlhttp.open("GET", "student-request.php?studClass="+document.getElementById("studClasses").value, false);
    xmlhttp.send(null);
    //document.getElementById("classSubject").innerHTML=xmlhttp.responseText;
    document.getElementById("studId").innerHTML=xmlhttp.responseText;
    //document.getElementById("studName").innerHTML=xmlhttp.responseText;
    var x=document.getElementById("studContainer");
    
  }
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


$('#marks').on('input', '.examScore, .cat',   function() {
      //var examScore = (".examScore").val();
        var $mark = $(this)
          
              // Find the tr this control is in and the corresponding total field
                $row = $mark.closest('tr')
                var cat = $row.find(".cat").val() != "" ? $row.find('.cat').val() : 0;
                var examScore = $row.find(".examScore").val() != "" ? $row.find('.examScore').val() : 0;
               
                  var $studTotalScore = $row.find('.totScore')

                    studTotalScore = parseInt(cat) + parseInt(examScore);
                      $studTotalScore.val(studTotalScore).attr('readonly', true);
                          var $studentgrade = $row.find('.grade')
                        var $remarks = $row.find('.remark')
                      var $position = $row.find('.position')
                       if ((examScore > 60)){
                  alert('Student EXAM score cannot be greater than 60');
                  
                  examScore = 0;
                  
                }
                 if ((cat > 40)) {
                  alert('Student CA score cannot be greater than 40');
                  
                }
                 
                    if (studTotalScore >= 75 && studTotalScore <= 100) {
                  calculatedgrade = "A1";
                remark = "Excellent";
                    }else if (studTotalScore >= 70 && studTotalScore <= 74) {
                  calculatedgrade = "B2";
                remark = "Very Good";
              }
              else if (studTotalScore >= 65 && studTotalScore <= 69) {
                  calculatedgrade = "B3";
                remark = "Good";
              }
              else if (studTotalScore >= 60 && studTotalScore <= 64) {
                  calculatedgrade = "C4";
                remark = "Credit";
              }
              else if (studTotalScore >= 55 && studTotalScore <= 59) {
                  calculatedgrade = "C5";
                remark = "Credit";
              }
              else if (studTotalScore >= 50 && studTotalScore <= 54) {
                  calculatedgrade = "C6";
                remark = "Credit";
              }
              else if (studTotalScore >= 45 && studTotalScore <= 49) {
                  calculatedgrade = "D7";
                remark = "Pass";
              }
              else if (studTotalScore >= 40 && studTotalScore <= 44) {
                  calculatedgrade = "E8";
                remark = "Pass";
              }
              else  {
                  calculatedgrade = "F9";
                remark = "Fail";
              }
              
              $studentgrade.val(calculatedgrade).attr('readonly', true);
            $remarks.val(remark).attr('readonly', true);
});

$(function() {
  $('#totScore').input(function() {
    var $max= parseInt($(this).attr('max'));
  var $min= parseInt($(this).attr('min'));
  if ($(this).val() > $max) {
    $(this).val(0);
  }
  else if ($(this).val() < $min) {
    $(this).val(0);
  }
  });
});

$(function() {
  $('#totScore').change(function() {
    var $max= parseInt($(this).attr('max'));
  var $min= parseInt($(this).attr('min'));
  if ($(this).val() > $max) {
    $(this).val(0);
  }
  else if ($(this).val() < $min) {
    $(this).val(0);
  }
  });
});
</script>
   
</body>

</html>
<?php
mysqli_close($conn);
?>

</body>

</html>