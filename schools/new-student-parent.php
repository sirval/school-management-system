<?php
error_reporting(0);
session_start();
require '../db/db_con.php';
if (isset($_POST['go'])) {
   
  $parentFname = strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['parentFname'])));
  $parentOthers = strtoupper(strip_tags(mysqli_real_escape_string($conn, $_POST['parentOthers'])));
  $relation = strip_tags(mysqli_real_escape_string($conn, $_POST['childRelationship']));
  $parentOccup = strip_tags(mysqli_real_escape_string($conn, $_POST['parentOccup']));
  $parentReligion = strip_tags(mysqli_real_escape_string($conn, $_POST['parentReligion']));
  $phone = strip_tags(mysqli_real_escape_string($conn, $_POST['phone']));
  $altPhone = strip_tags(mysqli_real_escape_string($conn, $_POST['altPhone']));
  $email = strip_tags(mysqli_real_escape_string($conn, $_POST['email']));
  $numChild = strip_tags(mysqli_real_escape_string($conn, $_POST['numChild']));
  $parentApp = strip_tags(mysqli_real_escape_string($conn, $_POST['parentApp']));
  $term = strip_tags(mysqli_real_escape_string($conn, $_POST['term']));

  if (!isset($parentFname) || trim(strlen($parentFname)) =='') {
    header('location: new-student-parent.php?error=31');
    exit();
  }
  if (!isset($term) || trim(strlen($term)) =='') {
    header('location: new-student-parent.php?error=48');
    exit();
  }
  if (!isset($parentOthers) || trim(strlen($parentOthers)) =='') {
    header('location: new-student-parent.php?error=32');
    exit();
  }
  if (preg_match('/^[0-9]{11}+$/', $phone)== false) {
   header('location: new-student-parent.php?error=33');
    exit();
  }
   if (!isset($relation) || trim(strlen($relation)) =='') {
    header('location: new-student-parent.php?error=34');
    exit();
  } 
  if (!isset($parentApp) || trim(strlen($parentApp)) =='') {
    header('location: new-student-parent.php?error=35');
    exit();
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      header('location: new-student-parent.php?error=36');
    exit();
  }
  if (!empty($parentFname) && !empty($parentOthers) && !empty($phone) && !empty($relation) && !empty($parentApp) && !empty($email))
{

  session_regenerate_id();
        $_SESSION['parentFname'] = $parentFname;
        $_SESSION['parentOthers'] = $parentOthers;
        $_SESSION['phone'] = $phone;
        $_SESSION['altPhone'] = $altPhone;
        $_SESSION['relation'] = $relation;
        $_SESSION['parentApp'] = $parentApp;
        $_SESSION['email'] = $email;
        $_SESSION['numChild'] = $numChild;
        $_SESSION['parentOccup'] = $parentOccup;
        $_SESSION['parentReligion'] = $parentReligion;
        $_SESSION['notiTerm'] = $term;
    if (!empty($_SESSION['parentFname']) && !empty($_SESSION['parentOthers']) && !empty($_SESSION['phone']) && !empty($_SESSION['relation']) && !empty($_SESSION['parentApp']) && !empty($_SESSION['email'])) 
      {
        $url= base64_encode($_SESSION['regNum']);
         header("location: new-student-verify.php?userDetail=".$url);
         session_write_close();
      }
}
else
{
  header('location: new-student-profile.php?error=8');
    exit();
}

}


