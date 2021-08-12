  <?php
  error_reporting(0);
  session_start();
    require '../db/db_con.php';
  if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 1) {
      require '../controller/required.php'; 
    }else{
      echo "<script> alert('Access denied for this user');
  window.location.href='users-dashboard.php';
  </script>";
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
  <link href="../assets/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />

   <section id="main-content">
      <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> All Admitted Students</h3>
        <div class="row mb">
          
          <!-- page start-->
          <div class="content-panel">
            <div class="alert alert-info alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                              </button>
                  <p>This table shows list of all admitted students. Use the Search box at your right hand side to manipulate the table e.g Find all students in Junior Secondary One by typing "Junior Secondary One". Always click the table headers to rearrange the table. <strong>Click on search to print all admitted students or students in a selected class</strong></p>
                  </div>

                  
                  <div class="form-group">
                  <div class="col-md-12">
                    
                    <a  class="btn btn-primary btn-xs pull-left" href="new-student.php"><i class="fa fa-plus"></i> New Student&nbsp; </a> &nbsp;
                    <a  href="all-admitted-students.php" title="Click here to print all admitted student in any class with Serial Number" class="btn btn-danger btn-xs"><i class="fa fa-search"></i> Search Students</a><br><br>
                 </div>                
                </div>

                 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm Document Printing!</h4>
              </div>
              <p style="font-size: 20px;">Are you sure you want to proceed?</p>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                <button class="btn btn-theme" type="submit" onclick="printDoc()" >Yes</button>
              </div>
            </div>
          </div>
      
          </div>
          <div id="expenses">
               <div style=" display: inline-block; width: 100%; margin-bottom: 25px" class="adv-table ">
              <div class="table-responsive">
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
                    <th>Fullname</th>
                    <th>Admission Number</th>
                    <th>Class</th>
                    <th>Admission Date & Time</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $sql=mysqli_query($conn,"SELECT s.id AS sid, s.regNum AS reg, s.surname AS sur, s.othernames AS other, s.admTime AS adt, s.admDate AS ad, cl.classCode AS clc, cl.name AS cname
                    from students s
                    INNER JOIN class cl
                    ON s.class=cl.id 
                    WHERE s.school='$userSchool' ORDER BY s.admTime ASC");
                      if (mysqli_num_rows($sql)>0 ) {           
                        $counter=0;
                       while($row = mysqli_fetch_array($sql)){
                        
                        $name=$row['sur'].' '.$row['other'];
                        $reg=$row['reg'];
                        $studId=$row['sid'];
                        $class=$row['cname'];
                        $dateTime=$row['ad'].' '.$row['adt'];
                        $classCode=$row['clc'];
                        
                      ?>
                     
                  <tr <?php if (($classCode)=='NUR'){echo 'class="gradeA"';}if (($classCode)=='GRD') {echo 'class="gradeB"';}if (($classCode)=='JSS'){echo 'class="gradeC"';}if (($classCode)=='SSS'){echo 'class="gradeX"';} ?> >
                    <td><?php echo ++$counter; ?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $reg; ?></td>
                    <td ><?php echo $class ?></td>
                    <td ><?php echo $dateTime; ?></td>
                    <td >
                      
                      <a href="<?php $urlEncode = rtrim(strtr(base64_encode(gzdeflate($studId, 9)), '+/','-_'),'=') ; echo 'admission-slip.php?id='.$urlEncode;?>" title="View Students Details" class="view btn btn-success btn-xs" data-id="<?php echo $reg;   ?>"><i class="fa fa-eye"></i></a>
                      
                      <a href="<?php echo 'update-choice.php?id='.$urlEncode;?>" title="Update Students Details" class="update btn btn-primary btn-xs" data-id="<?php echo $reg;   ?>"><i class="fa fa-pencil"></i></a>
                      
                <a href="delete.php?userReg=<?php echo $urlEncode ?>" title="Delete Students Details" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
              </form>
              <?php }}else{echo '';}?>
            </td>
          </tr>
                    
                 
                  </tbody>
              </table>
            </div>
             
            </div>
          </div>
        </div>
      </section><br><br><br><br><br>
      <?php footer();?>
    
    
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
 
  <script type="text/javascript" language="javascript" src="../assets/lib/advanced-datatable/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="../assets/lib/advanced-datatable/js/DT_bootstrap.js"></script>
 
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
    

    function printDoc(){
        var content=document.getElementById('expenses').innerHTML;
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

</html>

            