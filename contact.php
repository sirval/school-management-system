<?php
error_reporting(0);
session_start();
require 'controller/restricted.php';

require 'db/db_con.php';
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
  <!-- Mobile Specific Meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Favicon-->
  <link rel="shortcut icon" href="img/fav.png">
  <!-- Author Meta -->
  <meta name="author" content="SmartSchools">
  <!-- Meta Description -->
  <meta name="description" content="school management application">
  <!-- Meta Keyword -->
  <meta name="keywords"  content="school management system, exam, grade, result, school">
  <!-- meta character set -->
  <meta charset="UTF-8">
  <!-- Site Title -->
  <title>SmartSchools - Privacy Policy</title>
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  
  <!--
      Google Font
      ============================================= -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,500,600" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500i" rel="stylesheet">

  <!--
      CSS
      ============================================= -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/themify-icons/0.1.2/css/themify-icons.css">
  <link rel="stylesheet" href="css/linearicons.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/nice-select.css">
  <link rel="stylesheet" href="css/animate.min.css">
  <link rel="stylesheet" href="css/owl.carousel.css">
  <link rel="stylesheet" href="css/main.css">
</head>

<body>

  <!-- Start Header Area -->
  <header id="header">
    <div class="container">
      <div class="row align-items-center justify-content-between d-flex">
        <div id="logo">
          <a href="index.php"><h1 style="color: #FFFFFF !important">SmartSchools</h1></a>
        </div>
        <nav id="nav-menu-container">
          <ul class="nav-menu">
            <li class="menu-active"><a href="index.php">Home</a></li>
            <li><a href="students">Students</a></li>
            <li><a href="parents">Parents</a></li>
             <li><a href="contact.php">Contact</a></li>
            
          </ul>
        </nav><!-- #nav-menu-container -->
      </div>
    </div>
  </header>
  <!-- Start Banner Area -->
  <section class="banner-area relative">
    <div class="container">
      <div class="row d-flex align-items-center justify-content-center">
        <div class="about-content col-lg-12">
          <h1 class="text-white">
            Contact Us
          </h1>
          <p>We're Outsmart Ideas Tech and Business Innovation Services</p>
          <div class="link-nav">
            <span class="box">
              <a href="index.php">Home </a>
              <i class="lnr lnr-arrow-right"></i>
               <a href="contact.php">Contact Us</a>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="rocket-img">
      <img src="img/rocket.png" alt="">
    </div>
  </section>
  <!-- End Banner Area -->

 <!-- Start contact-page Area -->
  <section class="contact-page-area section-gap">
    <div class="container">
      <div class="row">
        <div class="map-wrap" style="width:100%; height: 445px;" id="map"></div>
        <div class="col-lg-4 d-flex flex-column address-wrap">
          <div class="single-contact-address d-flex flex-row">
            <div class="icon">
              <span class="lnr lnr-home"></span>
            </div>
            <div class="contact-details">
              <h5>Aba, Abia State</h5>
              <p>
                #50/54 Ikot-Ekpene Road
              </p>
            </div>
          </div>
          <div class="single-contact-address d-flex flex-row">
            <div class="icon">
              <span class="lnr lnr-phone-handset"></span>
            </div>
            <div class="contact-details">
              <h5>+234-808-2646-718</h5>
              <p>Mon to Fri 8am to 4 pm</p>
            </div>
          </div>
          <div class="single-contact-address d-flex flex-row">
            <div class="icon">
              <span class="lnr lnr-envelope"></span>
            </div>
            <div class="contact-details">
              <h5>support@smartschools.com.ng</h5>
              <p>Send us your query anytime!</p>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <form class="form-area contact-form text-right" id="myForm" action="mail.php" method="post">
            <div class="row">
              <div class="col-lg-6 form-group">
                <input name="name" placeholder="Enter your name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'"
                 class="common-input mb-20 form-control" required="" type="text">

                <input name="email" placeholder="Enter email address" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''"
                 onblur="this.placeholder = 'Enter email address'" class="common-input mb-20 form-control" required="" type="email">

                <input name="subject" placeholder="Enter subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter subject'"
                 class="common-input mb-20 form-control" required="" type="text">
              </div>
              <div class="col-lg-6 form-group">
                <textarea class="common-textarea form-control" name="message" placeholder="Enter Messege" onfocus="this.placeholder = ''"
                 onblur="this.placeholder = 'Enter Messege'" required=""></textarea>
              </div>
              <div class="col-lg-12">
                <div class="alert-msg" style="text-align: left;"></div>
                <button class="primary-btn" style="float: right;">Send Message</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- End contact-page Area -->

