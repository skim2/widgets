<?php
	session_start();
	echo '<script>';
	echo 'console.log("test1")';
	echo '</script>';
?>
<!DOCTYPE html>
<html>
<head>
	<title>EBSCO APAC OpenAthens Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./css/util.css">
	<link rel="stylesheet" type="text/css" href="./css/main.css">
<!--===============================================================================================-->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script>
		$(document).ready(function() {
			$("form").submit(function(event) {
				alert($("#user_inst_cd option:checked").text());
				alert($("#user_department_cd option:checked").text());
				alert($("#user_position_cd option:checked").text());
				alert($("#user_position_status_cd option:checked").text());
				$("#user_inst").val($("#user_inst_cd option:checked").text());
				$("#user_department").val($("#user_department_cd option:checked").text());
				$("#user_position").val($("#user_position_cd option:checked").text());
				$("#user_position_status").val($("#user_position_status_cd option:checked").text());
				//alert("submit");
			});
			
			$('#login').click(function () {
				$("login").submit();
			});
		});
	</script>
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<!--<form class="login100-form validate-form" action="<?//php echo htmlspecialchars( "oa_sso_connect.php" ); ?>" method="post">-->
				<form class="login100-form validate-form" action="<?php echo htmlspecialchars( "oa_sso_connect_e.php" ); ?>" method="post">
					<input type="hidden" id="user_inst" name="user_inst" value="" />
					<input type="hidden" id="user_department" name="user_department" value="" />
					<input type="hidden" id="user_position" name="user_position" value="" />
					<input type="hidden" id="user_position_status" name="user_position_status" value="" />
					<div class="login100-form-title p-b-33">						
						<img src="./images/hyu_logo.png" width="80%" alt="Hanyang University">						
						<h4>한양대학교<br />ERICA 학술정보관</h4>						
						<p class="fs-18">OpenAthens Authentication API Test</p>
					</div>
					<div>
						<span width="50%">* 소속분관:</span>
						<span class="m-l-5">
							<select id="user_inst_cd" name="user_inst_cd">
								<option value="1">박물관</option>
								<option value="2">창의인재원</option>
								<option value="3">백남학술정보관</option>
								<option value="4">연구소</option>
								<option value="5">법학학술정보관</option>
								<option value="6">의학학술정보관</option>
								<option value="7">단과대학교,기타</option>
								<option value="8">안산교수학습개발센터</option>
								<option value="9" selected>ERICA학술정보관</option>
								<option value="10">음악자료실</option>
								<option value="11">건축학술정보관</option>
							</select>
						</span>						
					</div>
					<br />
					<div>
						<span>* 소속부서:</span>
						<span class="m-l-5">
							<select id="user_department_cd" name="user_department_cd">
								<option value="H0000001">서울 본부</option>
								<option value="H0000343">서울 대학원</option>
								<option value="H0002256">서울 대학</option>
								<option value="H0002987">서울 부속기관</option>
								<option value="H0003475">서울 산학협력단</option>
								<option value="Y0000001">ERICA 본부</option>
								<option value="Y0000177">ERICA 대학원</option>
								<option value="Y0000316" selected>ERICA 대학</option>
								<option value="Y0000763">ERICA 부속기관</option>
								<option value="Y0000926">ERICA 산학협력단</option>
								<option value="H0002998">백남 학술정보관</option>
								<option value="Y0000787">ERICA 학술정보관</option>
								<option value="H0000273">정보통신처</option>
							</select>
						</span>						
					</div>
					<br />
					<div>
						<span>* 이용자신분:</span>
						<span class="m-l-5">
							<select id="user_position_cd" name="user_position_cd">
								<option value="1">학부</option>
								<option value="2">대학원</option>
								<option value="3">직원</option>
								<option value="4">교수(외부)</option>
								<option value="5">사회교육원</option>
								<option value="6">조교</option>
								<option value="7">강사(외부)</option>
								<option value="15">기타</option>
								<option value="20">학부(외부)</option>
								<option value="21">대학원(외부)</option>
								<option value="22">직원(외부)</option>
								<option value="23">교수(외부)</option>
								<option value="24">조료(외부)</option>
								<option value="25">출입</option>
								<option value="26">특별열람03</option>
								<option value="27">특별열람05</option>
								<option value="28">특별열람10</option>
								<option value="29">특별열람30</option>
								<option value="30">상호대차(타대학)</option>
								<option value="31">테스트신분</option>
								<option value="34">강사(외부)</option>
								<option value="35">기부10</option>
								<option value="39">학부(독서인증)</option>
								<option value="36">기부30</option>
							</select>
						</span>												
					</div>
					<br />
					<div>
						<span>* 이용자신분 상태:</span>
						<span class="m-l-5">
							<select id="user_position_status_cd" name="user_position_status_cd">
								<option value="1">재직</option>
								<option value="2">휴직</option>
								<option value="3">퇴직</option>
								<option value="4">정직</option>
								<option value="5">장기출장</option>
								<option value="6">수료</option>
								<option value="7">수료예정</option>
								<option value="8" selected>재학</option>
								<option value="9">일반휴학</option>
								<option value="10">제적/영구수료</option>
								<option value="11">졸업</option>
								<option value="12">정학</option>
								<option value="13">졸업예정</option>
								<option value="14">자퇴</option>
								<option value="15">군휴학</option>
								<option value="16">기타</option>
							</select>
						</span>					
					</div>
					<br />
					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="user_id" placeholder="UserName" required="required">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100 rs1 validate-input">
						<input class="input100" type="password" name="user_pwd" placeholder="Password" required="required">
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
						<button class="login100-form-btn" type="submit" id="login" name="login">
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
					
				</form>
			</div>
		</div>
	</div>

</body>
</html>
