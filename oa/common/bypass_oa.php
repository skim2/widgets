<?php
	header("Content-Type: text/html;charset=UTF-8");
	//session_start();
	//echo '<script>';
	//echo 'console.log("test1")';

    
	if (!$_REQUEST["oaUrl"]) {
		
		header("Location: "."https://proxy.openathens.net/login?qurl=".urldecode($_REQUEST["oaUrl"]));
	}
	
?>