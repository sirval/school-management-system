
  <?php
  error_reporting(0);
  session_start();
    require '../db/db_con.php';
   if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 1) {
      require '../controller/required.php'; 
    }else{
      require '../controller/users_required.php'; 
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
    
   ?>
     <link href="../assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="../assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  
  <link href="../assets/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
  
  <!-- Custom styles for this template -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/style-responsive.css" rel="stylesheet">
  <style type="text/css">
    .padTable{
      margin: 10px;
    }
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-9">
           
            <div class="border-head">
              <h3>Result Processing Page</h3>
            </div>
          
            <div class="row mt">
              <!-- New Result Upload -->
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn">
                  <div class="grey-header">
                    <h5>Upload Result</h5>
                  </div>
                  
                  <p>Upload all students result at a go based on selected class, subject and term</p>
                  <br>
                  <a data-toggle="modal" class="btn btn-theme btn-sm" href="result-processing.php#resultUpload">Upload Result  <i class="fa fa-upload"></i></a>
                </div>
              </div>

              <!-- Upload Result as CSV -->
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn">
                  <div class="grey-header">
                    <h5>Import Result as CSV</h5>
                  </div>
                  <a href="downloads/result_template.csv" download="result-template.csv" class="btn btn-danger btn-sm">Download CSV Template <i class="fa fa-download"></i></a>
                  
                  <br><br>
                  <p>Import students result already in csv format at ease &nbsp;&nbsp;&nbsp;</p><br>
                  <a data-toggle="modal" class="btn btn-primary btn-sm" href="result-processing.php#importResult">Import CSV Result <i class="fa fa-cloud"></i></a>
                  
                </div>
              </div>

              <!-- publish Result -->
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn">
                  <div class="grey-header">
                    <h5>Publish Result</h5>
                  </div>
                  
                  <p>Done uploading result? Get result ready for students by Publishing Result</p><br>
                  <a data-toggle="modal" class="btn btn-info btn-sm" href="result-processing.php#roundUpResult">Publish Result <i class="fa fa-refresh"></i></a>
                  
                </div>
              </div>

              <!-- view Result comprehensive list-->
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn">
                  <div class="grey-header">
                    <h5>View Comprehensive List</h5>
                  </div>
                  
                  <p>Access all students result based on a selected Class for all subject</p>
                <br>
                  <a data-toggle="modal" class="btn btn-warning btn-sm" href="result-processing.php#viewResultByClass">Comprehensive List <i class="fa fa-users"></i></a>
                  
                </div>
              </div>

              <!-- view Result by section-->
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn">
                  <div class="grey-header">
                    <h5>View Result By Section (Nur/Pri/JS/SS)</h5>
                  </div>
                  <p>Access all students result based on a selected section</p>          
                  <br>
                 <a data-toggle="modal" class="btn btn-info btn-sm" href="result-processing.php#viewResultBySection">View Result <i class="fa fa-eye"></i></a>
                </div>
              </div>
                  
            </div>
            <br><br><br><br><br><br>

              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="resultUpload" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" style="font-size: 25px; text-align: center;">DATA REQUEST</h4>
                          </div>
                          <p>Select these options to proceed</p>
                  <div class="modal-footer">          
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="style-form" enctype="multipart/form-data">

              <div class="form-group">
                 <div class="col-md-12">
                      <select name="examYear" id="examYear" required class="form-control" required="" >
                        <option value="">--Select Exam Year--</option>
                            
                        <option selected="" value="<?php echo date("Y"); ?>"><?php echo date("Y");?></option>
                                       
                      </select><br>
                  </div>
                
                <div class="col-md-12">
                    <select class="form-control form-control-inline input-medium "  name="examTerm" id="examTerm" required="">
                      <option>--Select Exam Term--</option>
                      <?php 
                    $sql=mysqli_query($conn,"SELECT * from term");
                      if (mysqli_num_rows($sql)>0 ) {           
               
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['termName']; }}else{echo "NO AVAILABLE TERM FOUND";}?></option>
                    </select><br>  
                     
                  </div>
                  
           <div class="col-md-12">
              <select name="studClass" id="myClass" required="" class="form-control" onchange="loadSubjectforView();">
                <option value="">--Select Class--</option>
                    <?php 
                        $sqlClass = mysqli_query($conn,"select * from class ");
                            if (mysqli_num_rows($sqlClass)) {
                                while($result = mysqli_fetch_array($sqlClass)){
                                  $classId=$result['id'];
                    ?>
                <option value="<?php echo $classId; ?>"><?php echo $result['classCode'] ;}}else{echo "No Available Class Found";}?></option>
                               
            </select><br>
        </div>
      </div>
        <div class="form-group">
          <div class="col-md-12">
            <div id="subject" class="form-group">
                <select class="form-control" id="mySubject" name="subject" required="" >
                  <option value="">--Select Subject--</option>
                     <option value=""></option>
                </select>                  
            </div>
          </div>
      </div>
      
        
             
              <div class="pull-right">
                <button data-dismiss="modal" class="btn btn-danger" type="button">Cancel <i class="fa fa-times"></i></button>
                <button class="btn btn-theme" type="submit" name="proceed">Proceed <i class="fa fa-arrow-right"></i></button>
              </div>
           
  </form>
