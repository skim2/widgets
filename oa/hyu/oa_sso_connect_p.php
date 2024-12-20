<?php
	session_start();

	$_SESSION['error'] = "";
	$user_id	= strtolower($_POST['user_id']);
	$user_pwd	= $_POST['user_pwd'];

	$user_inst			= $_POST['user_inst'];
	$user_inst_cd		= $_POST['user_inst_cd'];
	$user_department	= $_POST['user_department'];
	$user_department_cd	= $_POST['user_department_cd'];
	$user_position		= $_POST['user_position'];
	$user_position_cd	= $_POST['user_position_cd'];
	$user_status		= $_POST['user_position_status'];
	$user_status_cd		= $_POST['user_position_status_cd'];

	//Check if the user is valid or not. In this example, the username must be "ebsco" and password must be "password"
	//if( $user_id !="ebsco" || $user_pwd != "password"){
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
	$first_name = '';
	$last_name = '';
	$institution = $user_inst;
	$institution_cd = $user_inst_cd;
	$department = $user_department;
	$department_cd = $user_department_cd;
	$position = $user_position;
	$position_cd = $user_position_cd;
	$pstatus = $user_status;
	$pstatus_cd = $user_status_cd;
	$email = 'test@hanyang.ac.kr';
	$permissionSets = '[]';
	//$permissionSets = '[#default]';
	//$permissionSets = '[#default001]';
    $user_valid = 1 ;
	

	//Load OpenAthens Config and prepare user object in OpenAthens 
	include('oa_config_p.php');
	$user_uid = $user_id;
	$user_attributes = [];
	$user_attributes["forenames"] = $first_name;
	$user_attributes["surname"] = $last_name;	
	$user_attributes["emailAddress"] = $email;
	$user_attributes["institution"] = $institution;			// 소속기관
	$user_attributes["institution_cd"] = $institution_cd;	// 소속기관	코드
	$user_attributes["department"] = $department;			// 부서
	$user_attributes["department_cd"] = $department_cd;		// 부서 코드
	$user_attributes["position"] = $position;				// 신분
	$user_attributes["position_cd"] = $position_cd;			// 신분 코드
	$user_attributes["pstatus"] = $pstatus;					// 신분상태
	$user_attributes["pstatus_cd"] = $pstatus_cd;			// 신분상태 코드
	$user_attributes["permissionSets"] = $permissionSets;

	//$oa_connectionid = $oa_connectionid;
	$url = $oa_endpoint;
	//$oa_apikey = $oa_apikey;

	//echo $oa_connectionid.$url.$oa_apikey;
	//exit;

	// OA Connector
	/**
	if ($user_inst_cd == '9') {
		$oa_connectionid = $oa_connectionid_E;
		$url = $oa_endpoint_E;
		$oa_apikey = $oa_apikey_E;
	}
	else {
		$oa_connectionid = $oa_connectionid_B;
		$url = $oa_endpoint_B;
		$oa_apikey = $oa_apikey_B;
	}
	**/

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
		$request_json["uniqueUserIdentifier"] = $user_uid;
		if (strlen($displayname) > 0) {
			$request_json["displayName"] = $displayname ;
		} else {
			$request_json["displayName"] = "Anonymous";
		}

		//If there is No returnData, redirect the user to MyAthens or Library Site
		if(strlen($user_returnData) > 0){
			$request_json["returnData"] = $user_returnData;
		} else {
			//$request_json["returnUrl"] = "https://my.openathens.net";
			if ($user_inst_cd == '9') {			
				//$request_json["returnUrl"] = "https://information.hanyang.ac.kr/";
				$request_json["returnUrl"] = "https://gssapps.ebscohost.com/skim2/oa/hyu/oa_login_e.php";
			}
			else {
				//$request_json["returnUrl"] = "https://library.hanyang.ac.kr/";
				$request_json["returnUrl"] = "https://gssapps.ebscohost.com/skim2/oa/hyu/oa_login_p.php";
			}
		}

		$request_json["attributes"] = $user_attributes;
		$data_string = json_encode($request_json);

		//$url = $oa_endpoint;

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
		

		// reponse json 이 expiry 와 sessionInitatorUrl 이 확인되면 sessionInitatorUrl 로 다시 호출되어야만 OA session 이 생성
        if (isset($redirect_url->sessionInitiatorUrl) && (strlen($redirect_url->sessionInitiatorUrl) > 0)) {
            header("Location: ".$redirect_url->sessionInitiatorUrl);
        } else {
            die("Something went wrong!  No Redirect URL provided by OpenAthens. <a href=\"https://gssapps.ebscohost.com/skim2/oa/hyu/oa_sso_connect_p.php\">Login again</a>");
        }
	} else {
		die("Something went wrong!  No ReturnData.");
	}

	/* Created by EBSCO LSE. Please contact support@ebsco.com if any question */

?>