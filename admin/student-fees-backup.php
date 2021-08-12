  <?php
    require '../db/db_con.php';
if (isset($_POST['delete'])) {
  $del_id=$_POST['studReg'];
  if (!empty($del_id)) {
   
    $delQuery=mysqli_query($conn, "DELETE FROM  school_fees WHERE regNum='$del_id'");
   if ($delQuery) {
    echo "<script>alert'Students Data Deleted Successfully'</script>";
   }else{
    echo "<script>alert' A fatal error was encountered while trying to delete student'</script>";
   }
  }else{
    echo "<script>alert' Seems this student has no Registration Number'</script>";
   }

}
  
require '../controller/admin_required.php'; 
 
$userId=$_SESSION['usersn'];
siteTitle(mysite, ' || ', ' Super Admin'.' || ' . $_SESSION['username']);
 //$pagename='new-school';
   meta();
    pageHeader();
   sideBar();
   $select=mysqli_query($conn, "SELECT * FROM schools");
   if (mysqli_num_rows($select)){
    $userSchool=$row['id'];
   }
   ?>
     <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
  <link href="lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
  <link rel="stylesheet" href="lib/advanced-datatable/css/DT_bootstrap.css" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">
  <style type="text/css">
    .padTable{
      margin: 10px;
    }
  </style>
   <section id="main-content">
      <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> All Paid Students</h3>
        <div class="row mb">
          
          <!-- page start-->
          <div class="content-panel">
            <div class="alert alert-info alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                              </button>
                  <p>This table shows list of student that have paid. Use the Search box at your right hand side to manipulate the table e.g Find all students in Junior Secondary One by typing "Junior Secondary One". Always click the table headers to rearrange the table.</p>
                  </div>
            <div  class="adv-table padTable">
              <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>Fullname</th>
                    <th>Reg Number</th>
                    <th>Class</th>
                    <th>Amount Paid</th>
                    <th>Balance</th>
                    <th>Payment Mode</th>
                    <th>Payment Term</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $sql=mysqli_query($conn,"SELECT * 
                    from 
                    students,
                     class,student_fees_backup
                 
                    
                    WHERE students.class=class.id  and student_fees_backup.regNum=students.regNum ORDER BY students.regNum DESC ");
                      if (mysqli_num_rows($sql)>0 ) {           
               
                       while($row = mysqli_fetch_array($sql)){
                        $name=$row['surname'].' '.$row['othernames'];
                        
                        $reg=$row['regNum'];
                        
                        $class=$row['name'];
                        $datePaid=$row['datePaid'];
                        $classCode=$row['classCode'];
                        $amountPaid=(int)$row['amountPaid'];
                        $balance=$row['balance'];
                        $payMode=$row['paymentMode'];
                        $pop=$row['pop'];
                        
                        $payTerm=$row['payTerm'];

                        
                      ?>
                     
                  <tr <?php if (($classCode)=='NUR'){echo 'class="gradeA"';}if (($classCode)=='GRD') {echo 'class="gradeB"';}if (($classCode)=='JSS'){echo 'class="gradeC"';}if (($classCode)=='SSS'){echo 'class="gradeX"';} ?> >
                    <td><?php echo $name; ?></td>
                    <td><?php echo $reg; ?></td>
                    <td class="hidden-phone"><?php echo $class ?></td>
                    <td class="center hidden-phone"><?php echo $amountPaid; ?></td>
                    <td class="center hidden-phone"><?php echo $balance; ?></td>
                    <td class="center hidden-phone"><?php echo $payMode; ?></td>
                    <td class="center hidden-phone"><?php if ($balance==0 && $balance!='') {
                      echo 'All Term';
                      
                    } else{echo "Part Payment";}?></td>
                    <td class="center hidden-phone">
                      
                      <a data-toggle="modal" href="#" title="View Receipt" class="delete btn btn-success btn-xs"  data-id="<?php echo $reg;   ?>"><i class="fa fa-eye"></i></a>
                      
                      <a data-toggle="modal" href="#" title="Update Payment" class="update btn btn-primary btn-xs" data-id="<?php echo $reg;   ?>"><i class="fa fa-pencil"></i></a>
                      <a data-toggle="modal" href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
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
  

     <!-- js placed at the end of the document so the pages load faster -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="lib/jquery.scrollTo.min.js"></script>
  <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
  <!--common script for all pages-->
  <script src="lib/jquery/jquery.min.js"></script>
  <script type="text/javascript" language="javascript" src="lib/advanced-datatable/js/jquery.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="lib/jquery.scrollTo.min.js"></script>
  <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
  <script type="text/javascript" language="javascript" src="lib/advanced-datatable/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="lib/advanced-datatable/js/DT_bootstrap.js"></script>
  <!--common script for all pages-->
  <script src="lib/common-scripts.js"></script>
  <!--script for this page-->
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

            