<?php
require '../db/db_con.php';
                  if (!empty($_POST['phone'])) {
                     $phone = strip_tags(mysqli_real_escape_string($conn, $_POST['phone']));
                    
                       $auth=mysqli_query($conn, "SELECT * FROM parents where phone='$phone' or altPhone='$phone' and appActivation = 1");
                       if (mysqli_num_rows($auth)>0) {
                         echo "<p class='status-available' style='color: green'> The Phone Number ". $phone ." is registered with us. Proceed with registration!</p>
                         ";
                       }else{
                         echo "<p lass='status-unavailable' style='color: red'>".$phone." is not a valid phone Number. Kindly visit your words school to update your contact</p>";
                       }
                     }
                  
                   ?>
