 <?php
 session_start();
require '../db/db_con.php';
if (isset($_GET['StudentId']) && $_GET['StudentId']!='') {
      $studPin=$_GET['StudentId'];
      $url_decode = base64_decode($studPin);
    }
    else
    {
 echo "<script> alert ('A fatal error occured due to system modification. Please try again later');
 window.location.href='result-checker.php';
  </script>";
    }
        
          if (!isset($_SESSION['examYear']) && !isset($_SESSION['examYear']) && isset($_SESSION['reg']) ) 
          {
            echo 
            "
            <script> 
                 alert ('Sorry this page encountered an error. Click okay to relogin');
                
                  window.location.href='index.php';
               
            </script>
            ";
          }
                  $year = $_SESSION['examYear'];
                  $term = $_SESSION['examTerm'];
                  $regNum = $_SESSION['reg'];
                  //$exTerm  = $_SESSION['examTerm'];    

    $getStudSchool=mysqli_query($conn, "SELECT pin.studentId, students.school FROM pin, students WHERE pin.pin='$url_decode'");
           if (mysqli_num_rows($getStudSchool)>0) {
             
           while ($studSch=mysqli_fetch_array($getStudSchool)) {
            $schoolId=$studSch['school'];}
            
           } else
    {
 echo "<script> alert ('A fatal error occured due to system modification. Please try again later');
 
  </script>";
    }
     
           
           $school=mysqli_query($conn, "SELECT * FROM `schools` WHERE id='$schoolId'");
           if (mysqli_num_rows($school)>0) {
             
           while ($studSchool=mysqli_fetch_array($school)) {
            $logo=$studSchool['logo'];
            $schoolName=$studSchool['name'];
            $schoolMotto=$studSchool['motto'];
            $schoolAddress=$studSchool['address'];
           }
         }else{
          echo "<script> alert ('We could not find your school. If this error persists, please contact your school'); </script>";
         }
         
     
           
           $academicTerm=mysqli_query($conn, "SELECT * FROM `term` WHERE id='$term'");
           while ($t=mysqli_fetch_array($academicTerm)) {
            $acadaTerm=$t['termName'];
           }
           
                

                $sql=mysqli_query($conn,"SELECT p.pin AS pp, p.studentId AS ps, s.id AS sid, s.surname AS sur, s.othernames AS other, s.gender AS sex, s.class AS ac, s.school AS ssc, s.regNum AS reg, c.id AS cid, c.classCode AS cco, c.classCode AS cn
                    from students s
                    INNER JOIN class c
                    ON s.class=c.id 
                    INNER JOIN pin p
                    ON p.studentId = s.id
                    WHERE s.school='$schoolId' and s.id=p.studentId and p.pin='$url_decode'");
                      
                        while ($res=mysqli_fetch_assoc($sql)) {
                           
                           $class=$res['cn'];
                           $cId=$res['cid'];
                           $reg=$res['reg'];
                           $sId=$res['sid'];
                           $studentName=$res['sur'].' '.$res['other'];
                           $gender=$res['sex'];
                           $sn=0;
                           

                }
                

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
  <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-fileupload/bootstrap-fileupload.css" />
  <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-datepicker/css/datepicker.css" />
  <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-timepicker/compiled/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-datetimepicker/datertimepicker.css" />
  <script src="../assets/lib/chart-master/Chart.js"></script>
  <title><?php echo "SmartSchool || Result || ".$studentName; ?></title>
  </head>
</html>
<link href="../assets/lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
  <link href="../assets/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/style-responsive.css" rel="stylesheet">
  
    <style type="text/css">
     				.center{
     					text-align: center;
     				}
     				.color{
     					color: #C9302C;
     				}
     				.school_header{
     					line-height: 0;
     				}
            .schoolLogo{
              float: left;
            }
            .clearfix{
              overflow: auto;
            }
     				.section_header{
     					font-size: 20px;
     					font-weight: bolder;
     					text-decoration: underline;
     				}
     				
     			</style>
          <body>
  <section id="container">
    <header class="header black-bg">
      
      <!--logo start-->
      <a href="http://localhost/smartschool.com" class="logo"><b><span>Smart</span>School</b></a>
      <!--logo end-->
     <div class="top-menu">
        <ul class="nav pull-right top-menu">
          <li><a class="logout" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </header>
    <!--header end-->
    <!--main content start-->
    
    <section>
      <section class="wrapper">
        <div class="row mt">
          <div class="col-md-12">
            <div class="content-panel">
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
           
         ?>
        </div> 
        
            	
              <div id="result-Body" class="invoice-body">
          
                <style type="text/css">
                .tborder{
                  border: 1px solid black;
                }
                 .resultTable{
                  border: 1px solid black;
                  width: 100%;
                  padding-left: 20px
                  display: block; 
                  margin-left: auto; 
                  margin-right: auto;
                }
                
                .headerTable{
                 
                  padding-left: 20px
                  display: block; 
                  margin-left: auto; 
                  margin-right: auto;
                  overflow-x: hidden;
                  
                }
                
                </style>
               <section id="no-more-tables">
                <div class="">
                <table class="headerTable ">
                  <tr>
                    <td>
                      <img style="display: block; margin-left: auto; margin-right: auto; width: 120px; height: 120px;"  src="<?php echo '../schools/logo/'.$logo; ?>" class="schoolLogo center" alt="School Logo">
                    </td>
                    <td>
                      <h1 class="center color"><?php echo $schoolName; ?></h1>
                  <p class="center"><i><strong>Motto:</strong><?php echo $schoolMotto; ?></i></p>
                  <h4 class="center"><b><?php echo $schoolAddress; ?></b></h4>
                  
                    </td>
                  </tr>
                </table>
              </div>
                <table  class="table table-striped table-condensed cf center resultTable">
                  <thead class="cf">
                    <caption>
              
            
                  <h2 class="center">RESULT SHEET</h2>
                </div>
                <p>
                    <label><b>STUDENT NAME:</b> </label> <?php echo $studentName; ?>
                      <label><b>  GENDER: </b></label> <?php echo $gender; ?>
                      <label><b>  ADMISSION NUMBER: </b></label> <?php echo $reg; ?> 
                      <label><b>  CLASS: </label></b> <?php echo $class; ?></b>
                      <label><b>  ACADEMIC YEAR: </label> </b><?php echo $_SESSION['examYear'];; ?></b>
                      <label><b>  TERM: </label> </b><?php echo $acadaTerm ;?></b>
                    </p>
                    </caption>
                    <tr>
                      <th class="tborder">SN</th>
                      <th class="tborder">Subject</th>
                      <th class="numeric tborder">CAT</th>
                      <th class="numeric tborder">Exam</th>
                      <th class="numeric tborder">Total</th>
                      <th class="numeric tborder">Grade</th>
                      <th class="numeric tborder">Remark</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  
                  $sql=mysqli_query($conn,"SELECT  sr.examYear AS ey, sr.examTerm AS et, sr.studentId AS st, sr.classId AS cl, sr.subjectId AS su, sr.cat AS cat, sr.exam AS ex, sr.total AS tot,  sr.grade AS gr, sr.remark AS rem, s.id AS si, s.regNum AS reg, sub.subjectname AS sname, str.gTotal AS grt, str.totSubject AS tots, str.average AS ave
                    from students s
                    INNER JOIN student_result sr
                    	ON s.id = sr.studentId
                    INNER JOIN subjects sub
                    	ON sub.classId = sr.classId
                    INNER JOIN student_ranking str
                    	ON sr.studentId=str.studentId
                    WHERE  sr.studentId=s.id and sr.examYear='$year' and sr.examTerm='$term' and s.regNum='$regNum' and sub.id=sr.subjectId and str.examTerm=sr.examTerm and str.examYear=sr.examYear");
                  $sn=1;
                      if (mysqli_num_rows($sql)>0) { 
                        while ($row=mysqli_fetch_array($sql)) {
                        	$id=$row['si'];
                        	$subjectId= $row['su'];
                           $classId = $row['cl'];
                           $cat=$row['cat'];
                           $exam=$row['ex'];
                           $total=$row['tot'];
                           $grade=$row['gr'];
                           $remark=$row['rem'];
                           $subject= $row['sname'];
                           $totSubject=$row['tots'];
                           $gTotal=$row['grt'];
                           $average=$row['ave'];
                   
                         
               		?>
                  
                    <tr>
                      <td class="tborder" data-title="SN"><?php echo $sn++; ?></td>
                      <td class="tborder" data-title="Subject"><?php echo $subject; ?></td>
                      <td class="numeric tborder" data-title="CAT Score"><?php echo $cat ?></td>
                      <td class="numeric tborder" data-title="Exam Score"><?php echo $exam ?></td>
                      <td class="numeric tborder" data-title="Total Score"><?php if ($total < 40){
                        echo '<p style="color: red;">'. $total .'</p>';
                      }else{
                        echo $total;
                      } ?></td>
                      <td class="numeric tborder" data-title="Grade"><?php if ($total < 40){
                        echo '<p style="color: red;">'. $grade .'</p>';
                      }else{
                        echo $grade;
                      } ?></td>
                      <td class="numeric tborder" data-title="Remark"><?php if ($total < 40){
                        echo '<p style="color: red;">'. $remark .'</p>';
                      }else{
                        echo $remark;
                      } ?></td>
                      
                    </tr>
                    <?php
                  }
                ?>
                <tr >
                  <td class="tborder" colspan="2"><b>Grand Total:</b></td>
                  <td class="tborder" colspan="2"><b><?php echo $gTotal; ?></b></td>
               
                  <td class="tborder" colspan="2"><b>Average:</b></td>
                  <td class="tborder" colspan="1"><b><?php echo $average.' %'; ?></b></td>
                </tr>
                <tr>
                  <td class="tborder" colspan="7">
                    <br><br><br><br>
                    <p style="font-size: 25px; text-align: center; font-weight: bolder; font-style: italic;">Signed</p>
                <img style="display: block; margin-left: auto; margin-right: auto; width: 120px; height: 120px;" src="<?php echo '../schools/logo/authentic-certificate.jpg'; ?>" class="img-circle" alt="School Logo">
              
              
                  </td>
                </tr>
                
                  <?php
          }else
          {
            echo "<tr>
                  <td class='tborder' colspan='7'>
                  <h4>No Result Found for this student! That is all we know. Kindly contact your school if this error persists</h4>
                  </td>
                </tr>";
          }
          ?>  
                  
                  </tbody>
                </table>
               
              </section>
            </div>
               <div style="padding-right: 50px;" class="pull-right">
            <button class="btn btn-sm btn-info" onclick="printInvoice()">Print</button>
           
           </div>
           <div style="padding-right: 50px;" class="pull-right">
            <a href="student-dashboard.php" class="btn btn-sm btn-danger" ><i class="fa fa-arrow-left"></i> Back</a>
           
           </div>
           <br><br><br><br><br><br><br><br>

         
     </div>

 </div>
</div>
</div>
</div>

</section>
  
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
          &copy; Copyrights <?php echo "2016-". date('Y'); ?> <strong>SmartSchool</strong>. All Rights Reserved
        </p>
        <div class="credits">
         
          <label style="color: #fff"> Powered by </label>&nbsp;<a href="http://wa.me/2348082646718" target="_blank">Outsmart Ideas</a>
        </div>
        
      </div>
    </footer>
  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="../assets/lib/jquery/jquery.min.js"></script>
  <script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="../assets/lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="../assets/lib/jquery.scrollTo.min.js"></script>
  <script src="../assets/lib/jquery.nicescroll.js" type="text/javascript"></script>
  <!--common script for all pages-->
  <script src="../assets/lib/common-scripts.js"></script>
  <!--script for this page-->
  <script type="text/javascript">
    function printInvoice(){
        var content=document.getElementById('result-Body').innerHTML;
        var printPrev=window.open('', '', 'height=1000, width=1000');
        printPrev.document.write('<html>');
        printPrev.document.write('<body>');
        printPrev.document.write(content);
        printPrev.document.write('</body></html>');
         printPrev.print();
        printPrev.close();

      }
      function info() {
      	alert('Print the Admission slip, then proceed to make payment. After the payment, bring the evidence of payment for upload. Remember: Your System Identification Number (SIN) will be required to complete payment verification and registration in the system. Thanks!');
      }
  </script>

</body>
<?php
mysqli_close($conn);
?>
</html>