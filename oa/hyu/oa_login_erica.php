<?php
	header("Content-Type: text/html;charset=UTF-8");
	session_start();
	echo '<script>';
	echo 'console.log("test1")';

	// To get returnData
	if (empty($_REQUEST["returnData"])) {
		echo 'console.log("returnData: "'.$_REQUEST['returnData'].')';
		//exit;
	} else {
		echo 'console.log("returnData: "'.$_REQUEST['returnData'].')';
		//exit;
	}

	echo '</script>';	

	//exit;

	header("Location: "."https://information.hanyang.ac.kr/#/login?returnData=".$_REQUEST['returnData']);
?>

