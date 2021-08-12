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
siteTitle(mysite, ' || ', ' Admin'.' || ' . $_SESSION['user']);
   meta();
    pageHeader();
   sideBar();
   
?>
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row mt">
          <div class="col-lg-12">
            <div class="form-panel">
               <div><?php
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
           
         ?>
        </div> 
       
         <?php 
         if ($_GET['id'] && $_GET['id']!='') {
          $studId= gzinflate(base64_decode(strtr($_GET['id'], '-_', '+/')));
            $sql=mysqli_query($conn,"SELECT s.id AS sid, s.surname AS sur, s.othernames AS other, s.dob AS dob, s.gender AS sex,s.address1 AS add1, s.address2 AS add2, s.ailment AS ail, s.ailmentDes AS aildes, s.admDate AS adate, s.admTime AS atime, s.class AS ac, s.school AS ssc,s.studPics AS pics, s.regNum AS reg, sch.id AS schid, sch.name AS schname, sch.motto AS schmo, sch.address AS schad, sch.code AS schco, sch.logo AS schlog, c.id AS cid, c.classCode AS cco, c.name AS cn, sf.currentPayment AS sfam, sf.balance as sfba, sf.paymentMode as sfpm, sf.datePaid as sfdp, sf.payTerm as sfpt, sf.pop as sfpo

                    from students s
                    INNER JOIN class c
                    ON s.class=c.id 
                    
                    INNER JOIN schools sch
                    ON s.school = sch.id
                    INNER JOIN student_fees sf
                    ON s.id=sf.studentId
                    WHERE s.school='$userSchool' and sf.studentId='$studId' and s.id='$studId' and s.id= sf.studentId");
                      if (mysqli_num_rows($sql)) { 
                        while ($row=mysqli_fetch_assoc($sql)) {
                           $schoolName=$row['schname'];
                           $schoolMotto=$row['schmo'];
                           $logo=$row['schlog'];
                           $schoolAddress=$row['schad'];
                           //$admDateTime=$row['adate'].'  '.$row['atime'];
                           $class=$row['cn'];
                           $reg= $row['reg'];
                            $studentName=$row['sur'].' '.$row['other'];
                            //$gender=$row['sex'];
                            //$dob=$row['dob'];
                            //$address1=$row['add1'];
                            //$address2=$row['add2'];
                            //$ailment=$row['ail'];
                            //$ailmentDes=$row['aildes'];
                            //$passport=$row['pics'];
                            //$pname=$row['pfn'].' '.$row['pon'];
                            //$occup=$row['poc'];
                            //$religion=$row['par'];
                            //$whoPay=$row['prel'];
                            $payProof=$row['sfpo'];
                            $amountPaid=$row['sfam'];
                            $balance=$row['sfba'];
                            $payMode=$row['sfpm'];
                            $datePaid=$row['sfdp'];
                            $payTerm=$row['sfpt'];

          
               
        ?> <div class="form-group">
                  <div class="col-md-12">
                     
                    <button onclick="printInvoice();" class="btn btn-primary btn-sm pull-right">Print Receipt&nbsp; </button>
                 
                    
                    <a  data-toggle="modal" class="btn btn-success btn-sm pull-left" href="view-expenses.php#myModal">View Proof of Payment&nbsp; </a><br><br>  
                 </div>                
                </div>

                 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Loading Payment Proof...</h4>
              </div>
              <?php if (!empty($payProof) ) {
                echo '<img style="object-fit: cover;" src="payment_proof/'.$payProof.'" alt="Proof of Payment">';
              }else{echo "Proof of Payment not Found!";} ?>
              
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                <a href="<?php echo 'payment_proof/'.$payProof; ?>" class="btn btn-theme" download>Download</a>
              </div>
            </div>
          </div>
      
          </div>
                

                <style type="text/css">
                  .headerText{
                    text-decoration: underline;
                    font-size: 20px;
                    font-weight: bolder;
                  }
                </style>
                <div id="invoice">
                  <table style=" border: 2px solid black;" class="table">
                    <caption class="text-center" >
                    <img style="width: 100px; height: 100px;" src="<?php echo 'logo/'.$logo; ?>" class="img-circle" alt="School Logo">
                    <p style="font-size: 25px" ><strong><?php echo $schoolName; ?></strong></p>
                    <p><i><strong>Motto:</strong></i><?php echo $schoolMotto; ?></p>
                    <p><?php echo $schoolAddress; ?></p>
                    <h1>SCHOOL FEES RECEIPT</h1>
                  </caption>
                  <tbody>
                   <tr >
                    <td style="padding-left: 50px; "><p><strong class="headerText">Student Name:</strong> <?php echo $studentName; ?></p></td>
                    <td width="30px"></td>
                    <td style="padding-right: 50px" ><p style="text-align: right;"><strong class="headerText">Receipt No:</strong> <?php echo substr(md5($reg), 0,4); ?></p></td>
                    
                  </tr>

                  <tr>
                    <td  style="padding-left: 50px; text-align: left;"><strong class="headerText">Class:</strong> <?php echo $class;  ?></td>
                    <td style="text-align: right;"><strong class="headerText">Admission Number:</strong> <?php echo $reg;  ?></td>
                     
                    <td style="padding-right: 50px; text-align: right;"><strong class="headerText">Payment Mode:</strong> <?php echo $payMode; ?></td>
                    
                  </tr>

                   <tr >
                    <td style="padding-left: 50px; "><p><strong class="headerText">Amount Paid:</strong>&nbsp;&nbsp;<i style="text-decoration: line-through; font-weight: bolder;">N</i> <?php echo  $amountPaid.'.00'; ?></p></td>
                    <td width="30px"></td>
                    <td style="padding-right: 50px" ><p style="text-align: right;"><strong class="headerText">Balance:</strong>&nbsp;&nbsp; <i style="text-decoration: line-through; font-weight: bolder;">N</i> <?php echo  $balance.'.00'; ?></p></td>
                    
                  </tr>

                  <tr>
                    <td style="padding-left: 50px; " colspan="3" style="text-align: left;"><strong class="headerText">Payment Description:</strong> Being the payment of School Fees and Others<?php echo ' for '.$payTerm.' in '.substr($datePaid, 6,-9)  ; ?></td>
                    
                  </tr>
                  <tr>
                    <td style="padding-left: 50px; text-align: left;"><strong class="headerText">Date Paid:</strong> <?php echo substr($datePaid, 0,10);  ?></td>
                    <td width="30px"></td>
                    <td style="padding-right: 50px; text-align: right;"> <strong class="headerText">Time Paid:</strong> <?php echo substr($datePaid, 11,19); ?></td>
                  </tr>
                  <tr ><td colspan="3"></td></tr>
                  <tr><td colspan="3"></td></tr><tr><td colspan="3"></td></tr><tr><td colspan="3"></td></tr>
                  <tr>
                    <style type="text/css">
                      #watermark{
                        position: fixed;
                        bottom: 10px;
                        opacity: 0.5;
                        z-index: 99;
                        color: white;
                      }
                    </style>

                    <div id="watermark">

                    <td colspan="3" style="padding-right: 50px; text-align: center;">
                      Valid if Only Signed and Stamped
                    </td>
                    </td>
                     
                  </tr>
                </tbody>
                </table>

                </div>
                <?php }
              }
              else{
              echo  "error:" . mysqli_error($conn);
            } ?>
              </div>
              <?php
            }
          ?>
            </div>
          </div>
        </section><br><br><br><br><br><br>
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
     
  </script>

</body>

</html>
