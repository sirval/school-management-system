<?php
error_reporting(0);
session_start();
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
        <div class="alert alert-info alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                              </button>
                   Consider Refreshing this page if the passport or logo does not display.
                  </div>
            	
              <div id="invoice" class="invoice-body">
                
                  <?php
          
              if ($_GET['id'] && $_GET['id']!='') {
            $studId= gzinflate(base64_decode(strtr($_GET['id'], '-_', '+/')));

      $query=mysqli_query($conn,"SELECT s.regNum AS reg, s.surname AS sur, s.othernames AS other, s.dob AS dob, s.gender AS sex,s.address AS address, s.ailment AS ail, s.ailmentDes AS aildes, s.admDate AS adate, s.admTime AS atime, s.class AS ac, s.school AS ssc,s.studPics AS pics, c.id AS cid, c.classCode AS cco, c.name AS cn, p.parentFname AS pfn, p.parentOthers AS pon, p.parentOccup AS poc, p.parentReligion AS par, p.numChild AS pnc, p.relationship AS prel, p.phone AS phone1, p.email AS email, p.altPhone AS altPhone, sch.id AS schid, sch.name AS schname, sch.motto AS schmo, sch.address AS schad, sch.code AS schco, sch.logo AS schlog
                    from students s
                    INNER JOIN class c
                    ON s.class=c.id 
                    INNER JOIN parents p
                    ON s.id=p.regNum
                    INNER JOIN schools sch
                    ON s.school = sch.id
                    WHERE s.school='$userSchool' and s.id='$studId'");
                      if (mysqli_num_rows($query)) { 
                        while ($row=mysqli_fetch_assoc($query)) {
                           $schoolName=$row['schname'];
                           $schoolMotto=$row['schmo'];
                           $logo=$row['schlog'];
                           $schoolAddress=$row['schad'];
                           $reg=$row['reg'];
                           $admDateTime=$row['adate'].'  '.$row['atime'];
                           $class=$row['cn'];
                            $studentName=$row['sur'].' '.$row['other'];
                            $gender=$row['sex'];
                            $dob=$row['dob'];
                            $address=$row['address'];
                            
                            $ailment=$row['ail'];
                            $ailmentDes=$row['aildes'];
                            $passport=$row['pics'];
                            $pname=$row['pfn'].' '.$row['pon'];
                            $occup=$row['poc'];
                            $religion=$row['par'];
                            $whoPay=$row['prel'];
                            $phone1=$row['phone1'];
                            $email=$row['email'];
                            $altPhone=$row['altPhone'];
                            

                }}
     		?> 

     			<style type="text/css">
     				.center{
     					text-align: center;
     				}
     				.color{
     					color: #C9302C;
     				}
     				.school_header{
     					line-height: 0;
     				}
     				.section_header{
     					font-size: 20px;
     					font-weight: bolder;
     					text-decoration: underline;
     				}
     			</style>
          <div class="center"  class="school_header">
            <img style="display: block; margin-left: auto; margin-right: auto; width: 120px; height: 120px;" src="<?php echo 'logo/'.$logo; ?>" class="img-circle" alt="School Logo">
            <div style="text-align: center;">
                  <p style="font-size: 20px; font-weight: bolder; " class="center color"><?php echo $schoolName; ?></p>
                  <p class="center"><i><strong>Motto:</strong><?php echo $schoolMotto; ?></i></p>
                  <h4 class="center"><b><?php echo $schoolAddress; ?></b></h4>
                  </div>
             </div>
     			
              	<div>
                  <div class="pull-left">

                <p class="section_header">ADMISSION DETAILS</p>
                <label>Class Admitted: </label> <b><?php echo $class; ?></b><br>
                <label>Admission Number: </label><b> <?php echo $reg; ?></b><br>
                <label>Date/Time Admitted: </label> <b><?php echo strtoupper($admDateTime); ?></b><br>
                             
                </div>
                
               </div>
               <div class="clearfix"></div>
               <img style="float: right; width: 100px; height: 100px; border: 2px solid red" src="<?php echo 'student_passport/'.$passport; ?>"  alt="Passport">
               <div class="pull-left">

                <p class="section_header">PERSONAL DETAILS</p>
                <label>Student Name: </label> <b> <?php echo $studentName; ?></b><br>
                <label>Gender: </label><b> <?php echo $gender; ?></b><br>
                 <label>Date of Birth (DOB): <b></label> <?php echo $dob; ?></b><br>
                <label>Address: </label><b> <?php echo $address; ?></b><br>
                
                <label>Health Challenge: </label> <b><?php echo $ailment; ?></b><br>
                <?php if ($ailment=='No') {
                	echo '                
                <label>Health Challenge Description: </label><b> Nill</b><br>';}else
                {
                	echo '
                <label>Health Challenge Description: </label><b>'.$ailmentDes.'</b><br>';}
                ?>
                
                </div>
                <div class="clearfix"></div>

                <div class="pull-left">
                <p class="section_header">PARENT DETAILS</p>
                <label>Parent Name: </label> <b><?php echo $pname; ?></b><br>
                <label>Parent Occupation: </label> <b><?php echo strtoupper($occup); ?></b><br>
                 <label>Parent Religion: </label> <b><?php echo strtoupper($religion); ?></b><br>
                <label>Relationship: </label> <b><?php echo strtoupper($whoPay); ?></b><br>
                
                <label>Phone Number: </label> <b><?php echo $phone1; ?></b><br>
                 <label>Alternate Phone: <b></label> <?php echo $altPhone
                 ; ?></b><br>
                  <label>Email: </label><b> <?php echo $email; ?></b><br>
                   
                </div>
                <div class="clearfix"></div>
               <p style="font-size: 25px; text-align: center; font-weight: bolder; font-style: italic;">Signed</p>
                <p style="text-align: center;">Management</p>
              </div>
               <div class="pull-right">
            <button class="btn btn-sm btn-info" onclick="printInvoice()">print</button>
            <?php
            $urlEncode = rtrim(strtr(base64_encode(gzdeflate($studId, 9)), '+/','-_'),'=') ; 
            if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 2) {
    echo"";
   } else{
            $query=mysqli_query($conn, "SELECT * FROM student_fees WHERE student_fees.studentId='$studId'");
   if (mysqli_num_rows($query)>0) {
    while ($res=mysqli_fetch_array($query)) {
      $feeId=$res['id'];
    }
    $url_Encode = rtrim(strtr(base64_encode(gzdeflate($feeId, 9)), '+/','-_'),'=') ; 
     echo '<a href="update-payment-details.php?id='.$url_Encode.'" class="btn btn-sm btn-danger">Update Payment</a>';
   }else{
     echo '
     <a href="make-payment.php?id='.$urlEncode.'" class="btn btn-sm btn-danger">Make Payment</a>';
      }}
             ?>
            
           </div>
                <?php } //}}?>  
         <br><br><br><br><br><br><br><br>
      </section>
  </section>

      
    <!-- /MAIN CONTENT -->
   <?php footer();?>
  </section>
  <?php mainJs(); ?>
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
<?php mysqli_close($conn); ?>
</html>