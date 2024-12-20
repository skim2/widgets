<?php
	session_start();

	$_SESSION['error'] = "";
	$lib_id=strtolower($_POST['lib_id']);
	$lib_pass=$_POST['lib_pass'];

//Check if the user is valid or not. In this example, the username must be "ebsco" and password must be "password"
	//if( $lib_id !="ebsco" || $lib_pass != "password"){
	//	$_SESSION['error'] = 'Wrong user account or password!';
	//	header("Location: login.php");
	//	die('Error! Wrong user account or password! <a href="login.php">Login again</a>');
	//}

//If the user is valid, prepare the user's attributes and set user_valid is 1
	//$displayname = '김성훈';
	//$email = 'skim2@ebsco.com';
	//$first_name = 'Seonghoon';
	//$last_name = 'Kim';
	//$department = 'GSS';
    //$user_valid = 1 ;
	$displayname = '김성훈';	
	$first_name = '성훈';
	$last_name = '김';
	$department = '엡스코';
	$email = 'skim2@ebsco.com';
	$permissionSets = '[#default]';
    $user_valid = 1 ;
	

//Load OpenAthens Config and prepare user object in OpenAthens 
	include('oa_config.php');
	$user_uid = $lib_id;
	$user_attributes = [];
	$user_attributes["forenames"] = $first_name;
	$user_attributes["surname"] = $last_name;	
	$user_attributes["emailAddress"] = $email;	
	$user_attributes["department"] = $department;
	$user_attributes["permissionSets"] = $permissionSets;

//check if there is any returnData from SP(service provider)
	if(isset( $_SESSION['returnData'] )){
		$user_returnData = $_SESSION['returnData'];
	}else{
		$user_returnData = "";
	}

	//If user is valid, start the OpenAthens session
	if ($user_valid == 1) {
		$request_json = [];
		$request_json["connectionID"] = $oa_connectionid;
		//$request_json["uniqueUserIdentifier"] = $user_uid;
		$request_json["uniqueUserIdentifier"] = "shkim1st";
		$request_json["displayName"] = 'shkim1st';
		if (strlen($displayname) > 0) {
			$request_json["displayName"] = $displayname ;
		} else {
			$request_json["displayName"] = "Anonymous";
		}

	//If there is No returnData, redirect the user to MyAthens or Library Site
		if(strlen($user_returnData) > 0){
			$request_json["returnData"] = $user_returnData;
		} else {
			$request_json["returnUrl"] = "https://my.openathens.net";
			//$request_json["returnUrl"] = "https://lib.krit.re.kr:8443/";
		}

		$request_json["attributes"] = $user_attributes;
		$data_string = json_encode($request_json);

		$url = $oa_endpoint;

		$session = curl_init($url); 	               // Open the Curl session

		curl_setopt($session, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($session, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($session, CURLOPT_HTTPHEADER, array(
			'Authorization: OAApiKey '.$oa_apikey,
			'Content-type: application/vnd.eduserv.iam.auth.localAccountSessionRequest+json'
		));

		$html = curl_exec($session); // Make the call

		header("Content-Type: text/xml"); // Set the content type appropriately
		curl_close($session); // And close the session

		$redirect_url = json_decode($html);

		// reponse json 이 expiry 와 sessionInitatorUrl 이 확인되면 sessionInitatorUrl 로 다시 호출되어야만 OA session 이 생성
        if (isset($redirect_url->sessionInitiatorUrl) && (strlen($redirect_url->sessionInitiatorUrl) > 0)) {
            header("Location: ".$redirect_url->sessionInitiatorUrl);
        } else {
            die("A. Something went wrong.  No Redirect URL provided by OpenAthens. <a href=\"login.php\">Login again</a>");
        }
	} else {
		die("Something went wrong.  No ReturnData.");
	}

	/* Created by EBSCO LSE. Please contact support@ebsco.com if any question */

?>