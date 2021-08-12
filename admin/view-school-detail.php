<?php
error_reporting(0);
require '../db/db_con.php';

require '../controller/admin_required.php'; 
 
$userId=$_SESSION['usersn'];
siteTitle(mysite, ' || ', ' Super Admin'.' || ' . $_SESSION['username']);
 //$pagename='new-school';
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
     $reg=$_GET['id'];

                  $sql=mysqli_query($conn,"SELECT s.id AS si, s.name as sn,s.motto as sm,s.address as sa,s.code as sc, s.logo as sl, u.id as ui, u.username as uu, u.password as up,u.schoolId as us, et.endDate as ete, et.schoolId as ets, et.startDate as etsd
                    FROM 
                    schools s 
                    INNER JOIN users u
                    ON s.id=u.schoolId
                    INNER JOIN elapse_time et
                    ON s.id=et.schoolId
                    WHERE u.roleId=1
                    ");
                      
                       while($row = mysqli_fetch_array($sql)){
                        $schoolName=$row['sn'];
                        $schoolAddress=$row['sa'];
                        $schoolMotto=$row['sm'];
                        $code=$row['sc'];
                        $logo=$row['sl'];
                        $username=$row['uu'];
                        $password=$row['up'];
                        
                        $id=$row['si'];
                      }
                        ?>
                        
                <div id="invoice">
                  <table style="width: 100%; padding: 100px; margin-top: 50px" class="table">
                    <caption class="text-center" >
                    <img style="width: 100px; height: 100px;" src="../schools/logo/<?php echo $logo; ?>"  alt="School Logo">
                    <p style="font-size: 25px" ><strong><?php echo $schoolName; ?></strong></p>
                    <p><i><strong>Motto:</strong></i><?php echo $schoolMotto; ?></p>
                    <p><?php echo $schoolAddress; ?></p>
                    <h2>REGISTERED SCHOOL DETAIL</h2>
                  </caption>
                  <tbody>
                   <tr >
                    <td style="text-align: left;" colspan="2"><p><strong>School Main Admin: </strong><?php echo $username; ?></p></td><td style="text-align: right;"><strong>Password: </strong><?php echo $password; ?></td>
                  </tr>
                  <?php
                  $sql=mysqli_query($conn,"SELECT s.id AS si, s.name as sn,s.motto as sm,s.address as sa,s.code as sc, s.logo as sl, u.id as ui, u.username as uu, u.password as up,u.schoolId as us, et.endDate as ete, et.schoolId as ets, et.startDate as etsd
                    FROM 
                    schools s 
                    INNER JOIN users u
                    ON s.id=u.schoolId
                    INNER JOIN elapse_time et
                    ON s.id=et.schoolId
                    WHERE u.roleId=2
                    ");
                      
                       while($row = mysqli_fetch_array($sql)){
                        
                        $username1=$row['uu'];
                        $password1=$row['up'];
                        $startDate=$row['etsd'];
                        $endDate=$row['ete'];
                        $id=$row['si'];
                      }
                        ?>
                   <td style="text-align: left;" colspan="2"><p><strong>Clerk username: </strong><?php echo $username1; ?></p></td><td style="text-align: right;"><strong>Clerk Password: </strong><?php echo $password1; ?></td>
                  </tr>
                  <?php
                  $sql=mysqli_query($conn,"SELECT s.id AS si, s.name as sn,s.motto as sm,s.address as sa,s.code as sc, s.logo as sl, u.id as ui, u.username as uu, u.password as up,u.schoolId as us, et.endDate as ete, et.schoolId as ets, et.startDate as etsd
                    FROM 
                    schools s 
                    INNER JOIN users u
                    ON s.id=u.schoolId
                    INNER JOIN elapse_time et
                    ON s.id=et.schoolId
                    WHERE u.roleId=3
                    ");
                      
                       while($row = mysqli_fetch_array($sql)){
                        
                        $username2=$row['uu'];
                        $password2=$row['up'];
                        $startDate=$row['etsd'];
                        $endDate=$row['ete'];
                        $id=$row['si'];
                      }}
                        ?>
                   <td style="text-align: left;" colspan="2"><p><strong>Other Staff username: </strong><?php echo $username2; ?></p></td><td style="text-align: right;"><strong>Other Staff Password: </strong><?php echo $password2; ?></td>
                  </tr>
                 
                  <tr>
                    <td style="text-align: left;" colspan="2"><strong>Date Installed: </strong><?php echo $startDate; ?></td>
                    <td style="text-align: right;"> <strong>Upgrade Needed: </strong><?php echo $endDate; ?></td>
                  </tr>
                  <tr>
                    <td style="text-align: center;" colspan="3"> <strong>POWERED BY SMARTSCHOOLS</strong></td>
                  </tr>
                     
                  </tr>
                </tbody>
                </table>

                </div>
               
                        <div class="form-group">
                  <div class="col-md-12">
                    <button onclick="printInvoice();" class="btn btn-primary btn-sm pull-right">Print Receipt&nbsp;<i class="fa fa-arrow-right"></i> </button><br><br>  
                 </div>                
                </div>
              </div>
              
            </div>
          </div>
        </section><br><br><br><br><br><br>
         <?php footer();?>
    
      </section>
    
 <!-- js placed at the end of the document so the pages load faster -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="lib/jquery.scrollTo.min.js"></script>
  <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
  <!--common script for all pages-->
  <script src="lib/common-scripts.js"></script>
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