</div>
</div>
</div>
</div>
  <?php
  if (isset($_POST['proceed'])) {
      $examYear = strip_tags(mysqli_real_escape_string($conn, $_POST['examYear']));
      $examTerm = strip_tags(mysqli_real_escape_string($conn, $_POST['examTerm']));
      $studClass = strip_tags(mysqli_real_escape_string($conn, $_POST['studClass']));
      $subject = strip_tags(mysqli_real_escape_string($conn, $_POST['subject']));
    if (empty($examYear) ) {
      echo "<script> alert('Select Examination Year') </script>";
    }
    if (empty($examTerm) ) {
      echo "<script> alert('Select Examination Term') </script>";
    }
    if (empty($studClass) ) {
      echo "<script> alert('Select Students Class') </script>";
    }
    if (empty($subject) ) {
      echo "<script> alert('Select Subject') </script>";
    }
    //session_regenerate_id();
      $_SESSION['examYear'] = $examYear;
      $_SESSION['examTerm']= $examTerm;
      $_SESSION['studClass']=$studClass;//student class
      $_SESSION['subject']=$subject;// subjects
      //session_write_close();
    if (!empty($_SESSION['examYear']) || !empty($_SESSION['examTerm']) || !empty($_SESSION['studClass']) || !empty($_SESSION['subject'])) {
      $url = $_SESSION['studClass'];
      $url_encode=base64_encode($url);
        echo "<script>
        window.location.href='result-entry.php?year".$_SESSION['examYear']."/".$_SESSION['examTerm']."/classId=".$url_encode."';
        </script>";
        
  }else{
    echo "<script> alert('An error was encountered while trying the process this request. Please contact the admin id this error persists')";
  }
}
  ?>

            
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="importResult" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" style="font-size: 25px; text-align: center;">DATA REQUEST</h4>
                          </div>
                          <p>Select these options to proceed to csv import</p>
                  <div class="modal-footer">          
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="style-form" enctype="multipart/form-data">

        <div class="form-group">
          <div class="col-md-12">
            <div  class="form-group">
                  <input type="file" name="file" id="file" class="form-control form-control-inline input-medium" required="" size="150">  
                  <p style="color: red; font-weight: bold; text-align: left;"> Only CSV File</p>             
            </div>
          </div>
      </div>
      
        
             
              <div class="pull-right">
                <button data-dismiss="modal" class="btn btn-danger" type="button">Cancel <i class="fa fa-times"></i></button>
                <button class="btn btn-theme" type="submit" name="import">Import <i class="fa fa-arrow-right"></i></button>
              </div>
           
  </form>
