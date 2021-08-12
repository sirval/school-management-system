<?php
$conn=mysqli_connect('localhost', 'root', '', 'sms');
if (!$conn) {
	die('Unable to Establish Database Connection:'. mysqli_connect_error());
}
?>