<?php 
session_start();
require '../db/db_con.php';
			$_SESSION = array();
			session_write_close();
			unset($_SESSION['userId']);
			unset($_SESSION['user']);
			 unset($_SESSION['schoolId']);
			 unset($_SESSION['userRole']);
			session_unset();
			session_destroy();
			header('location: index.php');
exit;
?>