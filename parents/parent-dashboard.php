<?php
error_reporting(0);
session_start();
 require '../db/db_con.php';

    require '../controller/parents_required.php'; 
   
 
siteTitle(mysite, ' || ', '  Parents'.' || ' . $_SESSION['username']);
   meta();
    pageHeader();
   sideBar();

$schoolId = $_SESSION['schoolId'];
$sql=mysqli_query($conn, "SELECT schPhone FROM schools WHERE schools.id='$schoolId'");
   
  if (mysqli_num_rows($sql)>0) {
    
  while ($getRes=mysqli_fetch_array($sql)) 
  {
      $phone= $getRes['schPhone'];
    }
  }

   if (isset($_GET['warning']) && $_GET['warning'] !=='') {
    $errmsg = $_GET['warning'];
    $msgerror ='';
    if ($errmsg == 'unavailable gateway') 
    {
      $msgerror ="Oops! Seems your child's school has not enabled this functionality yet! Kindly <a href='tel:".$phone."'> Call </a> for confirmation and the next step to take.";
    }
  }
   ?>
  
    <!--main content start-->
     <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-9">
           
            <div class="border-head">
              <h3>Quick Links</h3>
            </div>
          <div>
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
           
            
         ?></div>
          </div>
            <div class="row mt">
              <!-- New Student Registration -->
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn">
                  <div class="grey-header">
                    <h5>Attendance</h5>
                  </div>
                  <p>Find out if your word is presently school based on class teachers roll call</p>
                  <p><a href="attendance-option.php" class="btn btn-success btn-sm"> View Attendance <i class="fa fa-check"></i></a></p>
                </div>
               
              
              </div>
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn">
                  <div class="grey-header">
                    <h5>Check Result</h5>
                  </div>
                  
                  <p>Click here to check your words result</p>
                  <a class="btn btn-primary btn-sm" href="result-checker.php"> Check Result <i class="fa fa-eye"></i></a>
                </div>
                <!--  /darkblue panel -->
              </div>
<img src="img/favicon.png">
                           
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
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="../assets/lib/jquery/jquery.min.js"></script>

  <script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="../assets/lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="../assets/lib/jquery.scrollTo.min.js"></script>
  <script src="../assets/lib/jquery.nicescroll.js" type="text/javascript"></script>
  <script src="../assets/lib/jquery.sparkline.js"></script>
  <!--common script for all pages-->
  <script src="../assets/lib/common-scripts.js"></script>
  <script type="text/javascript" src="../assets/lib/gritter/js/jquery.gritter.js"></script>
  <script type="text/javascript" src="../assets/lib/gritter-conf.js"></script>
  <!--script for this page-->
  <script src="../assets/lib/sparkline-chart.js"></script>
  <script src="../assets/lib/zabuto_calendar.js"></script>
 
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