<!-- Start Footer Area -->
  <footer class="footer-area section-gap">
    <div class="container">
      <div class="row">
        <div class="col-lg-2 col-md-6 single-footer-widget">
          <h4>SmartSchools</h4>
          <ul>
            <li><strong style="color: #F9F9FF !important;">Address: </strong><a href="">#50/54 Ikot-Ekpene Road, Aba Abia State, Nigeria</a></li>
             <li><strong style="color: #F9F9FF !important;">Phone: </strong><a href="tel: +2348082646718">+234-808-2646-718</a></li>
            <li><strong style="color: #F9F9FF !important;">Email: </strong><a href="mailto: support@smartschool.com.ng">support@smartschools.com.ng</a></li>
            
          </ul>
        </div>
        <div class="col-lg-2 col-md-6 single-footer-widget">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="students">Student</a></li>
            <li><a href="parents">Parent</a></li>
            <li><a href="students">Study</a></li>
            <li><a href="students">Check Result</a></li>
          </ul>
        </div>
        <div class="col-lg-2 col-md-6 single-footer-widget">
          <h4>Features</h4>
          <ul>
            <li><a href="#">Payment Management</a></li>
            <li><a href="#">Student Management</a></li>
            <li><a href="#">Result Management</a></li>
            <li><a href="terms-of-service.php">Terms of Service</a></li>
            <li><a href="privacy-policy.php">Privacy Policy</a></li>
          </ul>
        </div>
        <div class="col-lg-2 col-md-6 single-footer-widget">
          <h4>Resources</h4>
          <ul>
            <li><a href="#">Guides</a></li>
            <li><a href="#">Research</a></li>
            <li><a href="#">Experts</a></li>
            <li><a href="#">Agencies</a></li>
          </ul>
        </div>
        <div class="col-lg-4 col-md-6 single-footer-widget">
          <h4>Newsletter</h4>
          <p>You can trust us. we only send promo offers,</p>
          <div class="form-wrap" id="mc_embed_signup">
            <form action="" method="post" class="form-inline">
              <input class="form-control" name="EMAIL" placeholder="Your Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Email Address '"
               required="" type="email">
              <button class="click-btn btn btn-default"><span class="lnr lnr-arrow-right"></span></button>
              <div style="position: absolute; left: -5000px;">
                <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
              </div>

              <div class="info"></div>
            </form>
          </div>
        </div>
      </div>
      <div class="footer-bottom row align-items-center">
        <p class="footer-text m-0 col-lg-8 col-md-12">
Copyright &copy;<script>document.write(new Date().getFullYear());</script><strong>SmartSchools.</strong> All rights reserved | Powered by <a href="http://wa.me/2348082646718" target="_blank">Outsmart Ideas</a>
        <div class="col-lg-4 col-md-12 footer-social">
          <a href="#"><i class="fa fa-facebook"></i></a>
          <a href="#"><i class="fa fa-twitter"></i></a>
          <a href="#"><i class="fa fa-dribbble"></i></a>
          <a href="#"><i class="fa fa-behance"></i></a>
        </div>
      </div>
    </div>
  </footer>
  
    <!-- ####################### Start Scroll to Top Area ####################### -->
    <div id="back-top ">
      <a title="Go to Top " href="# "></a>
    </div>
    <!-- ####################### End Scroll to Top Area ####################### -->
  
    <script src="js/vendor/jquery-2.2.4.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js " integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q "
     crossorigin="anonymous "></script>
    <script src="js/vendor/bootstrap.min.js "></script>
    <script type="text/javascript " src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA "></script>
    <script src="js/easing.min.js "></script>
    <script src="js/hoverIntent.js "></script>
    <script src="js/superfish.min.js "></script>
    <script src="js/jquery.ajaxchimp.min.js "></script>
    <script src="js/jquery.magnific-popup.min.js "></script>
    <script src="js/owl.carousel.min.js "></script>
    <script src="js/owl-carousel-thumb.min.js "></script>
    <script src="js/jquery.sticky.js "></script>
    <script src="js/jquery.nice-select.min.js "></script>
    <script src="js/parallax.min.js "></script>
    <script src="js/waypoints.min.js "></script>
    <script src="js/wow.min.js "></script>
    <script src="js/jquery.counterup.min.js "></script>
    <script src="js/mail-script.js "></script>
    <script src="js/main.js "></script>
  </body>
  
  </html>