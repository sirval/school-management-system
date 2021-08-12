
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
   <style type="text/css">
    .padTable{
      margin: 10px;
    }
  </style>
   <section id="main-content">
      <section class="wrapper">
       
        <div class="row mb">
          
          <!-- page start-->
          <div class="content-panel">
            <div class="col-md-10">
            	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="col-md-4 input-append">
                    <select class="form-control form-control-inline input-medium " placeholder="Admission Number" name="stud_class" id="stud_class" required="">
                      <option>--Select Class--</option>
                       <option value="all">All</option>
                      <?php 
                    $sql=mysqli_query($conn,"SELECT * from class");
                      if (mysqli_num_rows($sql)>0 ) {           
               
                       while($row = mysqli_fetch_array($sql)){
                        $cid =  $row['id']; 
                        $name = $row['name'];
                      
                    ?>
                      <option value="<?php echo $cid ; ?>"><?php echo $name; }}else{echo "NO AVAILABLE CLASS FOUND";}?></option>
                    </select>  
                     <span class="input-group-btn add-on">
                        <button name="filter" class="btn btn-theme" type="submit"><i class="fa fa-search"> Filter</i></button>
                        </span>
                  </div>
              </form>
                </div>
                <div>
                  <button onclick="printInvoice()" style="float: right; margin-right: 20px;"  title="Print" class="btn btn-primary btn-xs"><i class="fa fa-print"></i> Print
                  </button>
                </div><br><br>
                  <div id="invoice"  class="adv-table padTable">
              <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
              	<caption><h3 style="text-align: center;">LIST OF STUDENTS IN .............</h3></caption>
              	
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
                    
                  </tr>
                </thead>
              	<?php 
                  if (isset($_POST['filter'])) {
                  	$stud_class= $_POST['stud_class'];
                  	if (!empty($stud_class)) {
                  		
                  $sql=mysqli_query($conn,"SELECT * 
                    from students 
                    INNER JOIN class 
                    ON students.class=class.id 
                    WHERE students.school='$userSchool' and students.class='$stud_class' ORDER BY students.admTime ASC");
                      if (mysqli_num_rows($sql)>0 ) { 
                      	$counter=0;
                       while($row = mysqli_fetch_array($sql)){
                        
                        $name=$row['surname'].' '.$row['othernames'];
                        $_SESSION['class']=$row['class'];
                        $reg=$row['regNum'];
                        $class=$row['name'];
                        $dateTime=$row['admDate'].' '.$row['admTime'];
                        $classCode=$row['classCode'];
                    
                        
                      ?>
              	
                <tbody>
                  
                  <tr <?php if (($classCode)=='NUR'){echo 'class="gradeA"';}if (($classCode)=='GRD') {echo 'class="gradeB"';}if (($classCode)=='JSS'){echo 'class="gradeC"';}if (($classCode)=='SSS'){echo 'class="gradeX"';} ?> >
                    <td><?php echo ++$counter; ?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $reg; ?></td>
                    <td class="hidden-phone"><?php echo $class ?></td>
                    <td class="center hidden-phone"><?php echo $dateTime; ?></td>
                </tr>
              </form>
              <?php }
          }elseif ($stud_class=='all') {
              	$sql=mysqli_query($conn,"SELECT * 
                    from students 
                    INNER JOIN class 
                    ON students.class=class.id 
                    WHERE students.school='$userSchool' ORDER BY students.regNum DESC");
                      if (mysqli_num_rows($sql)>0 ) {           
                        $counter=0;
                       while($row = mysqli_fetch_array($sql)){
                        
                        $name=$row['surname'].' '.$row['othernames'];
                        $reg=$row['regNum'];
                        $class=$row['name'];
                        $dateTime=$row['admDate'].' '.$row['admTime'];
                        $classCode=$row['classCode'];
                        ?>
                        <tbody>
                  
                     
                  <tr <?php if (($classCode)=='NUR'){echo 'class="gradeA"';}if (($classCode)=='GRD') {echo 'class="gradeB"';}if (($classCode)=='JSS'){echo 'class="gradeC"';}if (($classCode)=='SSS'){echo 'class="gradeX"';} ?> >
                    <td><?php echo ++$counter; ?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $reg; ?></td>
                    <td><?php echo $class ?></td>
                    <td><?php echo $dateTime; ?></td>
                </tr>
              </form>
              <?php
              } }}}}?>
             
                  </tbody>
              </table>

             
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
        var content=document.getElementById('invoice').innerHTML;
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
  <?php 
  mysqli_close($conn); 
  ?>
</body>

</html>
