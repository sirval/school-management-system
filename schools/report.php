  <?php
  error_reporting(0);
  session_start();
    require '../db/db_con.php';
if (isset($_POST['delete'])) {
  $del_id=$_POST['studReg'];
  if (!empty($del_id)) {
   $delQuery=mysqli_query($conn, "DELETE FROM students WHERE regNum='$del_id' ");
    $delQuery=mysqli_query($conn, "DELETE FROM  school_fees WHERE regNum='$del_id'");
     $delQuery=mysqli_query($conn, "DELETE FROM  parents WHERE regNum='$del_id'");
   if ($delQuery) {
    echo "<script>alert'Students Data Deleted Successfully'</script>";
   }else{
    echo "<script>alert' A fatal error was encountered while trying to delete student'</script>";
   }
  }else{
    echo "<script>alert' Seems this student has no Registration Number'</script>";
   }

}
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
   <section id="main-content">
      <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Report</h3>
        <div class="row mb">
          
          <!-- page start-->
          <div class="content-panel">
            
                 
           <div style=" display: inline-block; width: 100%; margin-bottom: 25px" class="adv-table ">
              <div class="table-responsive">
              <table cellpadding="0" cellspacing="0" border="0" class="auto-index display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>Fullname</th>
                    <th>Registration Number</th>
                    <th>Class</th>
                    <th>Gender</th>
                    <th>DoB</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                   
                  $sql=mysqli_query($conn,"SELECT * 
                    from students 
                    INNER JOIN class 
                    ON students.class=class.id 
                    WHERE students.school='$userSchool' ORDER BY students.regNum DESC");
                      if (mysqli_num_rows($sql)>0 ) {           
               
                       while($row = mysqli_fetch_array($sql)){
                        $name=$row['surname'].' '.$row['othernames'];
                        $reg=$row['regNum'];
                        $class=$row['name'];
                        $dateTime=$row['admDate'].' '.$row['admTime'];
                        $classCode=$row['classCode'];
                        $gender=$row['gender'];
                        $dob=$row['dob'];
                        
                      ?>
                     
                  <tr <?php if (($classCode)=='NUR'){echo 'class="gradeA"';}if (($classCode)=='GRD') {echo 'class="gradeB"';}if (($classCode)=='JSS'){echo 'class="gradeC"';}if (($classCode)=='SSS'){echo 'class="gradeX"';} ?> >
                    <td><?php echo $name; ?></td>
                    <td><?php echo $reg; ?></td>
                    <td ><?php echo $class ?></td>
                    <td ><?php echo $gender; ?></td>
                    <td ><?php echo $dob; ?>
                      
                      
                    <?php }}else{echo '';}?>
                    </td>
                  </tr>
                 
                  </tbody>
              </table>

              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm Deletion!</h4>
              </div>
             
              <span class="label label-danger label-mini">WARNING!</span>&nbsp;<label style="font-size: 20px;">This action will delete all  information related to <?php echo $name; ?> including payments.<br> Consider Updating Record Instead! </label> <br>
               
              <br>
              <div class="modal-footer">
                <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                  <input type="text" value="<?php echo $reg; ?>" name="studReg" hidden="">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                <button class="btn btn-danger" type="submit" name="delete">Continue Anyway</button>
              </form>
              </div>
            </div>
          </div>
        </div>
            </div>
          </div>
        </div>
      </section>
      <?php footer();?>
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
    /* Formating function for row details */
    

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

</html>

            