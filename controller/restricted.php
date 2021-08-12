
<?php
	$resPages = 'controllers';
	$existence = explode('/',$_SERVER['PHP_SELF']);
	if(in_array('controllers',$existence))
		{
	die ("Direct access forbidden");
	exit;
}
else{
define("base_dir", "/smartschool.com/");
define("target_dir", $_SERVER["DOCUMENT_ROOT"] . "/smartschool.com/");
define('mysite',"smartschool");
$pagename ='';
}
?>