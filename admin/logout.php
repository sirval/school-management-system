<?php 
session_start();
require '../db/db_con.php';
			$_SESSION = array();
			session_write_close();
			unset($_SESSION['usersn']);
			unset($_SESSION['username']);
			
			session_unset();
			session_destroy();
			header('location: index.php');
exit;
?>