if (isset($_GET['error']) && $_GET['error'] !=='') {
    $errmsg = $_GET['error'];
    $msgerror ='';
    $msgsucc = '';
   
    if($errmsg =='31'){
        $msgerror ='Warning: Parent First required! ';
    }
    elseif($errmsg =='32'){
        $msgerror ='Warning: Parent Othernames are required! ';
    }
    elseif($errmsg =='33'){
        $msgerror ='Warning: Parent Phone Number required! And must be exactly 11 digits';
    }
    elseif($errmsg =='34'){
        $msgerror ='Warning: The Relationship between both are required';
    }
    elseif($errmsg =='35'){
        $msgerror ='Warning: Please select if you would like to activate our parent App';
    }
    elseif($errmsg =='36'){
        $msgerror ='Warning: Valid Email Required';
    }
    elseif($errmsg =='48'){
        $msgerror ='Warning: Enter the term for Notification';
    }
    elseif($errmsg =='8'){
        $msgerror ='Error: A fatal error occured while trying to process your request! If this error persists, contact admin for guidelines';
    }
    elseif($errmsg == '40') {
      $msgerror ='Warning: You cannot proceed right now! Because it seems like we have lost the initial value you entered. Kindly refill this form and proceed. if this error persist, please contact admin for guidelines.';
    }
    
}

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
   if (isset($_SESSION['regNum'])  && isset($_GET['userDetail']) && $_GET['userDetail'] != '')
      {
        $reg = base64_decode($_GET['userDetail']);
        if ($reg == $_SESSION['regNum']) 
        {
          $regNum = $_SESSION['regNum'];
        }
      }
      else
      {
        header('location:new-student-profile.php?error=40');
      }
    
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
        <div>
          
        </div>
        
              <div class="progress progress-striped active">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                  
                </div>
               <span class="">3 Of 4 steps Complete</span>
            </div>
            <br><br>
            <p class="pull-right">[<i style="color: red; font-weight: bolder; font-size: 20px">*</i> indicates required values]</p>        
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">


                <h3><span class="label label-primary label-mini"><i class="fa fa-users" ></i> Parents'/Guidians' Data</span></h3><br><br>
                <!--start of parents Div-->
                <div class="form-group">
                  <label class="control-label col-sm-1">Firstname<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-5">
                    <input class="form-control form-control-inline input-medium " name="parentFname" type="text" required="" > <br> 
                    
                  </div>
                  <label class="control-label col-sm-1" >Othernames<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-5 ">
                    <input class="form-control form-control-inline input-medium " name="parentOthers" type="text" required=""><br>  
                    
                  </div>
                   
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-1">Relationship<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-5">
                    <select required="" class="form-control form-control-inline input-medium " name="childRelationship" >
                      <option value="">--Select Relationship--</option>
                      <option value="Parent">Parent</option>
                      <option value="Guidian">Guidian</option>
                      <option value="Relative">Relative</option>
                      
                    </select>                  
                 
                  </div>

                    <label class="control-label col-sm-1">Occupation</label>
                  <div class="col-md-5">
                    <input class="form-control form-control-inline input-medium "  name="parentOccup" type="text"><br>  
                    
                  </div>
              </div>

              <div class="form-group">

                  <label class="control-label col-sm-1">Religion</label>
                  <div class="col-md-5">
                    <input class="form-control form-control-inline input-medium " name="parentReligion" type="text"><br>  
                    
                  </div> 

                <label class="control-label col-sm-3">Number of Child in our School</label>
                  <div class="col-md-3">
                    <select class="form-control form-control-inline input-medium " name="numChild">
                       <option >--Select Number of Child--</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select> <br>
                  </div> 
                

                </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Phone Number<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4">
                  <input type="tel" required="" class="form-control form-control-inline input-medium" name="phone"  onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57">
                                                 
                    
                  </div>

                <label class="control-label col-sm-2">Alternate Phone</label>
                  <div class="col-md-4">
                  <input type="tel" class="form-control form-control-inline input-medium" name="altPhone"  onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57">
                                                 
                    
                  </div>
                  
                  
              </div>

              
                 <div class="form-group">
                  <label class="control-label col-sm-1">Email<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-2">
                  <input required="" type="email" class="form-control form-control-inline input-medium" name="email"  >
                     </div>                            
                    <label class="control-label col-sm-3">Would you like to be notified about your child?<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-2">
                  <select required="" class="form-control form-control-inline" name="parentApp">
                    <option value="">--Select Option--</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                  </select>         
                </div>
                <label class="control-label col-sm-2">Notification Term:<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                <div class="col-md-2">
                    <select class="form-control form-control-inline input-medium "  name="term" id="term" required="">
                      <option>--Select Term--</option>
                      <?php 
                      require '../db/db_con.php';
                        $sql=mysqli_query($conn,"SELECT * from term");
                      if (mysqli_num_rows($sql)>0 ) {           
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['termName']; }}else{echo "NO AVAILABLE TERM FOUND";}?></option>
                    </select><br>  
                     
                  </div> 
              </div>

                <div class="form-group">
                  <div class="col-md-6">
                 <a  data-toggle="modal" class="btn btn-danger btn-sm pull-left" href="new-student-parent.php#back">&nbsp;<i class="fa fa-arrow-left"></i> Previous </a><br><br>  
                 </div>
                 
                  <div class="col-md-6">
                 <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="new-student-parent.php#myModal">Next&nbsp;<i class="fa fa-arrow-right"></i> </a><br><br>  
                 </div>                
                </div>
                <div class="form-group"></div>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="back" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm!</h4>
              </div>
              <p style="font-size: 20px;">Are you sure you want to go back?</p>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                <a href="<?php echo 'new-student-profile.php?userDetail='.base64_encode($regNum); ?>" class="btn btn-theme" >Yes</a>
              </div>
            </div>
          </div>
        </div>

                 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm Registration!</h4>
              </div>
              <p style="font-size: 20px;">Are you sure you want to proceed?</p>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                <button class="btn btn-theme" type="submit" name="go">Yes</button>
              </div>
            </div>
          </div>
        </div>
                 </div>                
                </div>
                
               
              </form>
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
  	function description() {
  		var x=document.getElementById('des');
  		if (x.style.display==='none') {
  			x.style.display='block';
  		}else{
  			x.style.display='none';
  		}
  	}
  
function checkAvailability() {
  $("#loaderIcon").show();
  jQuery.ajax({
    url: "checkAvailability.php",
    data: 'regNum='+$("#regNum").val(),
    type: "POST",
    success:function (data) {
      $("#userAvailability-status").html(data);
      $("#loaderIcon").hide();
    },
    error:function () {
      
    }
  });
}
  
  </script>

</body>
<?php
mysqli_close($conn);
?>
</html>
