<?php
	session_start();

	if (!isset($_GET['returnData'])) {
		die("ReturnData not set.");
	}
	$_SESSION['returnData'] = $_GET['returnData'];

	header("Location: login.php");
	die();

    /* Created by EBSCO LSE. Please contact support@ebsco.com if any question */

?>
