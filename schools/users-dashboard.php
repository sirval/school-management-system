<?php
error_reporting(0);
session_start();
   require '../controller/users_required.php'; 
   if (!isset($_SESSION['userRole']) && $_SESSION['userRole'] =="") {
     header('location: index.php');
   }
   meta();
   siteTitle(mysite, ' || ', ' Staff'.' || ' . $_SESSION['user']);
  $pagename='users_dashboard';
    pageHeader();
   sideBar();
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
          
            <div class="row mt">
              <!-- New Student Registration -->
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn">
                  <div class="grey-header">
                    <h5>Manage Result</h5>
                  </div>
                  <p>Process students result and even import old students result</p>
                  <p><a href="result-processing.php" class="btn btn-success btn-sm"> Process Result <i class="fa fa-refresh"></i></a></p>
                </div>
               
              
              </div>
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn">
                  <div class="grey-header">
                    <h5>Roll Calls</h5>
                  </div>
                  
                  <p>Click here to take students roll call based on specified class</p>
                  <a class="btn btn-primary btn-sm" href="new-student.php"> Take Roll Call <i class="fa fa-check"></i></a>
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
