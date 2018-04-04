<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>會員註冊</title>
</head>
<body>
<?php
$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
if(isset($_POST['submit'])) {
	$member_username = mysqli_real_escape_string($dbc, trim($_POST['member_username'])) ;
	$member_password = mysqli_real_escape_string($dbc, trim($_POST['member_password'])) ;
	$confirm_password = mysqli_real_escape_string($dbc, trim($_POST['confirm_password'])) ;
	$member_name = mysqli_real_escape_string($dbc, trim($_POST['member_name'])) ;

	if(!empty($member_username)&&!empty($member_name)&&!empty($member_password)&&!empty($confirm_password)&&($member_password == $confirm_password)) {
		$query = "SELECT * FROM member WHERE member_username = '$member_username'" ;
		$result = mysqli_query($dbc, $query) ;
		if(mysqli_num_rows($result) == 0) {
			$query = "INSERT INTO member VALUES (0,'$member_username', SHA('$member_password'), '$member_name', now())" ;
			mysqli_query($dbc, $query) ;
		
			echo '<p>您已經完成註冊！您好 '. $member_name .' 先生 / 女士！</p>' ;
			mysqli_close($dbc) ;
			echo '<p><a href="index.php">回到首頁</a></p>' ;
			exit() ;
		}
	
		else{
			echo '<strong>您的帳號已有人使用過！</strong>' ;
			$member_username = "" ;
			mysqli_close($dbc) ;
		}
	}
	else{
	echo '<strong>您的資料未填寫完全，或是密碼與密碼確認欄不同！</strong>' ;
	}	
}
?>
<h1>請填寫以下資料以完成註冊</h1>
<form method="post" action="user_register.php">
<fieldset>
姓名：<input type="text" id="member_name" name="member_name" value="<?php if(!empty($member_name)) echo $member_name ;?>"></br>
帳號：<input type="text" id="member_username" name="member_username" value="<?php if(!empty($member_username)) echo $member_username ;?>"></br>
密碼：<input type="password" id="member_password" name="member_password"></br>
確認密碼：<input type="password" id="confirm_password" name="confirm_password"></br>
</fieldset>
<input type="submit" value="註冊" name="submit">
</form>
<p><a href="index.php">回到首頁</a></p>
</body>
</html>