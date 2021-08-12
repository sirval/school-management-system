  <?php
    require '../db/db_con.php';
   
require '../controller/admin_required.php'; 
  
$userId=$_SESSION['usersn'];
siteTitle(mysite, ' || ', ' Super Admin'.' || ' . $_SESSION['username']);
//  $pagename='new-school';
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
        <h3><i class="fa fa-angle-right"></i> All USED PIN</h3>
        <div class="row mb">
          
          <!-- page start-->
          <div class="content-panel">
            
                  
                  <div class="form-group">
                  <div class="col-md-12">
                    
                    <a  class="btn btn-primary btn-xs pull-left" href="pin-generator.php"><i class="fa fa-plus"></i> Generate New PIN &nbsp; </a> &nbsp;
                    <br><br>
                 </div>                
                </div>
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
                    <th>PIN</th>
                    <th>Status</th>
                    <th>Date & Time Used</th>
                    <th>By</th>
                    <th>School</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $sql=mysqli_query($conn,"SELECT *
                    from pin WHERE validity = 1 and studentId != ''
                     ORDER BY id ASC");
                      if (mysqli_num_rows($sql)>0 ) {           
                       $count=1;
                       while($row = mysqli_fetch_array($sql)){
                        
                        
                        $pin=$row['pin'];
                        $valid=$row['validity'];
                        $genDate=$row['genDate'];
                        $studId=$row['studentId'];
                       
                        $dateUsed = $row['dtime'];
                        //$school=$row['school'];
                      $getStudDetails = mysqli_query($conn, "SELECT * FROM students, schools WHERE students.id='$studId' and students.school=schools.id");
                      if (mysqli_num_rows($getStudDetails)>0) {
                        while ($getRes = mysqli_fetch_array($getStudDetails)) {
                          $studName = $getRes['surname']. '  '. $getRes['othernames'].' '.$getRes['regNum'];
                          $studSchool = $getRes['name'];
                        }
                      }else{
                        echo "Data Not Found";

                        }
                      ?>
                      
                     
                  <tr <?php if (($valid)=='0'){echo 'class="gradeA"';}else {echo 'class="gradeX"';} ?> >
                    
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $pin; ?></td>                    
                    
                    <td ><?php if ($valid=='0') {
                      echo "Not Used";
                    }else { echo 'Used';} ?></td>
                    <td ><?php echo $dateUsed; ?></td>
                    <td ><?php echo $studName; ?></td>
                    <td ><?php echo $studSchool; ?></td>
                    <td >
                      
                    
                      <a  href="#" title="Update PIN" class="update btn btn-primary btn-xs" data-id="<?php echo $sn;   ?>"><i class="fa fa-pencil"></i></a>
                      
                <a href="#" title="Delete PIN" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
              </form>
              <?php }}else{echo '';}?>
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

<?php
mysqli_close($conn);
?>
            