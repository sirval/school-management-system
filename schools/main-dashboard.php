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
   
   meta();
   siteTitle(mysite, ' || ', ' Admin'.' || ' . $_SESSION['user']);
  $pagename='dashboard';
   pageHeader();
   sideBar();

  if (isset($_POST['import'])) 
  {
    //echo "<script> alert ('working') </script>"; 
  $filename = $_FILES['file']['tmp_name'];
      $file_extention = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
      //check if file is not empty
      if (!file_exists($filename)) {
        echo "<script> alert ('File input should not be empty'); 
        window.location.href='main-dashboard.php';
        </script>";
        exit();
      }
      //check if it has a valid eextension name
      if ($file_extention != 'csv') {
        echo "<script> alert ('Invalid file type. Only CSV files are allowed'); 
        window.location.href='main-dashboard.php';
        </script>";
        exit();
      }
      //check file size
      
      
      if ($_FILES['file']['size'] > 0 ) 
      {
        $file =fopen($filename, 'r');
        $count = 0;
        while (($column = fgetcsv($file, 10000, ',')) !== false) {
          $count++;
          if ($count > 1) {
            
          $surname = ""; 
          if (isset($column[0])) 
          {
            $username = stripslashes(strip_tags(mysqli_real_escape_string($conn, $column[0])));
          }
          $othernames = ""; 
          if (isset($column[1])) 
          {
            $othernames = stripslashes(strip_tags(mysqli_real_escape_string($conn, $column[1])));
          }
          $dob = ""; 
          if (isset($column[2])) 
          {
            $dob = stripslashes(strip_tags(mysqli_real_escape_string($conn, $column[2])));
          }
          $gender = ""; 
          if (isset($column[3])) 
          {
            $gender = stripslashes(strip_tags(mysqli_real_escape_string($conn, $column[3])));
          }
          $address = ""; 
          if (isset($column[4])) 
          {
            $address = stripslashes(strip_tags(mysqli_real_escape_string($conn, $column[4])));
          }
          $ailment = ""; 
          if (isset($column[5])) 
          {
            $ailment = stripslashes(strip_tags(mysqli_real_escape_string($conn, $column[5])));
          }
          $ailmentDes = ""; 
          if (isset($column[6])) 
          {
            $ailmentDes = stripslashes(strip_tags(mysqli_real_escape_string($conn, $column[6])));
          }
          $admDate = ""; 
          if (isset($column[7])) 
          {
            $admDate = stripslashes(strip_tags(mysqli_real_escape_string($conn, $column[7])));
          }
          $admTime = ""; 
          if (isset($column[8])) 
          {
            $admTime = stripslashes(strip_tags(mysqli_real_escape_string($conn, $column[8])));
          }
          $class = ""; 
          if (isset($column[9])) 
          {
            $class = stripslashes(strip_tags(mysqli_real_escape_string($conn, $column[9])));
          }
          $school = ""; 
          if (isset($column[10])) 
          {
            $school = stripslashes(strip_tags(mysqli_real_escape_string($conn, $column[10])));
          }
          $studPics = ""; 
          if (isset($column[11])) 
          {
            $studPics = stripslashes(strip_tags(mysqli_real_escape_string($conn, $column[11])));
          }
          $regNum = ""; 
          if (isset($column[12]) ) 
          {
            $regNum = stripslashes(strip_tags(mysqli_real_escape_string($conn, $column[12])));
          }
          /*$count++;
          if ($count > 1) 
          {*/
           //check if any student data imported already exist
       $validateStudent = mysqli_query($conn, "SELECT * FROM students WHERE `regNum` = '$regNum'");
       if (mysqli_num_rows($validateStudent) >0) {
          echo "<script> alert ('Seems some of the students have been uploaded initially'); 
        window.location.href='main-dashboard.php';
        </script>";
        exit();
       }

      $query =mysqli_query($conn, "INSERT INTO `students`(`surname`, `othernames`, `dob`, `gender`, `address`, `ailment`, `ailmentDes`, `admDate`, `admTime`, `class`, `school`, `studPics`, `regNum`)  VALUES('$username', '$othernames', '$dob', '$gender', '$address', '$ailment', '$ailmentDes','$admDate', '$admTime', '$class', '$school', '$studPics', '$regNum')");
      if (mysqli_affected_rows($conn) >0) 
      {
        echo "<script> 
        var x = confirm('Student Successfully Uploaded. Import Another?');
        if (x == true){
          window.location.href='main-dashboard.php'
        } else{
          window.location.href='view-admitted-students.php'
        }
        </script>";
      }
      else
      {
        echo "<script> alert ('We could not process your request this time. Kindly try again later'); 
        window.location.href='main-dashboard.php';
        </script>";
      }
          }
          
        }
      }
      fclose($filename);
    }
 
  ?>
  
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-9">
           
            <div class="border-head">
              <h3>Quick Links</h3>
            </div>
          
            <div class="row mt">
              <!-- New Student Registration -->
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn">
                  <div class="grey-header">
                    <h5>Total Admitted Student</h5>
                  </div>
                  
                  <?php
                  $studSchool = $_SESSION['schoolId'];
                  
                  $sql = "SELECT * FROM `students` WHERE school = '$studSchool'";
						    if ($query = mysqli_query($conn, $sql)){
						    	
						    $countStud = mysqli_num_rows($query);
						    	echo '<h1 style="color: #C9302C"><b>'. $countStud. '</h1> Students/Pupils Registered';
						    
						    }
                   ?>
                  <p><a href="view-admitted-students.php" class="btn btn-success btn-sm"> View <i class="fa fa-eye"></i></a></p>
                </div>
               
              </div>
              <!-- /col-md-4-->
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn">
                  <div class="grey-header">
                    <h5>Register Old Students</h5>
                  </div>
                  <a href="downloads/student_template.csv" download="student-template.csv" class="btn btn-danger btn-sm">Download CSV Template <i class="fa fa-download"></i></a>
                  <form name="new" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?> " method="post" class="style-form" enctype="multipart/form-data">

                  <div class="form-group">
                    <div class="col-md-12">
                      <div  class="form-group">

                            <input type="file" name="file" id="file" class="form-control form-control-inline input-medium"  size="150" >  
                            <p style="color: red; font-weight: bold; text-align: left;"> Only CSV File</p>             
                      </div>
                    </div>
                </div>
                <p>Import old students/pupils in csv format for upload at ease</p>
              <div class="">
                <button class="btn btn-theme btn-sm" type="submit" name="import" >Import <i class="fa fa-refresh"></i></button>
              </div>
              </form>
                 </div>
                <!--  /darkblue panel -->
              </div>
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn">
                  <div class="grey-header">
                    <h5>Register New Students</h5>
                  </div>
                  
                  <p>Click here to register new intakes for easy access of student's resords</p>
                  <a class="btn btn-primary btn-sm" href="new-student.php">Register New Students <i class="fa fa-plus"></i></a>
                </div>
                <!--  /darkblue panel -->
              </div>

                           
            </div>
            
          </div>
          <div class="col-lg-3 ds">
        
            
           
            <!-- CALENDAR-->
            <div id="calendar" class="mb">
              <div class="panel green-panel no-margin">
                <div class="panel-body">
                  <div id="date-popover" class="popover top" style="cursor: pointer; disadding: block; margin-left: 33%; margin-top: -50px; width: 175px;">
                    <div class="arrow"></div>
                    <h3 class="popover-title" style="disadding: none;"></h3>
                    <div id="date-popover-content" class="popover-content"></div>
                  </div>
                  <div id="my-calendar"></div>
                </div>
              </div>
            </div>
            <!-- / calendar -->
          </div>
          <!-- /col-lg-3 -->
        </div>
        
        <!-- /row -->
      </section>
    </section>
    <?php footer();?>
  </section>
 <?php mainJs(); ?>
  <script type="application/javascript">
    $(document).ready(function() {
      $("#date-popover").popover({
        html: true,
        trigger: "manual"
      });
      $("#date-popover").hide();
      $("#date-popover").click(function(e) {
        $(this).hide();
      });

      $("#my-calendar").zabuto_calendar({
        action: function() {
          return myDateFunction(this.id, false);
        },
        action_nav: function() {
          return myNavFunction(this.id);
        },
        ajax: {
          url: "show_data.php?action=1",
          modal: true
        },
        legend: [{
            type: "text",
            label: "Special event",
            badge: "00"
          },
          {
            type: "block",
            label: "Regular event",
          }
        ]
      });
    });

    function myNavFunction(id) {
      $("#date-popover").hide();
      var nav = $("#" + id).data("navigation");
      var to = $("#" + id).data("to");
      console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
    }
  </script>
</body>

</html>
<?php 
mysqli_close($conn);
?>
