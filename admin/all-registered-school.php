  <?php
    require '../db/db_con.php';
if (isset($_POST['delete'])) {
  $del_id=$_POST['id'];
  if (!empty($del_id)) {
   
    $delQuery=mysqli_query($conn, "DELETE FROM  schools WHERE id='$del_id'");
   if ($delQuery) {
    echo "<script>alert'School Deleted Successfully'</script>";
   }else{
    echo "<script>alert' A fatal error was encountered while trying to delete school'</script>";
   }
  }else{
    echo "<script>alert' Seems this school has no Registration Number'</script>";
   }

}
   require '../controller/admin_required.php'; 
$userId=$_SESSION['usersn'];
siteTitle(mysite, ' || ', ' Super Admin'.' || ' . $_SESSION['username']);
   meta();
    pageHeader();
   sideBar();
    
    
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
        <h3><i class="fa fa-angle-right"></i> All Registered School</h3>
        <div class="row mb">
          
          <!-- page start-->
          <div class="content-panel">
            <div class="alert alert-info alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                              </button>
                  <p>This table shows list of Schools Registerd. Use the Search box at your right hand side to look out for a student to pay for. Always click the table headers to rearrange the table.</p>
                  </div>
            <div  class="adv-table padTable">
              <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>School Name</th>
                    <th>Phone</th>
                    <th>Installed Date</th>
                    <th>Update Required</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $sql=mysqli_query($conn,"SELECT s.id AS si, s.name as sn,s.motto as sm,s.address as sa,s.code as sc, s.logo as sl, s.schPhone as phone,  et.endDate as ete, et.schoolId as ets, et.startDate as etsd
                    FROM 
                    schools s 
                    INNER JOIN elapse_time et
                    ON s.id=et.schoolId
                    ");
                      if (mysqli_num_rows($sql)>0) {
                        
                       while($row = mysqli_fetch_array($sql))
                       {
                        $name=$row['sn'];
                        
                        $code=$row['sc'];
                        $phone=$row['phone'];
                        
                        $startDate=$row['etsd'];
                        $endDate=$row['ete'];
                        $id=$row['si'];
                      ?>
                     
                  <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $phone; ?></td>
                    
                    <td class=""><?php echo $startDate; ?></td>
                    <td class=""><?php echo $endDate; ?></td>
                    
                    <td class="">
                       <a data-toggle="modal" href="<?php echo 'view-school-detail.php?id='.$id;?>" title="View School Detail" class="view btn btn-success btn-xs" data-id="<?php echo $id;   ?>"><i class="fa fa-eye"></i></a>
                      <a data-toggle="modal" href="<?php echo 'update-school-info.php?id='.$id;?>" title="Update School Detail" class="update btn btn-primary btn-xs" data-id="<?php echo $id;   ?>"><i class="fa fa-pencil"></i> </a>
                      <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                      <button type="submit" name="delete"  title="Delete School Details" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                      </form>
                      
                    <?php } }else
                    {
                      echo "string".mysqli_error($conn);
                    } ?>
                    </td>
                  </tr>
                 
                  </tbody>
              </table>

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

            