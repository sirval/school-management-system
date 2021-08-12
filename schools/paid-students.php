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
        <h3><i class="fa fa-angle-right"></i> All Paid Students</h3>
        <div class="row mb">
          
          <!-- page start-->
          <div class="content-panel">
            <div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <p>This table shows list of student that have paid. Use the Search box at your right hand side to manipulate the table e.g Find all students in Junior Secondary One by typing "Junior Secondary One". Always click the table headers to rearrange the table.</p>
            </div>
            <div class="form-group">
                  <div class="col-md-12">
                    
                    <a  data-toggle="modal" class="btn btn-primary btn-xs pull-right" href="view-expenses.php#myModal">Print Document&nbsp; </a><br><br>  
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
                <button class="btn btn-theme" type="submit" onclick="printInvoice()" >Yes</button>
              </div>
            </div>
          </div>
      
          </div>
          <div id="expenses">
             <div style=" display: inline-block; width: 100%; margin-bottom: 25px" class="adv-table ">
              <div class="table-responsive">
              <table style="border-collapse: collapse;" cellpadding="0" cellspacing="0" border="0" class=" display table table-bordered " id="hidden-table-info">
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
                    <th>Payment Term</th>
                    <th>Amount Paid</th>
                    <th>Balance</th>
                    <th>Payment Mode</th>
                    <th>Payment Description</th>
                    <th>Date/Time Paid</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $sql=mysqli_query($conn,"SELECT st.id AS stId, st.surname AS sur, st.othernames AS other, st.regNum AS reg, cl.name AS name, cl.classCode AS cCode, sf.id AS cId,sf.datePaid AS dp, sf.amountPaid AS amtP, sf.balance AS bal, sf.paymentMode AS paym, sf.pop AS po, sf.payTerm AS payt
                    from 
                    students st,
                     class cl,student_fees sf
                 
                    
                    WHERE st.class=cl.id and st.school='$userSchool' and sf.studentId=st.id ORDER BY sf.datePaid DESC ");
                      if (mysqli_num_rows($sql)>0 ) {           
                        $counter=0;
                       while($row = mysqli_fetch_array($sql)){
                        
                        $name=$row['sur'].' '.$row['other'];
                        
                        $reg=$row['reg'];
                        $feeId=$row['cId'];
                        $class=$row['name'];
                        $datePaid=$row['dp'];
                        $classCode=$row['cCode'];
                        $amountPaid=(int)$row['amtP'];
                        $balance=$row['bal'];
                        $payMode=$row['paym'];
                        $pop=$row['po'];
                        $studId = $row['stId'];
                        $payTerm=$row['payt'];
                      ?>
                     
                  <tr <?php if (($classCode)=='NUR'){echo 'class="gradeA"';}if (($classCode)=='GRD') {echo 'class="gradeB"';}if (($classCode)=='JSS'){echo 'class="gradeC"';}if (($classCode)=='SSS'){echo 'class="gradeX"';} ?> >
                    <td><?php echo ++$counter; ?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $reg; ?></td>
                    
                    <td ><?php echo $class ?></td>
                    <td><?php echo $payTerm; ?></td>
                    <td ><?php echo $amountPaid; ?></td>
                    <td ><?php echo $balance; ?></td>
                    <td ><?php echo $payMode; ?></td>
                    <td ><?php if ($balance==0 && $balance!='') {
                      echo 'Full Payment';
                      
                    } else{echo "Part Payment";}?></td>
                    <td><?php echo $datePaid; ?></td>
                    <td >
                      
                      <a data-toggle="modal" href="<?php  $url_Encode = rtrim(strtr(base64_encode(gzdeflate($studId, 9)), '+/','-_'),'=') ; echo 'print-receipt.php?id='.$url_Encode;?>" title="View Receipt" class=" btn btn-success btn-xs" data-id="<?php echo $feeId;   ?>"><i class="fa fa-eye"></i></a>
                      
                      <a data-toggle="modal" href="<?php  $urlEncode = rtrim(strtr(base64_encode(gzdeflate($feeId, 9)), '+/','-_'),'=') ; echo 'update-payment-details.php?id='.$urlEncode;?>" title="Update Payment" class="update btn btn-primary btn-xs" data-id="<?php echo $reg;   ?>"><i class="fa fa-pencil"></i></a>
                      <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                  <input hidden="" type="text" value="<?php echo $reg; ?>" name="studReg" >
                <a href="delete-students-payment.php?userReg=<?php echo $urlEncode ?>" title="Delete Students Details" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
              </form>
                      
                    <?php }}else{echo 'error'. mysqli_error($conn);}?>
                    </td>
                  </tr>
                 
                  </tbody>
              </table>
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
     function printInvoice(){
        var content=document.getElementById('expenses').innerHTML;
        var printPrev=window.open('', '', 'height=1000, width=1000');
        printPrev.document.write('<html>');
        printPrev.document.write('<body>');
        printPrev.document.write(content);
        printPrev.document.write('</body></html>');
         printPrev.print();
        printPrev.close();

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

</html>

            