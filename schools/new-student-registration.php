<?php
//error_reporting(0);
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
   if (isset($_GET['reg-successful']) && $_GET['reg-successful'] != '')
      {
        $reg = base64_decode($_GET['reg-successful']);
        $getStudent = mysqli_query($conn,"SELECT st.id AS sId, st.surname AS surname, st.othernames AS othernames, st.studPics AS studPics, sch.name AS name, sch.motto AS motto, sch.address AS address, sch.logo AS logo FROM students st, schools sch WHERE st.regNum ='$reg' and sch.id='$schoolId' and st.school=sch.id");
        if (mysqli_num_rows($getStudent)>0) 
        {
        	while ($studData = mysqli_fetch_array($getStudent)) 
        	{
        		$studName = $studData['surname'].' '.$studData['othernames'];
        		$id = $studData['sId'];
        		$passport= $studData['studPics'];
        		$schoolName = $studData['name'];
        		$motto = $studData['motto'];
        		$address = $studData['address'];
        		$logo=$studData['logo'];


        	}
        }
        else
        {
        	echo "string".mysqli_error($conn);
        }
      }
      else
      {
        header('location:new-student.php?error=40');
      }
    
   ?>
    
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
       
        <div class="row mt">
         
          <div class="col-lg-12">
            <div class="form-panel">
            	 
               <div><?php
                  if (isset($_GET['$userinfor']) && $_GET['$userinfor'] !='') {
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
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                  
                </div>
                
            </div>
            <p class="pull-right" style="color: green; font-weight: bolder;">Completed 100%</p>
            
            <div class="center"  class="school_header">
     			  <img style="display: block; margin-left: auto; margin-right: auto; width: 120px; height: 120px;" src="<?php echo 'logo/'.$logo; ?>" class="img-circle" alt="School Logo">
     			  <div style="text-align: center;">
                  <p style="font-size: 20px; font-weight: bolder; " class="center color"><?php echo $schoolName; ?></p>
                  <p class="center"><i><strong>Motto:</strong><?php echo $motto; ?></i></p>
                  <h4 class="center"><b><?php echo $address; ?></b></h4>
              		</div>
             </div>
            
              
              	<div style="display: block; margin-left: auto; margin-right: auto; width: 120px; height: 120px;">
              		
              	 <img style="display: block; margin-left: auto; margin-right: auto; width: 120px; height: 120px;"  src="<?php echo 'student_passport/'.$passport; ?>" class="" alt="passport">
              	 <h5 style="color: green; font-weight: bolder; display: block; margin-left: auto; margin-right: auto; width: 120px; height: 120px;"> <?php echo $studName;?></h5>

              	</div><br><br>
              	<h4>Congratulations <?php echo $studName; ?> you have been registered successfully with Admission Number: <?php echo $reg; ?> </h4>
 <div class="form-group">
                  <div class="col-md-6">
                 <a  data-toggle="modal" class="btn btn-danger btn-sm pull-left" href="new-student-registration.php#back">&nbsp;<i class="fa fa-arrow-left"></i> Register Another Student </a>  
                 </div>
                  <div class="col-md-6">
                 <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="new-student-registration.php#myModal">View Admission Slip &nbsp;<i class="fa fa-arrow-right"></i> </a> 
                 </div>                
                </div>
                <div class="form-group"></div>

                 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm!</h4>
              </div>
              <p style="font-size: 20px;">Are you sure you want to proceed?</p>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>

               <a href="<?php $urlEncode = rtrim(strtr(base64_encode(gzdeflate($id, 9)), '+/','-_'),'='); echo 'admission-slip.php?id='.$urlEncode;?>" class="btn btn-theme" >Yes</a>
              </div>
            </div>
          </div>
        </div>

         <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="back" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-size: 25px">Confirm!</h4>
              </div>
              <p style="font-size: 20px;">Are you sure you want to leave this page?</p>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                <a href="<?php echo 'new-student.php';?>" class="btn btn-theme" >Yes</a>
              </div>
            </div>
          </div>
        </div>
              	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
              	
              		

              		
              	
                
                 </div>                
                </div>
                
               
              
            </div>
            <br>
               
      
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
      $("#next").removeAttr("disabled");
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
