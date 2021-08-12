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
    require '../controller/parents_required.php'; 
   
   /*if (!isset($_SESSION['userId']) && !isset($_SESSION['user'])) {
    header('location:index.php');
}
$userId=$_SESSION['userId'];*/

siteTitle(mysite, ' || ', '  Parents'.' || ' . $_SESSION['username']);
   meta();
    pageHeader();
   sideBar();
   if (isset($_SESSION['parentId']) && isset($_SESSION['username']) && isset($_SESSION['schoolId']) ) 
   {
    $parentId = $_SESSION['parentId'];
    $parent = $_SESSION['username'];
    $phone = $_SESSION['phone'];
    $studId = $_SESSION['studId'];
   }
   else 
   {
   	header('location:index.php');
   }
    
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
   
   <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
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

        
           <?php
              
                  $term = $_SESSION['term'];
                  $year = $_SESSION['year'] ;
                  $studId = $_SESSION['studId'];
                  $schoolId = $_SESSION['schoolId'];
                  //get term
                  $sql=mysqli_query($conn,"SELECT * FROM term WHERE id = '$term'");
                      if (mysqli_num_rows($sql)>0 ) 
                      {           
                       while($row = mysqli_fetch_array($sql))
                       {
                          $termName = $row['termName'];
                        }
                      }

                    //get students details
                 $getStudDetail=mysqli_query($conn,"SELECT * from students WHERE id='$studId'");
                    if (mysqli_num_rows($getStudDetail)>0 ) 
                    {  
                       while($row = mysqli_fetch_array($getStudDetail))
                       {
                       
                        $studClass=$row['class'];
                       
                       }
                    }

                //get students details
                 $getClass=mysqli_query($conn,"SELECT * from class WHERE id='$studClass'");
                    if (mysqli_num_rows($getClass)>0 ) 
                    {  
                       while($row = mysqli_fetch_array($getClass))
                       {
                        $classResult=$row['classCode'];
                       }
                    }
           
        
         ?>   
        <div class="school_header">
            <h3 style="text-align: center; text-decoration: underline;"><?php echo  $classResult." ". $year." ". $termName." &nbsp;"."ROLL CALL";?></h3>
            
            <br>
          
        </div>
                <br>
                <div id="report" class="invoice-body">
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
                    <th>Date</th>
                      <th>Morning Status</th>
                      <th>Afternoon Status</th>

                      
                  </tr>

                </thead>
                <tbody>
               <?php
               

        $sql=mysqli_query($conn, "SELECT st.id AS sid, st.surname AS sur, st.othernames AS other, st.gender AS sex, st.regNum AS reg, af.date AS da, af.term AS term, af.present AS pre, af.time AS ti, af.morningId AS monId, am.present AS amPre
          FROM 
          attendance_morning am,
          students st
          INNER JOIN attendance_afternoon af
            ON st.id = af.mId
          WHERE 
          st.class='$studClass' and af.year = '$year' and af.morningId=am.id and st.id='$studId' ");
        
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
      $date= $getRes['da'];
       $amPre= $getRes['amPre'];
  
 ?>
      <tr <?php if (($gender)=='Female'){
                    echo 'class="gradeA"';}else{
                      echo 'class="gradeB"';
                    }
                    
                        ?>>
                    
                      
                    <td><?php echo ++$sn; ?></td>
                    <td><?php echo $studName ; ?></td>
                    <td><?php echo $date; ?></td>
                   
                    <td ><?php if (($amPre=='1')) {
                        echo '<span class="label label-primary"> Present </span>';}else{
                          echo '<span class="label label-danger"> Absent </span>';
                        } ?>
                        	
                    </td>
                    
                      <td ><?php if (($mpresent=='1')) {
                        echo '<span class="label label-primary"> Present </span>';}else{
                          echo '<span class="label label-danger"> Absent </span>';
                        } ?>
                        	
                    </td>
                    </tr> 
                    
                    <?php
                  }
                    }else{
                      echo 'Seems the Roll Call has not been taken. If you feel we are not sure, kindly contact your words school for more details';
                    }
                
                    
                    ?>
                         
          
           </tbody>
          </table>
          </div>
       
      </div>
    </div>
         <div class="pull-right">
            <button class="btn btn-sm btn-info" onclick="printInvoice()">Print</button>
        </div>
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
   
     <!-- js placed at the end of the document so the pages load faster -->
  <script src="../assets/lib/jquery/jquery.min.js"></script>
  <script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="../assets/lib/jquery.scrollTo.min.js"></script>
  <script src="../assets/lib/jquery.nicescroll.js" type="text/javascript"></script>
  <!--common script for all pages-->
  <script src="../assets/lib/jquery/jquery.min.js"></script>
  <script type="text/javascript" language="javascript" src="../assets/lib/advanced-datatable/js/jquery.js"></script>
  <script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="../assets/lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="lib/jquery.scrollTo.min.js"></script>
  <script src="../assets/lib/jquery.nicescroll.js" type="text/javascript"></script>
  <script type="text/javascript" language="javascript" src="../assets/lib/advanced-datatable/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="../assets/lib/advanced-datatable/js/DT_bootstrap.js"></script>
  <!--common script for all pages-->
  <script src="../assets/lib/common-scripts.js">
  </script>
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

<?php 
mysqli_close($conn);
?>
</html>