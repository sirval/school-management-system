  <?php
    require '../db/db_con.php';

  require '../controller/admin_required.php'; 
   
$userId=$_SESSION['usersn'];
siteTitle(mysite, ' || ', ' Super Admin'.' || ' . $_SESSION['username']);
  $pagename='new-school';
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
   <section id="main-content">
      <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> All Expenses</h3>
        <div class="row mb">
          
          <!-- page start-->
          <div class="content-panel">
            <div class="alert alert-info alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                              </button>
                  <p>This table is an auto generated list of all Expenses. Use the Search box at your right hand side to manipulate the table. Always click the table headers to rearrange the table.</p>
                  </div>
                  <div>
            <div class="form-group">
                  <div class="col-md-12">
                    
                    <a  data-toggle="modal" class="btn btn-primary btn-sm pull-right" href="view-expenses.php#myModal">Print Document&nbsp;<i class="fa fa-arrow-right"></i> </a><br><br>  
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
                  <div class="text-center ">
                <h4><i class="fa fa-institution"></i>DAILY EXPENSES FOR ALL REGISTERED SCHOOLS  </h4>
              </div>
                 
            <div  class="adv-table padTable">
              <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
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
                   $query=mysqli_query($conn, "SELECT * FROM expenses_backup ex
              INNER JOIN term t
                        ON t.id=ex.termId
                 ");
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
                    <td class="hidden-phone">'.$term.'</td>
                    <td class="hidden-phone">'.$date.'</td>
                    <td class="hidden-phone">'.$time.'</td>
                    <td class="hidden-phone">'.$product.'</td>
                    <td class="hidden-phone">'.$qty.'</td>
                    <td class="hidden-phone">'.$price.'</td>
                    <td class="hidden-phone">'.$total.'</td>
                    <td class="hidden-phone">'.$authBy.'</td>
                    <td class="hidden-phone">'.$purBy.'</td>
                  </tr>';}
                }?>
                  
                  </tbody>
              </table>

              </div>
              </div>
            </div>
          </div>
        </div>
            </div>
          </div>
        </div>
      </section>
      <?php footer();?>
    </section>
  

     <!-- js placed at the end of the document so the pages load faster -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="lib/jquery.scrollTo.min.js"></script>
  <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
  <!--common script for all pages-->
  <script src="lib/jquery/jquery.min.js"></script>
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
  <script type="text/javascript">
    /* Formating function for row details */
    

    $(document).ready(function() {
      /*
       * Insert a 'details' column to the table
       */
      var nCloneTh = document.createElement('th');
      var nCloneTd = document.createElement('td');
      nCloneTd.className = "center";

      $('#hidden-table-info thead tr').each(function() {
        this.insertBefore(nCloneTh, this.childNodes[0]);
      });

      $('#hidden-table-info tbody tr').each(function() {
        this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
      });

      /*
       * Initialse DataTables, with no sorting on the 'details' column
       */
      var oTable = $('#hidden-table-info').dataTable({
        "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [0]
        }],
        "aaSorting": [
          [1, 'asc']
        ]
      });

    });

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
<?php mysqli_close($conn); ?>
</html>

            