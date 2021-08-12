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
  $studId = strip_tags(mysqli_real_escape_string($conn, $_POST['studId']));
  $term = strip_tags(mysqli_real_escape_string($conn, $_POST['term']));
  $urlEncode = rtrim(strtr(base64_encode(gzdeflate($studId, 9)), '+/','-_'),'=') ;

  if (!isset($parentFname) || trim(strlen($parentFname)) =='') {
    echo "<script>alert('Warning:Parent or Guidian Firstname is required');
    
   </script>";
   header("location: update-student-parents.php?id=".$urlEncode."");
  
  }
  if (!isset($term) || trim(strlen($term)) =='') {
    echo "<script>alert('Warning:Notification Activation term is required');
    
   </script>";
   header("location: update-student-parents.php?id=".$urlEncode."");
  
  }
  if (!isset($parentOthers) || trim(strlen($parentOthers)) =='') {
     echo "<script>alert('Warning:Parent or Guidian Lastname is required');
    
   </script>";
   header("location: update-student-parents.php?id=".$urlEncode."");
  
  }
  if (preg_match('/^[0-9]{11}+$/', $phone)== false) {
   echo "<script>alert('Warning:Parent or Guidian Phone Number is required. And must be 11 digits');
    
   </script>";
   header("location: update-student-parents.php?id=".$urlEncode."");
  
  }
   if (!isset($relation) || trim(strlen($relation)) =='') {
    echo "<script>alert('Warning:Parent or Guidian Relationship is required');
    
   </script>";
   header("location: update-student-parents.php?id=".$urlEncode."");
  
  } 
  
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "<script>alert('Warning:Parent or Guidian Email Address is required');
    
   </script>";
   header("location: update-student-parents.php?id=".$urlEncode."");
  
  }

  if (!empty($studId)) 
  {
  	//check if student Id exists in parent table
  	$getStudId=mysqli_query($conn, "SELECT * FROM parents WHERE regNum='$studId'");
    if (mysqli_num_rows($getStudId) > 0)
    {
     
    $update = mysqli_query($conn, "UPDATE `parents` SET `parentFname`='$parentFname',`parentOthers`='$parentOthers',`parentOccup`='$parentOccup',`parentReligion`='$parentReligion',`numChild`='$numChild',`relationship`='$relation',`phone`='$phone',`altPhone`='$altPhone',`email`='$email',`appActivation`='$parentApp', `term`='$term' WHERE `regNum`='$studId'");
    if (mysqli_affected_rows($conn)>0) 
    {
       echo "<script>alert('Students Parent Information Updated Successfully');
        window.location.href='update-student-parents.php?id=".$urlEncode."'
   </script>";
    }
    else
    {
      echo "<script>alert('An error occured while trying to process your request. Please try again later.');
       
        window.location.href='view-admitted-students.php';
       
   </script>";
    }
    
  }
  else
  {

$insert=mysqli_query($conn, "INSERT INTO `parents`(`parentFname`, `parentOthers`, `parentOccup`, `parentReligion`, `numChild`, `relationship`, `phone`, `altPhone`, `email`, `appActivation`, `term` ,`regNum`) VALUES ('$parentFname','$parentOthers','$parentOccup','$parentReligion','$numChild','$relation','$phone','$altPhone','$email','$parentApp','$term','$studId')");

if (mysqli_affected_rows($conn)>0) 
{
	echo "<script>alert('Students Parent Information Added Successfully');
        window.location.href='update-student-parents.php?id=".$urlEncode."'
   </script>";
 }
    else
    {
      echo "<script>alert('An error occured while trying to process your request. Please try again later.');
       
        window.location.href='view-admitted-students.php';
       
   </script>";
    }
}
}
else
      {
        echo "<script>alert('Error: Your request could not be processed. This might be as a result of invalid parameters');</script>";
        header("location: update-student-parents.php?id=".$urlEncode."");
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
   if ($_GET['id'] && $_GET['id']!='') {
     $studId= gzinflate(base64_decode(strtr($_GET['id'], '-_', '+/')));

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
        
      $sql=mysqli_query($conn,"SELECT  p.parentFname AS pfn, p.parentOthers AS pon, p.parentOccup AS poc, p.parentReligion AS par, p.numChild AS pnc, p.relationship AS prel, p.phone AS phone1, p.email AS email, p.altPhone AS altPhone, p.appActivation AS act, p.term As term
                    from students s
                    INNER JOIN class c
                    ON s.class=c.id 
                    INNER JOIN parents p
                    ON s.id=p.regNum
                    INNER JOIN schools sch
                    ON s.school = sch.id
                    WHERE s.school='$userSchool' and s.id='$studId'");
                      if (mysqli_num_rows($sql)) { 
                        while ($row=mysqli_fetch_assoc($sql)) {
                           
                          
                            $pfname=$row['pfn'];
                            $plname=$row['pon'];
                            $occup=$row['poc'];
                            $religion=$row['par'];
                            $relationship=$row['prel'];
                            $numChild=$row['pnc'];
                            $phone1=$row['phone1'];
                            $altPhone=$row['altPhone'];
                            $email=$row['email'];
                            $activate = $row['act'];
                            $term = $row['term'];
                            

                }
             
            }

               
        ?> 
        </div> 
        <div>
          
        </div>

        
             

            <p class="pull-right">[<i style="color: red; font-weight: bolder; font-size: 20px">*</i> indicates required values]</p>        
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="form-horizontal style-form" enctype="multipart/form-data">
              	 <input type="hidden" name="studId" value="<?php echo $studId; ?>">
                  
                <h3><span class="label label-primary label-mini"><i class="fa fa-users" ></i> Parents'/Guidians' Data</span></h3><br><br>
                <!--start of parents Div-->
                <div class="form-group">
                  <label class="control-label col-sm-1">Firstname<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-5">
                    <input class="form-control form-control-inline input-medium " name="parentFname" type="text" required="" value="<?php echo $pfname; ?>" > <br> 
                    
                  </div>
                  <label class="control-label col-sm-1" >Othernames<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-5 ">
                    <input class="form-control form-control-inline input-medium " name="parentOthers" type="text" required="" value="<?php echo $plname; ?>"><br>  
                    
                  </div>
                  
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-1">Relationship<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-5">
                    <select required="" class="form-control form-control-inline input-medium " name="childRelationship" >
                    	 <option  value="">--Select Relationship--
                      </option>
                      <?php if ($relationship != '')
                      {
                      	echo '
                      <option selected="" value="'.$relationship.'">'.
                      $relationship.'
                      </option>';
                      if ($relationship == 'Parent') 
                      {
                      	echo '
                      <option value="Guidian">Guidian</option>
                      <option value="Relative">Relative</option>';
                  	  }
                  	  if ($relationship == 'Guidian') 
                  	  {
                      	echo '
                      <option value="Parent">Parent</option>
                      <option value="Relative">Relative</option>';
                      }
                      if ($relationship == 'Relative') 
                      {
                      	echo '
                      <option value="Parent">Parent</option>
                      <option value="Guidian">Guidian</option>';
                  	  }
                  	}
                  	else
                  	{
                  		echo '
                     
                      <option value="Parent">Parent</option>
                      <option value="Guidian">Guidian</option>
                      <option value="Relative">Relative</option>';
                  	}
                  	  
                  	
                  	?>
                    </select>                  
                 
                  </div>

                    <label class="control-label col-sm-1">Occupation</label>
                  <div class="col-md-5">
                    <input class="form-control form-control-inline input-medium "  name="parentOccup" type="text" value="<?php echo $occup; ?>"><br>  
                    
                  </div>
              </div>

              <div class="form-group">

                  <label class="control-label col-sm-1">Religion</label>
                  <div class="col-md-5">
                    <input class="form-control form-control-inline input-medium " name="parentReligion" type="text" value="<?php echo $religion; ?>"><br>  
                    
                  </div> 

                <label class="control-label col-sm-3">Number of Child in our School</label>
                  <div class="col-md-3">
                    <select class="form-control form-control-inline input-medium " name="numChild">
                       <option >--Select Number of Child--</option>
                       <?php if ($numChild != '')
                      {
                      	echo '
                      <option selected="" value="'.$numChild.'">'.
                      $numChild.'
                      </option>';
                      if ($numChild == '1') 
                      {
                      	echo '
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>';
                  	  }
                  	  if ($numChild == '2') 
                  	  {
                      	echo '
                      <option value="1">1</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>';
                      }
                      if ($numChild == '3') 
                      {
                      	echo '
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="4">4</option>
                      <option value="5">5</option>';
                  	  }
                  	  if ($numChild == '4') 
                      {
                      	echo '
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="5">5</option>';
                  	  }
                  	  if ($numChild == '5') 
                      {
                      	echo '
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>';
                  	  }
                  	}
                  	else
                  	{
                  		echo '
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>';
                  }
                  ?>
                    </select> <br>
                  </div> 
                

                </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Phone Number<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-4">
                  <input type="tel" required="" class="form-control form-control-inline input-medium" name="phone"  onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57" value="<?php echo $phone1; ?>">
                                                 
                    
                  </div>

                <label class="control-label col-sm-2">Alternate Phone</label>
                  <div class="col-md-4">
                  <input type="tel" class="form-control form-control-inline input-medium" name="altPhone"  onkeypress="return (event.charCode == 8 || event.charCode==0)? null: event.charCode >=48 && event.charCode <=57" value="<?php echo $altPhone; ?>">
                                                 
                    
                  </div>
                  
                  
              </div>

              
                 <div class="form-group">
                  <label class="control-label col-sm-1">Email<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-2">
                  <input required="" type="email" class="form-control form-control-inline input-medium" name="email" value="<?php echo $email; ?>" >
                     </div>                            
                    <label class="control-label col-sm-3">Would you like to be notified about your child?<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                  <div class="col-md-2">
                  <select required="" class="form-control form-control-inline" name="parentApp">
                    <option value="">--Select Option--</option>
                     
                      <?php if ($activate != '')
                      {
                      	if ($activate = 1) 
                      	{
                      		$yes ='Yes';
                      	}
                      		else
                      		{
                      			$no = 'No';
                      		}
                      	
                      	echo '
                      <option selected="" value="'.$activate.'">'.
                      $yes.'
                      </option>';
                      if ($activate == 1) 
                      {
                      	echo '
                      <option value="0">No</option>';
                  	  }
                  	  if ($activate = 0) 
                  	  {
                      	echo '
                      <option value="1">Yes</option>';
                      }
                     
                  	}
                  	else
                  	{
                  		echo '
                      <option value="1">Yes</option>
                      <option value="0">No</option>';
                  	}
                  	?>
                  	  
                  </select>         
                </div>
                <label class="control-label col-sm-2">Notification Term:<i style="color: red; font-weight: bolder; font-size: 20px">*</i></label>
                <div class="col-md-2">
                    <select class="form-control form-control-inline input-medium "  name="term" id="term" required="">
                      <option>--Select Term--</option>
                       <?php if ($term != '')
                      {
                        echo '
                      <option selected="" value="'.$term.'">1st Term
                      </option>';
                      if ($term == '1') 
                      {
                        echo '
                      <option value="2">2nd Term</option>
                      <option value="3">3rd Term</option>';
                      }
                      if ($term == '2') 
                      {
                        echo '
                      <option value="1">1st Term</option>
                      <option value="3">3rd Term</option>';
                      }
                      if ($term == '3') 
                      {
                        echo '
                      <option value="1">1st Term</option>
                      <option value="2">2nd Term</option>';
                      }
                      
                    }
                    else
                    {
                      echo '
                      <option value="1">1st Term</option>
                      <option value="2">2nd Term</option>
                      <option value="3">3rd Term</option>';
                  }
                  ?>
                    </select><br>  
                     
                  </div> 
              </div>

                <div class="form-group">
                  <div class="col-md-6">
                 <a  class="btn btn-danger btn-sm pull-left" href="update-choice.php?id=<?php  $urlEncode = rtrim(strtr(base64_encode(gzdeflate($studId, 9)), '+/','-_'),'=') ;
  					 echo $urlEncode; ?>">&nbsp;<i class="fa fa-arrow-left"></i> Previous </a><br><br>  
                 </div>
                 
                  <div class="col-md-6">
                 <button type="submit" name="go" class="btn btn-primary btn-sm pull-right" >Update&nbsp;<i class="fa fa-refresh"></i> </button><br><br>  
                 </div>                
                </div>
                <div class="form-group"></div>
               
                 </div>                
                </div>
                
               
              </form>
              <?php }else{echo "<script>alert('Error due to system modification. Click Ok to continue');
            window.location.href='view-admitted-students.php';

            </script>";} ?>
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
