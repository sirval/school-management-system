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
   $sql=mysqli_query($conn, "SELECT * FROM schools where id='$userSchool'");
   while ($row=mysqli_fetch_array($sql)) {
     $schoolName=$row['name'];
   }
?>
    
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
       
        <div class="row mt">
          <!--  DATE PICKERS -->
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
        <div>
          <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                </button>
                  <p><span class="label label-info">NOTE!</span> To find expenses, select expenses date and term of expenses</p>
            </div>
        </div>
        
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                
                <div class="form-group ">
                   <label class="control-label col-sm-1">Expenses Date:</label>
                 <div class="col-md-3 col-xs-11">
                    <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="24-08-2020" class="input-append date dpYears">
                      <input type="text" readonly="" name="day" size="16" class="form-control">
                      <span class="input-group-btn add-on">
                        <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                  </div>

                  
                  <label class="control-label col-sm-1"></label>
                  <div class="col-md-2">
                    <select class="form-control form-control-inline " name="year" id="year">
                      <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                      
                    </select>
                  </div>
                 <label class="control-label col-sm-1">Payment Term</label>
                  <div class="col-md-3 col-xs-11">
                    <div class="input-append">
                    <select class="form-control form-control-inline " name="term" id="term">
                      <option value="nil">--Select Payment Term--</option>
                      <?php 
                    $sql=mysqli_query($conn,"SELECT * from term");
                      if (mysqli_num_rows($sql)>0 ) {           
               
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['termName']; }}?></option>
                    </select>
                    <span class="input-group-btn add-on">
                        <button class="btn btn-theme" name="searchExp" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                  </div>

              </div>
          </form>
          <div>
            <div class="form-group">
                  <div class="col-md-12">
                    <a href="all-expenses.php"  class="btn btn-success btn-sm"><i class="fa fa-eye"> </i> View All Expenses</a>
                    <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="view-expenses.php#myModal">Print Document&nbsp;</a><br><br>  
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
                <button class="btn btn-theme" type="submit" onclick="printDoc()" >Yes</button>
              </div>
            </div>
          </div>
        </div>
          </div>
          <div id="expenses">
          <table class="table table-hover">
              <div class="text-center ">
                <h4><i class="fa fa-institution"></i>DAILY EXPENSES  </h4>
                </div>
                <hr>
                <thead>
                  <tr>
                    <th>Term</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Cost</th>
                    <th>Total Cost</th>
                    <th>Authorised By</th>
                    <th>Purchased By</th>
                  </tr>
                </thead>
                <tbody>
          <?php
          if (isset($_POST['searchExp'])) {
            $day = strip_tags(mysqli_real_escape_string($conn, $_POST['day']));           
            $year = strip_tags(mysqli_real_escape_string($conn, $_POST['year']));
            $term = strip_tags(mysqli_real_escape_string($conn, $_POST['term']));
            if (!isset($day) || trim(strtoupper(strlen($day)) =='')) {
             echo "<script>alert('Select the date expenses was made');";
             exit();
            }
            if (!isset($year) || trim(strtoupper(strlen($year))=='')) {
               echo "<script>alert('Year of expenses cannot be empty');";
             exit();
            }
             if (!isset($term) || trim(strtoupper(strlen($term)) =='')) {
              echo "<script>alert('Select the term expenses was made');";
             exit();
             
            }

            $query=mysqli_query($conn, "SELECT * FROM
              expenses ex
              INNER JOIN term t
                        ON t.id=ex.termId
                WHERE ex.termId='$term' and substr(ex.date, 1,10)='$day' ");
            if (mysqli_num_rows($query)) {
              while ($result=mysqli_fetch_array($query)) {
               $date=$result['date'];
               $time= $result['time'];
               $term=$result['termName'];
               //$school=$result['name'];
               $product=$result['product'];
               $qty=$result['qty'];
               $price=$result['price'];
               $total=$result['totalCost'];
               $authBy=$result['authBy'];
               $purBy=$result['purBy'];
               echo'
         
              
                  <tr>
                    <td>'.$term.'</td>
                    <td>'.$date.'</td>
                    <td>'.$time.'</td>
                    <td>'.$product.'</td>
                    <td>'.$qty.'</td>
                    <td>'.$price.'</td>
                    <td>'.$total.'</td>
                    <td>'.$authBy.'</td>
                    <td>'.$purBy.'</td>
                  </tr>';}?>
                  
                </tbody>
              </table>
            </div>
            
          <!-- /col-md-12 -->
                
                 <div class="form-group"><br><br></div>
               
              </form><?php
            
          }else{
            echo '
          <div style="display: none;">
          
            </div>';}}?>
        </div>
            <!-- /form-panel -->
          </div>
          <!-- /col-lg-12 -->
        </div>
        <!-- /row -->     
      
      </section>
     
    </section>
    
    <?php footer();?>
    <!--footer end-->
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

</body>

</html>