</div>
</div>
</div>
</div>
  <?php
  if (isset($_POST['import'])) {
      $filename =$_FILES['file']['tmp_name'];
      $file_extention = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
      //check if file is not empty
      if (!file_exists($filename)) {
        echo "<script> alert ('File input should not be empty'); 
        window.location.href='result-processing.php';
        </script>";
        exit();
      }
      //check if it has a valid eextension name
      if ($file_extention != 'csv') {
        echo "<script> alert ('Invalid file extension'); 
        window.location.href='result-processing.php';
        </script>";
        exit();
      }
      //check file size
      if ($_FILES['file']['size'] > 2000000) {
        echo "<script> alert ('File size is too large'); 
        window.location.href='result-processing.php';
        </script>";
        exit();
      }
      
      if ($_FILES['file']['size'] > 0 ) {
        $file =fopen($filename, 'r');
        $count = 0;
        while (($emapData = fgetcsv($file, 10000, ',')) !== false) {
          $userData = stripslashes(strip_tags(mysqli_real_escape_string($conn, $emapData)));
          $count++;
          if ($count>1) {
        $auth = mysqli_query($conn, "SELECT * FROM student_result WHERE  examYear='$userData[0]' and examTerm='$userData[1]' and studentId = '$userData[2]' and subjectId='$userData[4]'");
      if ($auth) {
        session_regenerate_id();
        $_SESSION['studClass'] = $userData[3];
        echo "<script>var x = confirm('Seems this result has already been uploaded. Click OK to update result');
        if (x == true){
          window.location.href='update-result.php'
        } else{
          window.location.href='result-processing.php'
        }
        </script>";
        exit();
      }
      $query =mysqli_query($conn, "INSERT INTO `student_result`(`examYear`, `examTerm`, `studentId`, `classId`, `subjectId`, `cat`, `exam`, `total`, `grade`, `remark`, `position`) VALUES ('$userData[0]', '$userData[1]', '$userData[2]', '$userData[3]', '$userData[4]', '$userData[5]', '$userData[6]', '$userData[7]', '$userData[8]', '$userData[9]', '$userData[10]')");
      if (mysqli_affected_rows($conn) >0) {
        echo "<script> 
        var x = confirm('Result Imported Successfully. Import Another?');
        if (x == true){
          window.location.href='result-processing.php'
        } else{
          window.location.href='result-processing.php'
        }
        </script>";
      }else{
        echo "<script> alert ('An error occured while trying to import result. If this error persists, please contact admin'); </script>";
      }
          }
        }
      }
    
}
  ?>
            
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="roundUpResult" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" style="font-size: 25px; text-align: center;">DATA REQUEST</h4>
                          </div>
                          <p>Select these options to proceed to publish result</p>
                  <div class="modal-footer">          
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="style-form" enctype="multipart/form-data">

              <div class="form-group">
                 <div class="col-md-12">
                       <select name="examYear" id="examYear" required class="form-control" required="" >
                        <option value="">--Select Exam Year--</option>
                            
                        <option selected="" value="<?php echo date("Y"); ?>"><?php echo date("Y");?></option>
                                       
                      </select>
                <br>
                      <br>
                  </div>
                
                <div class="col-md-12">
                    <select class="form-control form-control-inline input-medium "  name="examTerm" id="examTerm" required="">
                      <option>--Select Exam Term--</option>
                      <?php 
                    $sql=mysqli_query($conn,"SELECT * from term");
                      if (mysqli_num_rows($sql)>0 ) {           
               
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['termName']; }}else{echo "NO AVAILABLE TERM FOUND";}?></option>
                    </select><br>  
                     
                  </div>
                  
           <div class="col-md-12">
              <select name="studClass" id="studClass" required="" class="form-control">
                <option value="">--Select Class--</option>
                    <?php 
                        $sqlClass = mysqli_query($conn,"select * from class ");
                            if (mysqli_num_rows($sqlClass)) {
                                while($result = mysqli_fetch_array($sqlClass)){
                                  $classId=$result['id'];
                    ?>
                <option value="<?php echo $classId; ?>"><?php echo $result['classCode'] ;}}else{echo "No Available Class Found";}?></option>
                               
            </select><br>
        </div>
      </div>
        <div class="form-group">
          <div class="col-md-12">
            <div id="subject" class="form-group">
                                  
            </div>
          </div>
      </div>
      
        
             
              <div class="pull-right">
                <button data-dismiss="modal"  class="btn btn-danger" type="button">Cancel <i class="fa fa-times"></i></button>
                <button class="btn btn-theme" type="submit" name="roundUp">Proceed <i class="fa fa-arrow-right"></i></button>
              </div>
           
  </form>
