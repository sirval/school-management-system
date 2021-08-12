  <?php
  error_reporting(0);
  session_start();
    require '../db/db_con.php';
if (isset($_POST['delete'])) {
  $del_id=$_POST['studReg'];
  if (!empty($del_id)) {
   
    $delQuery=mysqli_query($conn, "DELETE FROM  student_fees WHERE regNum='$del_id'");
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
  <link href="../assets/lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
  <link href="../assets/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/lib/advanced-datatable/css/DT_bootstrap.css" />
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
        <h3><i class="fa fa-angle-right"></i> Payment Registration</h3>
        <div class="row mb">
          
          <!-- page start-->
          <div class="content-panel">
            <div class="alert alert-info alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                              </button>
                  <p>This table shows list of student that have not paid. Use the Search box at your right hand side to look out for a student to pay for. Always click the table headers to rearrange the table.</p>
                  </div>
            
            <div style=" display: inline-block; width: 100%; margin-bottom: 25px" class="adv-table ">
              <div class="table-responsive">
              <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>SN</th>
                    <th>Fullname</th>
                    <th>Admission Number</th>
                    <th>Class</th>
                   
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody >
                  <?php 
                  //get all unpaid students
                  
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
                    
                    <td >
                      
                      <a href="<?php $urlEncode = rtrim(strtr(base64_encode(gzdeflate($studId, 9)), '+/','-_'),'=') ; echo 'make-payment.php?id='.$urlEncode;?>" title="Make Payment" class="delete btn btn-success btn-xs" ><i class="fa fa-money"></i> Pay Now</a>
                      
                      
                    <?php }} else{echo '';}?>
                    </td>
                  </tr>
                 
                  </tbody>
              </table>
            </div>

              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm Deletion!</h4>
              </div>
             
              <span class="label label-danger label-mini">WARNING!</span>&nbsp;<label style="font-size: 20px;">Your are about to delete all fees related to <?php echo $name; ?></label> <br>
               
              <br>
              <div class="modal-footer">
                <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                  <input type="text" value="<?php echo $reg; ?>" name="studReg" hidden="">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                <button class="btn btn-danger " type="submit" name="delete">Continue Anyway</button>
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
 <script>

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

            