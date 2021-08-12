  <?php
  error_reporting(0);
  session_start();
    require '../db/db_con.php';
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
siteTitle(mysite, ' || ', '  Admin'.' || ' . $_SESSION['user']);
   meta();
    pageHeader();
   sideBar();
    
   ?>
     <link href="../assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="../assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="../assets/lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
  <link href="../assets/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
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
            .section_header{
              font-size: 20px;
              font-weight: bolder;
              text-decoration: underline;
            }
            table, th, td{
              border: 1px solid black;
            }
          </style>
   <section id="main-content">
      <section class="wrapper">
       
        <div class="row mb">
          
          <!-- page start-->
          <div class="content-panel">
           
          <?php 
          if (isset($_SESSION["examYear"]) && isset($_SESSION["examTerm"]) && ($_SESSION["examYear"]!='') && ($_SESSION["examTerm"] !='') ) {
                //$subject = $_SESSION['subject'];
                  $studClass = $_SESSION['studClass'];
                   
                $year = $_SESSION['examYear'];
                  $term = $_SESSION['examTerm'];
          ?>
          <div class="alert alert-info alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                              </button>
                   Consider Refreshing this page if the logo does not display.
                  </div>
            
              <div class="pull-right">
            <button class="btn btn-sm btn-info" onclick="printInvoice()">Print Result</button>
           
           </div>
              <div id="result" class="invoice-body">
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
               
              <div  class="adv-table ">
              <table cellpadding="0" cellspacing="0" border="0" class="auto-index display table table-bordered" id="hidden-table-info">
            <style type="text/css">
              th{
                border: 2px solid black;
              }
              tr{
                border: 1px solid black;
              }
              td{
                border: 1px solid black;
              }
            </style>
            
                <thead>

                  <tr>
                    <th>SN</th>
                    <th class="numeric">Student Name</th>
                    <th class="numeric">Gender</th>
                    <th class="numeric">Subject</th>
                      
                      
                      <th class="numeric">CAT</th>
                      <th class="numeric">Exam</th>
                      <th class="numeric">Total</th>
                      <th class="numeric">Grade</th>
                      <th class="numeric">Remark</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  
                  $sql=mysqli_query($conn,"SELECT  sr.examYear AS ey, sr.examTerm AS et, sr.studentId AS st, sr.classId AS cl, sr.subjectId AS su, sr.cat AS cat, sr.exam AS ex, sr.total AS tot,  sr.grade AS gr, sr.remark AS rem, s.id AS si, s.surname AS fname, s.othernames AS lname, s.gender AS sex, sub.subjectname AS sname, c.classCode AS cname
                    from students s
                    INNER JOIN student_result sr
                      ON s.id = sr.studentId
                    INNER JOIN subjects sub
                      ON sub.classId = sr.classId
                    INNER JOIN class c
                      ON s.class=c.id 
                    WHERE  sr.studentId=s.id and sr.examYear='$year' and sr.examTerm='$term' and sub.id=sr.subjectId and sr.classId='$studClass' and sub.classId='$studClass'");
                  $sn=0;
                      if (mysqli_num_rows($sql)>0) { 
                        while ($row=mysqli_fetch_array($sql)) {
                          $gender=$row['sex'];
                          $id=$row['si'];
                          $subjectId= $row['su'];
                          $studName=$row['fname'].' &nbsp; '.$row['lname'];

                          
                           $classId = $row['cname'];
                           $cat=$row['cat'];
                           $exam=$row['ex'];
                           $total=$row['tot'];
                           $grade=$row['gr'];
                           $remark=$row['rem'];
                           $subject= $row['sname'];
                          ?>
                  <tr <?php if (($grade)=='A1'){
                    echo 'class="gradeA"';}
                    if (($grade =='B2') || ($grade=='B3')) {
                      echo 'class="gradeB"';}
                      if (($grade=='C4') || ($grade=='C5') || ($grade =='C6')) {
                        echo 'class="gradeC"';}
                        if (($grade =='D7') || ($grade =='E8')) 
                          {echo 'class="gradeU"';}
                        if ($grade=='F9')
                          {echo 'class="gradeX"';} ?>>
                    
                      
                    <td><?php echo ++$sn; ?></td>
                    <td><?php echo $studName ; ?></td>
                    <td><?php echo $gender; ?></td>
                    <td class="hidden-phone"><?php echo $subject ?></td>
                    <td class="hidden-phone"><?php echo $cat ?></td>
                    <td class="hidden-phone"><?php echo $exam ?></td>
                    <td class="hidden-phone"><?php echo $total ?></td>
                    <td class="center hidden-phone"><?php echo $grade; ?></td>
                    <td class="center hidden-phone"><?php echo $remark; }?> </td>
          </tr>
                    
                 
                  </tbody>
                  <?php  }else{
              echo "No Result Found";
             }}
             ?>
              </table>

             
            </div>
          </div>
        </div>
      </section>
      <?php footer();?>
    
     <!-- js placed at the end of the document so the pages load faster -->
     <script type="text/javascript">
     function printInvoice(){
        var content=document.getElementById('result').innerHTML;
        var printPrev=window.open('', '', 'height=1000, width=1000');
        printPrev.document.write('<html>');
        printPrev.document.write('<body>');
        printPrev.document.write(content);
        printPrev.document.write('</body></html>');
         printPrev.print();
        printPrev.close();

      }
  </script>
  <?php mainJs();
    tableMeta(); ?>
  <script type="text/javascript">
    
    function deleteStudent() {
      window.location.href='delete.php';
    }
    $(document).ready(function() {
      /*
       * Insert a 'details' column to the table
       */
      var nCloneTh = document.createElement('th');
      var nCloneTd = document.createElement('td');
      nCloneTd.className = "center";

      $('#hidden-table-info thead tr').each(function() {
        this.insertBefore(nCloneTh, this.childNodes[0]);
      });

      $('#hidden-table-info tbody tr').each(function() {
        this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
      });

      /*
       * Initialse DataTables, with no sorting on the 'details' column
       */
      var oTable = $('#hidden-table-info').dataTable({
        "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [0]
        }],
        "aaSorting": [
          [1, 'asc']
        ]
      });

    });
    
  </script>
</body>
<?php mysqli_close($conn);
?>
</html>

            