</div>
</div>
</div>
</div>
  <?php
  if (isset($_POST['roundUp'])) {
      $examYear = strip_tags(mysqli_real_escape_string($conn, $_POST['examYear']));
      $examTerm = strip_tags(mysqli_real_escape_string($conn, $_POST['examTerm']));
      $studClass = strip_tags(mysqli_real_escape_string($conn, $_POST['studClass']));
      //$subject = strip_tags(mysqli_real_escape_string($conn, $_POST['subject']));
    if (empty($examYear) ) {
      echo "<script> alert('Select Examination Year') </script>";
    }
    if (empty($examTerm) ) {
      echo "<script> alert('Select Examination Term') </script>";
    }
    if (empty($studClass) ) {
      echo "<script> alert('Select Students Class') </script>";
    }
    /*
    if (empty($subject) ) {
      echo "<script> alert('Select Subject') </script>";
    }*/
    //session_regenerate_id();
      $_SESSION['examYear'] = $examYear;
      $_SESSION['examTerm']= $examTerm;
      $_SESSION['studClass']=$studClass;//student class
      //$_SESSION['subject']=$subject;// subjects
      //session_write_close();
    if (!empty($_SESSION['examYear']) || !empty($_SESSION['examTerm']) || !empty($_SESSION['studClass'])) {
      $url = $_SESSION['studClass'];
      $url_encode=base64_encode($url);
        echo "<script>
        window.location.href='process-result.php';
        </script>";
        
  }else{
    echo "<script> alert('An error was encountered while trying the process this request. Please contact the admin id this error persists')";
  }
}
  ?>
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="resultUpload" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" style="font-size: 25px; text-align: center;">DATA REQUEST</h4>
                          </div>
                          <p>Select these options to proceed</p>
                  <div class="modal-footer">          
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="style-form" enctype="multipart/form-data">

              <div class="form-group">
                 <div class="col-md-12">
                      <select name="examYear" id="examYear" required class="form-control" required="" >
                        <option value="">--Select Exam Year--</option>
                            
                        <option selected="" value="<?php echo date("Y"); ?>"><?php echo date("Y");?></option>
                                       
                      </select><br>
                  </div>
                
                <div class="col-md-12">
                    <select class="form-control form-control-inline input-medium "  name="examTerm" id="examTerm" required="">
                      <option>--Select Exam Term--</option>
                      <?php 
                    $sql=mysqli_query($conn,"SELECT * from term");
                      if (mysqli_num_rows($sql)>0 ) {           
               
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['termName']; }}else{echo "NO AVAILABLE TERM FOUND";}?></option>
                    </select><br>  
                     
                  </div>
                  
           <div class="col-md-12">
              <select name="studClass" id="myClass" required="" class="form-control" onchange="loadSubjectforView();">
                <option value="">--Select Class--</option>
                    <?php 
                        $sqlClass = mysqli_query($conn,"select * from class ");
                            if (mysqli_num_rows($sqlClass)) {
                                while($result = mysqli_fetch_array($sqlClass)){
                                  $classId=$result['id'];
                    ?>
                <option value="<?php echo $classId; ?>"><?php echo $result['classCode'] ;}}else{echo "No Available Class Found";}?></option>
                               
            </select><br>
        </div>
      </div>
        <div class="form-group">
          <div class="col-md-12">
            <div id="subject" class="form-group">
                <select class="form-control" id="mySubject" name="subject" required="" >
                  <option value="">--Select Subject--</option>
                     <option value=""></option>
                </select>                  
            </div>
          </div>
      </div>
      
        
             
              <div class="pull-right">
                <button data-dismiss="modal" class="btn btn-danger" type="button">Cancel <i class="fa fa-times"></i></button>
                <button class="btn btn-theme" type="submit" name="proceed">View by Subject <i class="fa fa-eye"></i></button>
              </div>
           
  </form>
