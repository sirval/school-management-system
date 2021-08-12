<?php
require '../db/db_con.php';

  if (isset($_POST['save'])) {
    $pin1=strip_tags(mysqli_real_escape_string($conn, $_POST['pin1']));
    $date1=strip_tags(mysqli_real_escape_string($conn, $_POST['date1']));
    $pin2=strip_tags(mysqli_real_escape_string($conn, $_POST['pin2']));
    $date2=strip_tags(mysqli_real_escape_string($conn, $_POST['date2']));
    $pin3=strip_tags(mysqli_real_escape_string($conn, $_POST['pin3']));
    $date3=strip_tags(mysqli_real_escape_string($conn, $_POST['date3']));
    $pin4=strip_tags(mysqli_real_escape_string($conn, $_POST['pin4']));
    $date4=strip_tags(mysqli_real_escape_string($conn, $_POST['date4']));
    $pin5=strip_tags(mysqli_real_escape_string($conn, $_POST['pin5']));
    $date5=strip_tags(mysqli_real_escape_string($conn, $_POST['date5']));
    $pin6=strip_tags(mysqli_real_escape_string($conn, $_POST['pin6']));
    $date6=strip_tags(mysqli_real_escape_string($conn, $_POST['date6']));
    $pin7=strip_tags(mysqli_real_escape_string($conn, $_POST['pin7']));
    $date7=strip_tags(mysqli_real_escape_string($conn, $_POST['date7']));
    $pin8=strip_tags(mysqli_real_escape_string($conn, $_POST['pin8']));
    $date8=strip_tags(mysqli_real_escape_string($conn, $_POST['date8']));
    $pin9=strip_tags(mysqli_real_escape_string($conn, $_POST['pin9']));
    $date9=strip_tags(mysqli_real_escape_string($conn, $_POST['date9']));
    $pin10=strip_tags(mysqli_real_escape_string($conn, $_POST['pin10']));
    $date10=strip_tags(mysqli_real_escape_string($conn, $_POST['date10']));
    $pin11=strip_tags(mysqli_real_escape_string($conn, $_POST['pin11']));
    $date11=strip_tags(mysqli_real_escape_string($conn, $_POST['date11']));
    $pin12=strip_tags(mysqli_real_escape_string($conn, $_POST['pin12']));
    $date12=strip_tags(mysqli_real_escape_string($conn, $_POST['date12']));
    $pin13=strip_tags(mysqli_real_escape_string($conn, $_POST['pin13']));
    $date13=strip_tags(mysqli_real_escape_string($conn, $_POST['date13']));
    $pin14=strip_tags(mysqli_real_escape_string($conn, $_POST['pin14']));
    $date14=strip_tags(mysqli_real_escape_string($conn, $_POST['date14']));
    $pin15=strip_tags(mysqli_real_escape_string($conn, $_POST['pin15']));
    $date15=strip_tags(mysqli_real_escape_string($conn, $_POST['date15']));
    $pin16=strip_tags(mysqli_real_escape_string($conn, $_POST['pin16']));
    $date16=strip_tags(mysqli_real_escape_string($conn, $_POST['date16']));
    $pin17=strip_tags(mysqli_real_escape_string($conn, $_POST['pin17']));
    $date17=strip_tags(mysqli_real_escape_string($conn, $_POST['date17']));
    $pin18=strip_tags(mysqli_real_escape_string($conn, $_POST['pin18']));
    $date18=strip_tags(mysqli_real_escape_string($conn, $_POST['date18']));
    $pin19=strip_tags(mysqli_real_escape_string($conn, $_POST['pin19']));
    $date19=strip_tags(mysqli_real_escape_string($conn, $_POST['date19']));
    $pin20=strip_tags(mysqli_real_escape_string($conn, $_POST['pin20']));
    $date20=strip_tags(mysqli_real_escape_string($conn, $_POST['date20']));

        
    $auth=mysqli_query($conn, "SELECT * FROM pin WHERE pin='$pin1' or pin='$pin2' or pin='$pin3' or pin='$pin4' or pin='$pin5' or pin='$pin6' or pin='$pin7' or pin='$pin8' or pin='$pin9' or pin='$pin10' or pin='$pin11' or pin='$pin12' or pin='$pin13' or pin='$pin14'  or pin='$pin15' or pin='$pin16' or pin='$pin17' or pin='$pin18' or pin='$pin19' or pin='$pin20'");
    if (mysqli_num_rows($auth)>0) {
       echo "<script>alert('PIN already exists');</script>";
    exit();
    }

    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin1','0','$date1')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin2','0','$date2')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin3','0','$date3')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin4','0','$date4')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin5','0','$date5')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin6','0','$date6')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin7','0','$date7')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin8','0','$date8')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin9','0','$date9')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin10','0','$date10')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin11','0','$date11')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin12','0','$date12')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin13','0','$date13')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin14','0','$date14')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin15','0','$date15')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin16','0','$date16')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin17','0','$date17')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin18','0','$date18')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin19','0','$date19')");
    $query=mysqli_query($conn, "INSERT INTO `pin`( `pin`, `validity`, `genDate`) VALUES ('$pin20','0','$date20')");
  if (mysqli_affected_rows($conn)>0) {
    echo "<script>alert('PIN Successfully Saved');
    window.location.href='pin-generator.php';
    </script>";
  }
  else{
     echo "<script>alert('An error occured while trying to save PIN');
     window.location.href='pin-generator.php';
     </script>";
    exit();
  }
      }     

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
       
        <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
              </button>
                Welcome to PIN generator! This platform generates 20 different 10 digit pins at a go on form load
          </div>
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
              
                <div class="form-group">
                 	<div class="col-md-6">
                    
                 <a  data-toggle="modal" class="btn btn-primary btn-sm " href="pin-generator.php#myModal">Click Here to Save Generated PINs &nbsp;<i class="fa fa-save"></i> </a> 
                 </div> 
                 <div class="col-md-6">
                    
                 <a class="btn btn-danger btn-sm pull-right" href="pin-view-all.php">Click Here to View Generated PINs &nbsp;<i class="fa fa-eye"></i> </a><br><br>  
                 </div>                
                </div>
                 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm PIN Saving!</h4>
              </div>
              <p style="font-size: 20px;">Are you sure you want to save PIN?</p>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                <button class="btn btn-theme" type="submit" name="save">Yes</button>
              </div>
            </div>
          </div>
        </div>
        
                
                  <div id="pinGen">
                  
                    <div class="form-group">
                 
              <div  class="adv-table padTable">
              <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>S/N</th>
                    <th>PIN</th>
                    <th>Time</th>
                   
                  </tr>
                </thead>
                <tbody>
                  <?php //pin 1 ?>
                  <tr>
                    <td>
                      1
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin1" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date1" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>
                  <?php //pin 2 ?>
                  <tr>
                    <td>
                      2
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin2" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date2" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                  <?php //pin 3 ?>
                  <tr>
                    <td>
                      3
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin3" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date3" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                  <?php //pin 4 ?>
                  <tr>
                    <td>
                      4
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin4" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date4" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                   <?php //pin 5 ?>
                  <tr>
                    <td>
                      5
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin5" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date5" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                   <?php //pin 6 ?>
                  <tr>
                    <td>
                      6
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin6" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date6" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                   <?php //pin 7 ?>
                  <tr>
                    <td>
                      7
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin7" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date7" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                   <?php //pin 8 ?>
                  <tr>
                    <td>
                      8
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin8" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date8" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                   <?php //pin 9 ?>
                  <tr>
                    <td>
                      9
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin9" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date9" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                   <?php //pin 10 ?>
                  <tr>
                    <td>
                      10
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin10" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date10" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                  <?php //pin 11 ?>
                  <tr>
                    <td>
                      11
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin11" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date11" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>
                  <?php //pin 12 ?>
                  <tr>
                    <td>
                      12
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin12" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date12" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                  <?php //pin 13 ?>
                  <tr>
                    <td>
                      13
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin13" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date13" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                  <?php //pin 14 ?>
                  <tr>
                    <td>
                      14
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin14" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date14" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                   <?php //pin 15 ?>
                  <tr>
                    <td>
                      15
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin15" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date15" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                   <?php //pin 16 ?>
                  <tr>
                    <td>
                      16
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin16" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date16" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                   <?php //pin 17 ?>
                  <tr>
                    <td>
                      17
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin17" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date17" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                   <?php //pin 18 ?>
                  <tr>
                    <td>
                      18
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin18" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date18" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                   <?php //pin 19 ?>
                  <tr>
                    <td>
                      19
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin19" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date19" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                   <?php //pin 20 ?>
                  <tr>
                    <td>
                      20
                    </td>
                    <td>
                      <input class="form-control input-medium " name="pin20" id="pin" type="text" value="<?php echo mt_rand(0, 99999999999);?>" > 
                    </td>
                    <td>
                      <input type="text" class="form-control input-medium " name="date20" value="<?php echo(date('d-m-yy h:i:s A')); ?>">
                    </td>
                  </tr>

                  <tr>
                    <td colspan="3">
                      
                    </td>
                  </tr>
                </tbody>
              </table>

                  
                </div>
                
              </form>
            </div>
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

   <!-- js placed at the end of the document so the pages load faster -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="lib/jquery.scrollTo.min.js"></script>
  <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
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
  <script src="lib/jquery-ui-1.9.2.custom.min.js"></script>
  
  <script src="lib/advanced-form-components.js"></script>
<script type="text/javascript">

</script>
</body>
</html>
<?php
mysqli_close($conn);
?>
