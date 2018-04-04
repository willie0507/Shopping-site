<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>會員登入</title>
</head>
<body>
<?php
$error_msg = "" ;
session_start() ;

if(!isset($_SESSION['member_id'])) {
	if(isset($_POST['submit'])) {
		$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
		$member_username = mysqli_real_escape_string($dbc, trim($_POST['member_username'])) ;
		$member_password = mysqli_real_escape_string($dbc, trim($_POST['member_password'])) ;
		
		if(!empty($member_username) && !empty($member_password)) {
			$query = "SELECT member_id, member_username, member_password, member_name FROM member WHERE member_username = '$member_username' AND member_password = SHA('$member_password')" ;
			$result = mysqli_query($dbc, $query) ;
			
			if(mysqli_num_rows($result) == 1) {
				$row = mysqli_fetch_array($result) ;
				$_SESSION['member_id'] = $row['member_id'] ;
				$_SESSION['member_username'] = $row['member_username'] ;
				$_SESSION['member_name'] = $row['member_name'] ;
				setcookie('member_id',$row['member_id'],time()+(60*60*24)) ;
				setcookie('member_username',$row['member_username'],time()+(60*60*24)) ;
				setcookie('member_name',$row['member_name'],time()+(60*60*24)) ;
				$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php' ;
		
				header('Location: '. $home_url) ;
			}
			
			else{
				$error_msg = '帳號密碼有誤！' ;
			}
		}
		
		else{
			$error_msg = '請輸入帳號密碼！' ;
		}
		mysqli_close($dbc) ;
	}
}
?>
<h3>會員登入</h3>
<?php
if(empty($_SESSION['member_id'])) {
	echo '<p><strong>' . $error_msg . '</strong></p>' ;
?>

<form method="post" action="login.php">
<fieldset>
<legend>登入</legend>
帳號：<input type="text" id="member_username" name="member_username" value="<?php /*if(empty($member_username)) echo $member_username ;*/?>"></br>
密碼：<input type="password" id="member_password" name="member_password">
</fieldset>
<input type="submit" value="登入" name="submit">
</form>
還不是會員嗎？<a href="user_register.php">加入會員</a>
<?php
}
else{
	echo '<p><strong>您已登入！'. $_SESSION['member_name'] . ' 先生 / 女士</strong></p>' ;
}
?>
<p><a href="index.php">回到首頁</a></p>
</body>
</html>