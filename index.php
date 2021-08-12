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
  <title>SmartSchools - Home</title>
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
          <a href="index.php"><h1 style="color: #FFFFFF !important"> SmartSchools</h1></a>
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
  <!-- End Header Area -->


  <!-- Start Banner Area -->
  <section class="home-banner-area relative">
    <div class="container">
      <div class="row fullscreen d-flex align-items-center justify-content-center">
        <div class="banner-content col-lg-8 col-md-12">
          <h1 class="wow fadeIn" data-wow-duration="4s">We Rank the Best School Management App <br> on the Web</h1>
          
          <div class="input-wrap">
           
              <a href="students" class="primary-btn">Get Started</a>
            
          </div>
          <h4 class="text-white">Trending Subjects</h4>

          <div class="courses pt-20">
            <a href="#" data-wow-duration="1s" data-wow-delay=".3s" class="primary-btn transparent mr-10 mb-10 wow fadeInDown">Physics</a>
            <a href="#" data-wow-duration="1s" data-wow-delay=".6s" class="primary-btn transparent mr-10 mb-10 wow fadeInDown">Chemistry</a>
            <a href="#" data-wow-duration="1s" data-wow-delay=".9s" class="primary-btn transparent mr-10 mb-10 wow fadeInDown">Mathemaics</a>
            <a href="#" data-wow-duration="1s" data-wow-delay="1.2s" class="primary-btn transparent mr-10 mb-10 wow fadeInDown">English
              Language
            </a>
            <a href="#" data-wow-duration="1s" data-wow-delay="1.5s" class="primary-btn transparent mr-10 mb-10 wow fadeInDown">Economics</a>
            <a href="#" data-wow-duration="1s" data-wow-delay="1.8s" class="primary-btn transparent mr-10 mb-10 wow fadeInDown">Religion
            </a>
            <a href="#" data-wow-duration="1s" data-wow-delay="2.1s" class="primary-btn transparent mr-10 mb-10 wow fadeInDown">Civic Education</a>
          </div>
        </div>
      </div>
    </div>
    <div class="rocket-img">
      <img src="img/rocket.png" alt="">
    </div>
  </section>
  <!-- End Banner Area -->


  <!-- Start About Area -->
  <section class="about-area section-gap">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-lg-5 col-md-6 about-left">
          <img class="img-fluid" src="img/about.jpg" alt="">
        </div>
        <div class="offset-lg-1 col-lg-6 offset-md-0 col-md-12 about-right">
          <h1>
            Over 5 Schools <br> Trust our Services
          </h1>
          <div class="wow fadeIn" data-wow-duration="1s">
            <p>
              There is a moment in the life of every aspiring school to move to the moon. It’s pretty exciting to think about setting up your own school management application to suite the staff, students and parents for effective communication. That's where SmartSchools come in to help you manage each of these users efectively while providing them with the necessary tool.
            </p>
          </div>
          
        </div>
      </div>
    </div>
  </section>
  <!-- End About Area -->

  <!--Start Feature Area -->
  <section class="feature-area">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="section-title text-center">
            <h1>Features That Make Us Hero</h1>
            <p>
              With our #1 School Management Application, the day to day school activities are easily handled and report provided for analysis.
            </p>
          </div>
        </div>
      </div>
      <div class="feature-inner row">
        <div class="col-lg-4 col-md-6">
          <div class="feature-item">
            <i class="ti-crown"></i>
            <h4>Payment Management</h4>
            <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay=".1s">
              <p>
                We help parents pay their word's fees directly into the school account using our smart payment. We also  help you keep all financial records ranging from staff, to students as well as your daily expenses.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="feature-item">
            <i class="ti-briefcase"></i>
            <h4>Student Management</h4>
            <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay=".3s">
              <p>
               Register new and manage old students comformtably at a go and have all their records handy. Take students roll call and allow the parents know if their word(s) is/are in school
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="feature-item">
            <i class="ti-medall-alt"></i>
            <h4>Result Management</h4>
            <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay=".5s">
              <p>
                Be freed from the stress of computing results! Just supply fee details and allow the system do all required computation and generate a neat result while keeping record of the result for later use.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="feature-item">
            <i class="ti-key"></i>
            <h4>Parents Teachers Association</h4>
            <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay=".1s">
              <p>
                While we help both parents, teachers and students get their work done at ease, we do not under estimate the power of communication! We also help both teachers and parents to make complaints and also share feelings together.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="feature-item">
            <i class="ti-files"></i>
            <h4>Attendance Real Time Communication</h4>
            <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay=".3s">
              <p>
                We get parents notified on real time about the presence or absence of their ward(s) in school via their dashboard. This will enable our parents take prompt action on emergencies. 
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="feature-item">
            <i class="ti-headphone-alt"></i>
            <h4>Live Support</h4>
            <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay=".5s">
              <p>
                Providing you with enormous functionalities without support on how to use them keeps you in a state of confusion. To avoid this, we provide you with 24/7 supprot system.  
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Feature Area -->

  <!-- Start Courses Area -->
  <section class="courses-area section-gap">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-5 about-right">
          <h1>
            This is Why <br> We have Solid Idea
          </h1>
          <div class="wow fadeIn" data-wow-duration="1s">
            <p>
              The founders of SmartSchools are seasoned academia who have banks of knowledge in school management, Teaching and Communication skills. These gives us the edge over other school management applications online and also help us provide our students with curated learning materials.
            </p>
          </div>
          <a href="courses.html" class="primary-btn white">Explore Materials</a>
        </div>
        <div class="offset-lg-1 col-lg-6">
          <div class="courses-right">
            <p style="font-weight: bolder; color: #38BEC7;">Quick Learning Tags</p>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12">
                <ul class="courses-list">
                  <li>
                    <a class="wow fadeInLeft" href="#" data-wow-duration="1s" data-wow-delay=".1s">
                      <i class="fa fa-book"></i> Development
                    </a>
                  </li>
                  <li>
                    <a class="wow fadeInLeft" href="#" data-wow-duration="1s" data-wow-delay=".3s">
                      <i class="fa fa-book"></i> IT & Software
                    </a>
                  </li>
                  <li>
                    <a class="wow fadeInLeft" href="#" data-wow-duration="1s" data-wow-delay=".5s">
                      <i class="fa fa-book"></i> Photography
                    </a>
                  </li>
                  <li>
                    <a class="wow fadeInLeft" href="#" data-wow-duration="1s" data-wow-delay=".7s">
                      <i class="fa fa-book"></i> Language
                    </a>
                  </li>
                  <li>
                    <a class="wow fadeInLeft" href="#" data-wow-duration="1s" data-wow-delay=".9s">
                      <i class="fa fa-book"></i> Life Science
                    </a>
                  </li>
                  <li>
                    <a class="wow fadeInLeft" href="#" data-wow-duration="1s" data-wow-delay="1.1s">
                      <i class="fa fa-book"></i> Business
                    </a>
                  </li>
                  <li>
                    <a class="wow fadeInLeft" href="#" data-wow-duration="1s" data-wow-delay="1.3s">
                      <i class="fa fa-book"></i> Social Science
                    </a>
                  </li>
                </ul>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12">
                <ul class="courses-list">
                  <li>
                    <a class="wow fadeInRight" href="#" data-wow-duration="1s" data-wow-delay="1.3s">
                      <i class="fa fa-book"></i> Data Science
                    </a>
                  </li>
                  <li>
                    <a class="wow fadeInRight" href="#" data-wow-duration="1s" data-wow-delay="1.1s">
                      <i class="fa fa-book"></i> Design
                    </a>
                  </li>
                  <li>
                    <a class="wow fadeInRight" href="#" data-wow-duration="1s" data-wow-delay=".9s">
                      <i class="fa fa-book"></i> Training
                    </a>
                  </li>
                  <li>
                    <a class="wow fadeInRight" href="#" data-wow-duration="1s" data-wow-delay=".7s">
                      <i class="fa fa-book"></i> Humanities
                    </a>
                  </li>
                  <li>
                    <a class="wow fadeInRight" href="#" data-wow-duration="1s" data-wow-delay=".5s">
                      <i class="fa fa-book"></i> Marketing
                    </a>
                  </li>
                  <li>
                    <a class="wow fadeInRight" href="#" data-wow-duration="1s" data-wow-delay=".3s">
                      <i class="fa fa-book"></i> Economics
                    </a>
                  </li>
                  <li>
                    <a class="wow fadeInRight" href="#" data-wow-duration="1s" data-wow-delay=".1s">
                      <i class="fa fa-book"></i> Personal Dev
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Courses Area -->



  <!-- Start Testimonials Area -->
  <section class="testimonials-area section-gap">
    <div class="container">
      <div class="testi-slider owl-carousel" data-slider-id="1">
        <div class="item">
          <div class="testi-item">
            <img src="img/quote.png" alt="">
            <h4>Nelson Mandela</h4>
            <ul class="list">
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
            </ul>
            <div class="wow fadeIn" data-wow-duration="1s">
              <p>
                Education is the most powerful weapon which you can use to change the world.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="testi-item">
            <img src="img/quote.png" alt="">
            <h4>Chinese Proverb</h4>
            <ul class="list">
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
            </ul>
            <div class="wow fadeIn" data-wow-duration="1s">
              <p>
                If you are planning for a year, sow rice; if you are planning for a decade, plant trees; if you are planning for a lifetime, educate people. 
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="testi-item">
            <img src="img/quote.png" alt="">
            <h4>G.K Chesterton</h4>
            <ul class="list">
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
            </ul>
            <div class="wow fadeIn" data-wow-duration="1s">
              <p>
                Education is simply the soul of a society as it passes from one generation to another.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="testi-item">
            <img src="img/quote.png" alt="">
            <h4>Martin Luther King</h4>
            <ul class="list">
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
              <li><a href="#"><i class="fa fa-star"></i></a></li>
            </ul>
            <div class="wow fadeIn" data-wow-duration="1s">
              <p>
                The function of education is to teach one to think intensively and to think critically. Intelligence plus character-that is the goal of true education.
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="owl-thumbs d-flex justify-content-center" data-slider-id="1">
        <div class="owl-thumb-item">
          <div>
            
          </div>
          <div class="overlay overlay-grad"></div>
        </div>
        <div class="owl-thumb-item">
          <div>
            
          </div>
          <div class="overlay overlay-grad"></div>
        </div>
        <div class="owl-thumb-item">
          <div>
            
          </div>
          <div class="overlay overlay-grad"></div>
        </div>
        <div class="owl-thumb-item">
          <div>
            
          </div>
          <div class="overlay overlay-grad"></div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Testimonials Area -->


  <!-- Start Footer Area -->
  <footer class="footer-area section-gap">
    <div class="container">
      <div class="row">
        <div class="col-lg-2 col-md-6 single-footer-widget">
          <h4>SmartSchools</h4>
          <ul>
            <li><strong style="color: #F9F9FF !important;">Address: </strong><a href="">#50/54 Ikot-Ekpene Road, Aba Abia State, Nigeria</a></li>
             <li><strong style="color: #F9F9FF !important;">Phone: </strong><a href="tel: +2348082646718">+234-808-2646-718</a></li>
            <li><strong style="color: #F9F9FF !important;">Email: </strong><a href="mailto: support@smartschools.com.ng">support@smartschools.com.ng</a></li>
            
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
  <!-- End Footer Area -->

  <!-- ####################### Start Scroll to Top Area ####################### -->
  <div id="back-top">
    <a title="Go to Top" href="#"></a>
  </div>
  <!-- ####################### End Scroll to Top Area ####################### -->

  <script src="js/vendor/jquery-2.2.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
   crossorigin="anonymous"></script>
  <script src="js/vendor/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
  <script src="js/easing.min.js"></script>
  <script src="js/hoverIntent.js"></script>
  <script src="js/superfish.min.js"></script>
  <script src="js/jquery.ajaxchimp.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/owl-carousel-thumb.min.js"></script>
  <script src="js/jquery.sticky.js"></script>
  <script src="js/jquery.nice-select.min.js"></script>
  <script src="js/parallax.min.js"></script>
  <script src="js/waypoints.min.js"></script>
  <script src="js/wow.min.js"></script>
  <script src="js/jquery.counterup.min.js"></script>
  <script src="js/mail-script.js"></script>
  <script src="js/main.js"></script>
</body>

</html>