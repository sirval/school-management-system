<?php
error_reporting(0);
session_start();
if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 1) {
      require '../controller/required.php'; 
    }else{
      require '../controller/users_required.php'; 
    }
   if (!isset($_SESSION['userId']) && !isset($_SESSION['user'])) {
    header('location:index.php');
}
$userId=$_SESSION['userId'];
$userSchool=$_SESSION['schoolId'];
siteTitle(mysite, ' || ', ' Admin'.' || ' . $_SESSION['user']);
   meta();
    pageHeader();
   sideBar();
   
?>
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
            .section_header{
              font-size: 20px;
              font-weight: bolder;
              text-decoration: underline;
            }
            table, th, td{
              border: 1px solid black;
            }
          </style>
    <!--main content start-->
    <section id="main-content">
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
        <div class="alert alert-info alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                              </button>
                   Consider Refreshing this page if the logo does not display.
                  </div>
              <div class="pull-right">
            <button class="btn btn-sm btn-info" onclick="printInvoice()">Print Result</button>
           
           </div>
              <div id="result-Body" class="invoice-body">
           <?php 
           $school=mysqli_query($conn, "SELECT * FROM `schools` WHERE id='$userSchool'");
           while ($studSchool=mysqli_fetch_array($school)) {
            $logo=$studSchool['logo'];
            $schoolName=$studSchool['name'];
            $schoolMotto=$studSchool['motto'];
            $schoolAddress=$studSchool['address'];
           }
           $exTerm  = $_SESSION['examTerm'];
           $academicTerm=mysqli_query($conn, "SELECT * FROM `term` WHERE id='$exTerm'");
           while ($t=mysqli_fetch_array($academicTerm)) {
            $acadaTerm=$t['termName'];
           }
           ?>
          <div class="school_header">
            <img style="display: block; margin-left: auto; margin-right: auto; width: 120px; height: 120px;" src="<?php echo 'logo/'.$logo; ?>" class="img-circle" alt="School Logo">
                  <h1 class="center color"><?php echo $schoolName; ?></h1>
                  <p class="center"><i><strong>Motto:</strong><?php echo $schoolMotto; ?></i></p>
                  <h4 class="center"><b><?php echo $schoolAddress; ?></b></h4>
                  <h1 class="center">RESULT SHEET</h1>
                </div><br>
                <?php 

                if (isset($_GET['StudentId']) && $_GET['StudentId']!='') {
      $studPin=$_GET['StudentId'];
      $url_decode = base64_decode($studPin);

                $sql=mysqli_query($conn,"SELECT p.pin AS pp, p.studentId AS ps, s.id AS sid, s.surname AS sur, s.othernames AS other, s.gender AS sex, s.class AS ac, s.school AS ssc, s.regNum AS reg, c.id AS cid, c.classCode AS cco, c.classCode AS cn
                    from students s
                    INNER JOIN class c
                    ON s.class=c.id 
                    INNER JOIN pin p
                    ON p.studentId = s.regNum
                    WHERE s.school='$userSchool' and s.regNum=p.studentId and p.pin='$url_decode'");
                      
                        while ($res=mysqli_fetch_assoc($sql)) {
                           
                           $class=$res['cn'];
                           $cId=$res['cid'];
                           $reg=$res['reg'];
                           $sId=$row['sid'];
                           $studentName=$res['sur'].' '.$res['other'];
                           $gender=$res['sex'];
                           $sn=0;
                           

                }
                $year = $_SESSION['examYear'];
                  $term = $_SESSION['examTerm'];
                  $regNum = $_SESSION['reg'];

                

                ?>
                
               <section id="no-more-tables">
                <table class="table table-bordered table-striped table-condensed cf">
                  <thead class="cf">
                    <caption><label>STUDENT NAME: </label><b> <?php echo $studentName; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>GENDER: </label> <b><?php echo $gender; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>ADMISSION NUMBER: </label><b> <?php echo $reg; ?> </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>CLASS: </label><b> <?php echo $class; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>ACADEMIC YEAR: </label> <b><?php echo $_SESSION['examYear'];; ?></b>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>TERM: </label> <b><?php echo $acadaTerm ;?></b></caption>
                    <tr>
                      <th>SN</th>
                      <th>Subject</th>
                      <th class="numeric">CAT</th>
                      <th class="numeric">Exam</th>
                      <th class="numeric">Total</th>
                      <th class="numeric">Grade</th>
                      <th class="numeric">Remark</th>
                      
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
                   
                         
                  echo '
                  
                    <tr>
                      <td data-title="Code">'. $sn++.'</td>
                      <td data-title="Company">'.$subject.'</td>
                      <td class="numeric" data-title="Price">'.$cat.'</td>
                      <td class="numeric" data-title="Change">'.$exam.'</td>
                      <td class="numeric" data-title="Change %">'.$total.'</td>
                      <td class="numeric" data-title="Open">'.$grade.'</td>
                      <td class="numeric" data-title="High">'.$remark.'</td>
                      
                    </tr>';}
                ?>
                    
                  </tbody>
                </table>
                <table>
                  <tr><td></td></tr>
                </table>
                <table class="table table-bordered table-striped table-condensed cf">
                  <thead class="cf">
                    <caption>
                      <?php 
                      //$cal = mysqli_query($conn, "SELECT sum(total), ")

                      ?>
                      <label>GRAND TOTAL: </label><b> <?php echo $gTotal; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>AVERAGE: </label> <b><?php echo $average; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>POSITION: </label><b> <?php echo $reg; ?> </b>
                    </caption>
                  </thead>
              </table>
              </section>
               <p style="font-size: 25px; text-align: center; font-weight: bolder; font-style: italic;">Signed</p>
                <p style="text-align: center;">Management</p>
              </div><?php }else{
                echo "string:" . mysqli_error($conn);
              }}?>  
         
     </div>
 </div>
</div>
</div>
</div>
</section><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  
    <!-- /MAIN CONTENT -->
   <?php footer();?>
  </section>
  <?php mainJs();
    ?>
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
     
  </script>

</body>
<?php
mysqli_close($conn);
?>
</html>