<?php
//Function to fetch API responses
function curl_api($remote_url, $headers)
{
    $process = curl_init();
    curl_setopt($process, CURLOPT_URL, $remote_url);
    curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($process, CURLOPT_HEADER, true);
    curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($process);
    curl_close($process);
    return $response;
}

//Begin Session
session_start();

//Redirect to internal page if already logged in
if($_SESSION['oa_login']){
   header("location:https://library.kopri.re.kr/login");
   die;
}

$username = (!isset($_REQUEST["username"]))? "":$_REQUEST["username"];
$password = (!isset($_REQUEST["password"]))? "":$_REQUEST["password"];

//Check username and password
if ($username != '' && $password != '')
{
    $api_key = "d9b01d5c-c074-4764-ad99-08e115cb39f9";
    $remote_url = 'https://admin.openathens.net/api/v1/seha.ae/';
    
    //Authenticate Username and Password 
    
    $headers = array(
        'Content-Type:application/json',
        'Authorization: Basic '. base64_encode("$username:$password") // <---
    );
    $response = curl_api($remote_url, $headers);
    $response_body = explode("{", $response, 2);
    $response_body = "{".$response_body[1];
    
    if (strpos($response, 'HTTP/1.1 401') !== false && $response_body != "")
    {
        $response_json = json_decode($response_body);
        $error_message = $response_json->message;
    }
    else
    {
        //Begin OA login session and redirect to landing page
        $_SESSION['oa_username'] = $username;
        $_SESSION['oa_login'] = true;
        //$remote_url = 'https://login.openathens.net/api/v1/seha.ae/organisation/68694858/account/session?username='.$username.'&returnUrl=http%3A%2F%2Felibrary.seha.ae';
        $remote_url = 'https://login.openathens.net/api/v1/seha.ae/organisation/68694858/account/session?username='.$username.'&returnUrl=http%3A%2F%2Felibrary.seha.ae';
        $headers = array(
            'Content-Type:application/json',
            'Authorization: OAApiKey '.$api_key // <---
        );
        $response = curl_api($remote_url, $headers);
        $response_body = explode("{", $response, 2);
        $response_body = "{".$response_body[1];
        $response_json = json_decode($response_body);
        $redirect_url = $response_json->sessionInitiatorUrl;
        //echo("$redirect_url");
        header("Location: $redirect_url");
    }
}
else
{
    //Do nothing
}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<title>
Seha Remote Access Single Sign On
</title>

<style>
h1{
    color: #3068CC;
}

h5{
    color: red;
}

wrapper {    
	margin-top: 80px;
	margin-bottom: 20px;
}

.form-signin {
  max-width: 420px;
  padding: 30px 38px 66px;
  margin: 0 auto;
  background-color: #eee;
  border: 3px dotted rgba(0,0,0,0.1);  
  }

.form-signin-heading {
  text-align:center;
  margin-bottom: 30px;
}

.form-control {
  position: relative;
  font-size: 16px;
  height: auto;
  padding: 10px;
}

input[type="text"] {
  margin-bottom: 0px;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}

input[type="password"] {
  margin-bottom: 20px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

.btn-primary {
    background-color: #0569B3;
    border-color: #3068CC;
}

.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open>.dropdown-toggle.btn-primary{
    background-color: #3068CC;
    border-color: #3068CC;
}

</style>

<body>
    <center>
        <h1>Abu Dhabi Health Services Company - Seha</br>Remote Access through OpenAthens </h1>
        <hr></hr>
        <img src="http://elibrary.seha.ae/wp-content/uploads/2014/12/cropped-logo-seha-copy-e14192909172331.png" alt="Abu Dhabi Health Services - Seha">
    </center>
    <br>
    <br>
    <div class = "container">
	<div class="wrapper">
		<form action="seha_login.php" method="post" name="Login_Form" class="form-signin" >       
		    <h4 class="form-signin-heading">Access Seha eLibrary</h4>
                <?php if (isset($error_message)) { ?> <h5> <?php echo "$error_message" ?> </h5>
                <?php } ?>
                <input type="text" class="form-control" id="username" name="username" placeholder="Email or Username" required/>
			    <input type="password" readonly id="password" class="form-control" name="password" placeholder="Password" value="" required/>   
                <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit">Login</button> 
                <a href="https://login.openathens.net/auth?t=%2Flogin%3Fr%3Dhttps%253A%252F%252Fauth.athensams.net%252F%253Fath_returl%253D%252522%25252Fmy%252522%2526ath_dspid%253DATHENS.MY&ctx=dsc#forgottenpassword" target="_blank"> Problems Signing In?</a>
		</form>			
	</div>
    </div>

</body>
<script>
$("#username").on('focus', function()
{
    $("#password").removeAttr('readonly');
    console.log("test");
});
</script>
</html>