<?php
error_reporting(0);
session_start();
$userSchool=$_SESSION['schoolId'];
require '../db/db_con.php';
                  if (!empty($_POST['regNum'])) {
                     $regNum = strip_tags(mysqli_real_escape_string($conn, $_POST['regNum']));
                    
                       $auth=mysqli_query($conn, "SELECT * FROM students where regNum='$regNum' and school='$userSchool'");
                       if (mysqli_num_rows($auth)>0) {
                         echo "<p class='status-available' style='color: red'> This Adminssion Number ". $regNum ." already exists!</p>";
                       }else{
                         echo "<p lass='status-unavailable' style='color: green'>".$regNum." does not exit! Proceed with Adminssion Number!</p>";
                       }
                     }
                  
                   ?>
