<?php
	session_start();
	echo '<script>';
	echo 'console.log("test1")';
	echo '</script>';
?>
<!DOCTYPE html>
<html>
<head>
	<title>EBSCO APAC Demo OpenAthens Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./css/util.css">
	<link rel="stylesheet" type="text/css" href="./css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form class="login100-form validate-form" action="<?php echo htmlspecialchars( "oa_sso_connect.php" ); ?>" method="post">
					<span class="login100-form-title p-b-33">
						
						<img src="./images/ebsco_logo.png" width="80%" alt="SCH MC Library">
						
						<h6>Test login for Inek Inc.</h6>
						
						<h6>Log in with your library account</h6>
					</span>
					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="lib_id" placeholder="Username" required="required">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100 rs1 validate-input">
						<input class="input100" type="password" name="lib_pass" placeholder="Password" required="required">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<br>
					<div id="error" class="error-message" <?php if (empty($_SESSION['error'])){echo('style="display: none;"');} ?> >
						<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
						<p class="error-text">
						<?php echo($_SESSION['error']); $_SESSION['error']=""; ?>
						</p>
					</div>

					<div class="container-login100-form-btn m-t-20">
						<button class="login100-form-btn" type="submit" name="login">
							Sign in
						</button>
					</div>

					<br>
					<br>

					<div class="text-center">						
						<a href="https://my.openathens.net/" class="txt2 hov1" target="_blank">
							<span class="txt1">Login with OpenAthens Account</span>
						</a>
					</div>
					
					<br>
					<br>

					<div class="text-center">
						<a href="https://lib.hanyang.ac.kr" class="txt2 hov1" target="_blank">
							<span class="txt1">한양대학교 백남학술정보관</span>
						</a>
					</div>
					
				</form>
			</div>
		</div>
	</div>

</body>
</html>
