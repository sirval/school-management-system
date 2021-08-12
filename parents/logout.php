<?php 
session_start();
require '../db/db_con.php';
			$_SESSION = array();
			session_write_close();
			unset($_SESSION['parent']);
			unset($_SESSION['parentId']);
			 unset($_SESSION['schoolId']);
			 unset($_SESSION['phone']);
			 unset($_SESSION['studId']);
			session_unset();
			session_destroy();
			header('location: index.php');
exit;
?>