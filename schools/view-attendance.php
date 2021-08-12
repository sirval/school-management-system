<?php
error_reporting(0);
session_start();
require '../db/db_con.php';

if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
    if ($errmsg == '1') {
      $msgerror ='Sorry we could not delete this data at this point.';
    }
    elseif($errmsg =='2'){
        $msgerror ='A fatal error occured! Supply the requested values and try again later or Kindly contact the admin for more details';
    }
    elseif($errmsg =='3'){
        $msgerror ='Please specify if this is a Morning or Afternoon Roll Call. ';
    }
    
    
  }
  if (isset($_GET['delete']) && $_GET['delete']=='successful') {
  $msgsucc="Roll Call Deleted Successfully";
}
   if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 1) {
      require '../controller/required.php'; 
    }else{
      require '../controller/users_required.php'; 
    }
   /*if (!isset($_SESSION['userId']) && !isset($_SESSION['user'])) {
    header('location:index.php');
}
$userId=$_SESSION['userId'];*/
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
          <div class="row mb">
           <div class="content-panel">
              <div class="invoice-body">
                
                
              
         <div>
          <?php
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
              elseif (isset($msgsucc) && $msgsucc !=='') 
            {
        ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
                <?php echo $msgsucc; }?>
        </div>
        
       </div>

        
        <div id="report" class="invoice-body">
           <?php
              
               if (isset($_SESSION["attDate"]) && isset($_SESSION["term"]) && ($_SESSION["studClass"]!='') && isset($_SESSION["Mor_After"]) && ($_SESSION["Mor_After"] !='')  ) 
               {

                  $vSession= $_SESSION['Mor_After'];
                  $attDate = $_SESSION['attDate'];
                  $classId = $_SESSION['studClass'];
                  $termId= $_SESSION['term'];
                  if ($vSession == 'Morning') 
                  {
                    
                   $term=mysqli_query($conn,"SELECT * from term WHERE id='$termId'");
                    if (mysqli_num_rows($term)>0 )
                    {  
                       while($row = mysqli_fetch_array($term))
                       {
                        $termName=$row['termName'];
                       }
                    }
                      else
                      {
                        echo "<script> alert ('An Error Occured!');
                               window.location.href='attendance-options.php';</script>
                              ";
                      }
         
                 $class=mysqli_query($conn,"SELECT * from class WHERE id='$classId'");
                    if (mysqli_num_rows($class)>0 ) {  
                       while($row = mysqli_fetch_array($class)){
                        $classResult=$row['classCode'];
                       }
                      }
           
        
         ?>   
        <div class="school_header">
            <h3 style="text-align: center; text-decoration: underline;"><?php echo  $classResult."&nbsp;".$vSession ."&nbsp;"."ROLL CALL FOR &nbsp;". $attDate;?></h3>
            
            <br>
          
        </div>
                <br>
            <div id="tableMorning">    
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
                    <th width="2%">SN</th>
                    <th >Student Name</th>
                    <th >Add. No</th>
                    <th >Gender</th>
                    <th>Time</th>
                      <th>Status</th>
                      <th>Action</th>

                      
                  </tr>

                </thead>
                <tbody>
               <?php

        $sql=mysqli_query($conn, "SELECT st.id AS sid, st.surname AS sur, st.othernames AS other, st.gender AS sex, st.regNum AS reg, am.date AS da, am.term AS term, am.present AS pre, am.time AS ti
        	FROM 
        	students st
          INNER JOIN attendance_morning am
            ON st.id = am.studentId
          
          WHERE 
          st.class='$classId' and am.term='$termId' and am.date = '$attDate' and am.studentId=st.id");
        
  $sn=0;
  if (mysqli_num_rows($sql)>0) 
  {
    
  while ($getRes=mysqli_fetch_array($sql)) {
  		$studName = $getRes['sur'].' '. $getRes['other'];
  		$gender = $getRes['sex'];
      $reg = $getRes['reg'];
  		$mpresent = $getRes['pre'];
  		 $time = $getRes['ti'];
      $term = $getRes['term'];
      $stId= $getRes['sid'];
  
 ?>
      <tr <?php if (($gender)=='Female'){
                    echo 'class="gradeA"';}else{
                      echo 'class="gradeB"';
                    }
                    
                        ?>>
                    
                      
                    <td><?php echo ++$sn; ?></td>
                    <td><?php echo $studName ; ?></td>
                    <td><?php echo $reg; ?></td>
                    <td><?php echo $gender; ?></td>
                    <td><?php echo substr($time, 11,20); ?></td>
                   
                    <td ><?php if (($mpresent=='1')) {
                        echo '<span class="label label-primary"> Present </span>';}else{
                          echo '<span class="label label-danger"> Absent </span>';
                        } ?></td>
                    
                     <td>
                       <?php $_SESSION['attId'] = $stId; 
                        $urlEncode = rtrim(strtr(base64_encode(gzdeflate($_SESSION['attId'], 9)), '+/','-_'),'=')
                         ?>
                       
                      <a href="<?php echo 'delete-attendance.php?permalink='.$urlEncode; ?>" title="Delete this Record" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i>
                        
                      </a>
                     </td>
                    </tr> 
                    
                    <?php
                  }
                    }else
                    {
                      echo '';
                    }
                    
                    ?>
                         
          
           </tbody>
          </table>
          </div>
        </div>
      </div>
          <div id="tableAfternoon">
          <?php 
          }
                    elseif ($vSession == 'Afternoon') 
                  {
                    
                   $term=mysqli_query($conn,"SELECT * from term WHERE id='$termId'");
                    if (mysqli_num_rows($term)>0 )
                    {  
                       while($row = mysqli_fetch_array($term))
                       {
                        $termName=$row['termName'];
                       }
                    }
                      else
                      {
                        echo "<script> alert ('We could not find the specified term, that is all we know!');
                               window.location.href='main-dashboard.php';</script>
                              ";
                      }
         
                 $class=mysqli_query($conn,"SELECT * from class WHERE id='$classId'");
                    if (mysqli_num_rows($class)>0 ) {  
                       while($row = mysqli_fetch_array($class)){
                        $classResult=$row['classCode'];
                       }
                      }
           
        
         ?>   
        <div class="school_header">
            <h3 style="text-align: center;  text-decoration: underline;"><?php echo  $classResult."&nbsp;".$vSession ."&nbsp;"."ROLL CALL FOR &nbsp;". $attDate;?></h3>
           
            <br>
        </div>
                <br>
                
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
                    <th width="2%">SN</th>
                    <th >Student Name</th>
                    <th >Add. No</th>
                    <th >Gender</th>
                    <th>Time</th>
                      <th>Status</th>
                      <th>Action</th>

                      
                  </tr>

                </thead>
                <tbody>
               <?php

        $sql=mysqli_query($conn, "SELECT st.id AS sid, st.surname AS sur, st.othernames AS other, st.gender AS sex, st.regNum AS reg, af.date AS da, af.term AS term, af.present AS pre, af.time AS ti, af.morningId AS monId
          FROM 
          attendance_morning am,
          students st
          INNER JOIN attendance_afternoon af
            ON st.id = af.mId
          WHERE 
          st.class='$classId' and af.term='$termId' and af.date = '$attDate' and af.morningId=am.id ");
        
  $sn=0;
  if (mysqli_num_rows($sql)>0) {
    
  while ($getRes=mysqli_fetch_array($sql)) {
      $studName = $getRes['sur'].' '. $getRes['other'];
      $gender = $getRes['sex'];
      $reg = $getRes['reg'];
      $mpresent = $getRes['pre'];
      $time = $getRes['ti'];
      $term = $getRes['term'];
      $monId = $getRes['monId'];
      $stId= $getRes['sid'];
      $adate= $getRes['da'];
  
 ?>
      <tr <?php if (($gender)=='Female'){
                    echo 'class="gradeA"';}else{
                      echo 'class="gradeB"';
                    }
                    
                        ?>>
                    
                      
                    <td><?php echo ++$sn; ?></td>
                    <td><?php echo $studName ; ?></td>
                    <td><?php echo $reg; ?></td>
                    <td><?php echo $gender; ?></td>
                    <td><?php echo substr($time, 11,20); ?></td>
                   
                    <td ><?php if (($mpresent=='1')) {
                        echo '<span class="label label-primary"> Present </span>';}else{
                          echo '<span class="label label-danger"> Absent </span>';
                        } ?></td>
                    
                     <td>
                      
                        <?php $_SESSION['attId'] = $stId; 
                        $urlEncode = rtrim(strtr(base64_encode(gzdeflate($_SESSION['attId'], 9)), '+/','-_'),'=')
                         ?>
                       
                      <a href="<?php echo 'delete-attendance.php?permalink='.$urlEncode; ?>" title="Delete this Record" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i>
                        
                      </a>
                    
                     </td>
                     
                    </tr> 
                    
                    <?php
                  }
                    }
                    else{
                      echo "";
                    }
                    
                    ?>
                         
          
           </tbody>
          </table>
          </div>
          <?php 
          }
                    
                  }
          ?>
          </div>
          
          </div>
          <div class="pull-right">
            <button class="btn btn-sm btn-info" onclick="printInvoice()">Print</button>
            <a  class="btn btn-theme btn-sm " href="attendance-options.php">New Roll Call &nbsp;<i class="fa fa-eye"></i> </a>
            <a style="justify-content: center;" class="btn btn-warning btn-sm " href="update-attendance.php">Update Roll Call&nbsp;<i class="fa fa-edit"></i> </a>
            
        </div>
          <br><br><br> <br><br><br>
          </div>
          </div>
          </section>

          
    <!--footer start-->
    <footer class="">
      <div class="text-center">
                
      <?php footer();
      ?>
      </div>
    </footer>
    <!--footer end-->
  </section>
  <script type="text/javascript">
     function printInvoice(){
        var content=document.getElementById('report').innerHTML;
        var printPrev=window.open('', '', 'height=1000, width=1000');
        printPrev.document.write('<html>');
        printPrev.document.write('<body>');
        printPrev.document.write(content);
        printPrev.document.write('</body></html>');
         printPrev.print();
        printPrev.close();

      }
  </script>
   
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
<?php mysqli_close($conn);
?>
</html>