</div>
</div>
</div>
</div>
            
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewResultByClass" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" style="font-size: 25px; text-align: center;">RESULT UPLOAD DATA REQUEST</h4>
                          </div>
                          <p>&nbsp;&nbsp;&nbsp;Select these options to proceed to Result Upload</p>
                  <div class="modal-footer">          
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="style-form" enctype="multipart/form-data">

              <div class="form-group">
                 <div class="col-md-12">
                      <select name="examYear" id="examYear" required class="form-control" required="" >
                        <option value="">--Select Exam Year--</option>
                            
                        <option selected="" value="<?php echo date("Y"); ?>"><?php echo date("Y");?></option>
                                       
                      </select><br>
                  </div>
                
                <div class="col-md-12">
                    <select class="form-control form-control-inline input-medium "  name="examTerm" id="examTerm" required="">
                      <option>--Select Exam Term--</option>
                      <?php 
                    $sql=mysqli_query($conn,"SELECT * from term");
                      if (mysqli_num_rows($sql)>0 ) {           
               
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['termName']; }}else{echo "NO AVAILABLE TERM FOUND";}?></option>
                    </select><br>  
                     
                  </div>
                  
           <div class="col-md-12">
              <select name="studClass"  required="" class="form-control" >
                <option value="">--Select Class--</option>
                    <?php 
                        $sqlClass = mysqli_query($conn,"select * from class ");
                            if (mysqli_num_rows($sqlClass)) {
                                while($result = mysqli_fetch_array($sqlClass)){
                                  $classId=$result['id'];
                    ?>
                <option value="<?php echo $classId; ?>"><?php echo $result['classCode'] ;}}else{echo "No Available Class Found";}?></option>
                               
            </select><br>
        </div>
      </div>
        
      
        
             
              <div class="pull-right">
                <button data-dismiss="modal"  class="btn btn-danger" type="button">Cancel <i class="fa fa-times"></i></button>
                <button class="btn btn-theme" type="submit" name="viewByClass">Proceed <i class="fa fa-arrow-right"></i></button>
              </div>
           
  </form>
</div>
</div>
</div>
</div>
          
  <?php
  if (isset($_POST['viewByClass'])) {
      $examYear = strip_tags(mysqli_real_escape_string($conn, $_POST['examYear']));
      $examTerm = strip_tags(mysqli_real_escape_string($conn, $_POST['examTerm']));
      $studClass = strip_tags(mysqli_real_escape_string($conn, $_POST['studClass']));
      //$subject = strip_tags(mysqli_real_escape_string($conn, $_POST['subject']));
    if (empty($examYear) ) {
      echo "<script> alert('Select Examination Year') </script>";
    }
    if (empty($examTerm) ) {
      echo "<script> alert('Select Examination Term') </script>";
    }
    if (empty($studClass) ) {
      echo "<script> alert('Select Students Class') </script>";
    }
    
    //session_regenerate_id();
      $_SESSION['examYear'] = $examYear;
      $_SESSION['examTerm']= $examTerm;
      $_SESSION['studClass']=$studClass;//student class
      //$_SESSION['subject']=$subject;// subjects
      //session_write_close();
    if (!empty($_SESSION['examYear']) || !empty($_SESSION['examTerm']) || !empty($_SESSION['studClass']) ) {
      $url = $_SESSION['studClass'];
      $url_encode=base64_encode($url);
        echo "<script>
        window.location.href='filter-result-class.php?classId=".$url_encode."';
        </script>";
        
  }else{
    echo "<script> alert('An error was encountered while trying the process this request. Please contact the admin id this error persists')";
  }
}
  ?>
          
          
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewResultBySection" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" style="font-size: 25px; text-align: center;">DATA REQUEST</h4>
                          </div>
                          <p>Select these options to proceed</p>
                  <div class="modal-footer">          
              <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="style-form" enctype="multipart/form-data">

              <div class="form-group">
                 <div class="col-md-12">
                      <select name="examYear" id="examYear" required class="form-control" required="" >
                        <option value="">--Select Exam Year--</option>
                            
                        <option selected="" value="<?php echo date("Y"); ?>"><?php echo date("Y");?></option>
                                       
                      </select><br>
                  </div>
                
                <div class="col-md-12">
                    <select class="form-control form-control-inline input-medium "  name="examTerm" id="examTerm" required="">
                      <option>--Select Exam Term--</option>
                      <?php 
                    $sql=mysqli_query($conn,"SELECT * from term");
                      if (mysqli_num_rows($sql)>0 ) {           
               
                       while($row = mysqli_fetch_array($sql)){
                    ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['termName']; }}else{echo "NO AVAILABLE TERM FOUND";}?></option>
                    </select><br>  
                     
                  </div>
                  
           <div class="col-md-12">
              <select name="studClass"  required="" class="form-control" >
                <option value="">--Select Section--</option>
                   
                <option value="NUR">Nursery</option>
                <option value="PRI">Primary</option>
                <option value="JSS">Junior Secondary</option>
                <option value="SS">Senior Secondary</option>
                               
            </select><br>
        </div>
      </div>
       
             
              <div class="pull-right">
                <button data-dismiss="modal" class="btn btn-danger" type="button">Cancel <i class="fa fa-times"></i></button>
                <button class="btn btn-theme" type="submit" name="viewBySection">Proceed <i class="fa fa-arrow-right"></i></button>
              </div>
           
  </form>
