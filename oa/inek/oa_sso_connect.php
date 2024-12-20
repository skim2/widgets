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

	// 도서관 또는 포털의 이용자 인증을 거친 후, OpenAthens 에 전달할 속성들을 저장.
	// 기관과 상의 후, 속성 정보들은 가감될 수 있음.
	$displayname = '김성훈';	
	$first_name = '성훈';
	$last_name = '김';
	$institution = 'EBSCO';
	$department = 'GSS';
	$email = 'shkim1st@gmail.com';
	$permissionSets = '[#default]';
    $user_valid = 1 ; // 인증되었다고 가정
	

	// OpenAthens에 전달할 속성들을 JSON 양식으로 구성. 
	include('oa_config.php');
	$user_uid = $lib_id;
	$user_attributes = [];
	$user_attributes["forenames"] = $first_name;
	$user_attributes["surname"] = $last_name;	
	$user_attributes["emailAddress"] = $email;
	$user_attributes["institution"] = $institution;
	$user_attributes["department"] = $department;
	$user_attributes["postion"] = $department;
	$user_attributes["department"] = $department;
	$user_attributes["permissionSets"] = $permissionSets;

	// Return Data (call back URL) 처리
	if(isset( $_SESSION['returnData'] )){
		$user_returnData = $_SESSION['returnData'];
	}else{
		$user_returnData = "";
	}

	// 도서관/포털 이용자 인증되었다고 가정
	if ($user_valid == 1) {
		$request_json = [];
		$request_json["connectionID"] = $oa_connectionid;
		$request_json["uniqueUserIdentifier"] = $user_uid;
		$request_json["displayName"] = '김성훈';
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
			//$request_json["returnUrl"] = "https://lib.hanyang.ac.kr/#/login";
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
		echo $html;
		exit;

		header("Content-Type: text/xml"); // Set the content type appropriately
		curl_close($session); // And close the session

		$redirect_url = json_decode($html);

		// reponse json 이 expiry 와 sessionInitatorUrl 이 확인되면 sessionInitatorUrl이 웹브라우저로 다시 호출되어야만 OA session 이 생성
        if (isset($redirect_url->sessionInitiatorUrl) && (strlen($redirect_url->sessionInitiatorUrl) > 0)) {
            header("Location: ".$redirect_url->sessionInitiatorUrl);
        } else {
			echo $html;
            //die("A. Something went wrong.  No Redirect URL provided by OpenAthens. <a href=\"login.php\">Login again</a>");
        }
	} else {
		die("Something went wrong.  No ReturnData.");
	}

	/* Created by EBSCO LSE. Please contact support@ebsco.com if any question */

?>