</div>
</div>
</div>
</div>
        <?php
  if (isset($_POST['viewBySection'])) {
      $examYear = strip_tags(mysqli_real_escape_string($conn, $_POST['examYear']));
      $examTerm = strip_tags(mysqli_real_escape_string($conn, $_POST['examTerm']));
      $studClass = strip_tags(mysqli_real_escape_string($conn, $_POST['studClass']));
      //$subject = strip_tags(mysqli_real_escape_string($conn, $_POST['subject']));
    if (empty($examYear) ) {
      echo "<script> alert('Select Examination Year') </script>";
    }
    if (empty($examTerm) ) {
      echo "<script> alert('Select Examination Term') </script>";
    }
    if (empty($studClass) ) {
      echo "<script> alert('Select Students Class') </script>";
    }
    /*if (empty($subject) ) {
      echo "<script> alert('Select Subject') </script>";
    }*/
    //session_regenerate_id();
      $_SESSION['examYear'] = $examYear;
      $_SESSION['examTerm']= $examTerm;
      $_SESSION['studClass']=$studClass;//student class
      //$_SESSION['subject']=$subject;// subjects
      //session_write_close();
    if (!empty($_SESSION['examYear']) || !empty($_SESSION['examTerm']) || !empty($_SESSION['studClass'])) {
      $url = $_SESSION['studClass'];
      $url_encode=base64_encode($url);
        echo "<script>
        window.location.href='filter-result-section.php?classId=".$url_encode."';
        </script>";
        
  }else{
    echo "<script> alert('An error was encountered while trying the process this request. Please contact the admin id this error persists')";
  }
}
  ?>  
          <!-- end dmbox/view result by subject -->
          <!--  /col-lg-12 -->
        </div>
        <!-- /row -->
        
      </section>
      <!-- /wrapper -->
      <?php footer(); ?>
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
    function loadSubject() {
    var xmlhttp= new XMLHttpRequest();
    xmlhttp.open("GET", "class-request.php?classes="+document.getElementById("studClasses").value, false);
    xmlhttp.send(null);
    document.getElementById("classSubject").innerHTML=xmlhttp.responseText;
    
  }

function loadSubjectforView() {
    var xmlhttp= new XMLHttpRequest();
    xmlhttp.open("GET", "class-request.php?classes="+document.getElementById("myClass").value, false);
    xmlhttp.send(null);
    document.getElementById("mySubject").innerHTML=xmlhttp.responseText;
    
  }
function cancelModal() {
  window.location.href="result-processing.php";
}
</script>
 	 
</body>

</html>
<?php
fclose($filename);
mysqli_close($conn);
?>

