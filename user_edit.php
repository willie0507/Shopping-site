<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>會員編輯</title>
</head>
<body>
<?php
if(!isset($_POST['submit'])){
session_start() ;
}
if(isset($_SESSION['member_id'])){
	$member_id = $_SESSION['member_id'] ;
	$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
	$query = "SELECT * FROM member WHERE member_id = $member_id" ;
	$result = mysqli_query($dbc, $query) ;
	$row = mysqli_fetch_array($result) ;
	$member_username = $row['member_username'] ;
	$member_name = $row['member_name'] ;
	$member_password = $row['member_password'] ;
	mysqli_close($dbc) ;
	
	$output_form = true ;
	session_unset() ;
}
else if(isset($_POST['submit'])){
	$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
	$member_id = $_POST['member_id'] ;
	$member_name = mysqli_real_escape_string($dbc, trim($_POST['member_name'])) ;
	$member_username = $_POST['member_username'] ;
	$old_password = mysqli_real_escape_string($dbc, trim($_POST['old_password'])) ;
	$member_password = mysqli_real_escape_string($dbc, trim($_POST['member_password'])) ;
	$confirm_password = mysqli_real_escape_string($dbc, trim($_POST['confirm_password'])) ;
	
	$query = "SELECT member_password FROM member WHERE member_id = $member_id" ;
	$result = mysqli_query($dbc, $query) ;
	$row = mysqli_fetch_array($result) ;
	$origin_password = $row['member_password'] ;
	mysqli_close($dbc) ;
	
	$output_form = false ;

	if(empty($member_name)||empty($member_password)||empty($old_password)||empty($confirm_password)){
		echo '<strong>你好像缺少了什麼資料喔</strong>' ;
		$output_form = true ;
	}
	
	else if($origin_password != SHA1($old_password)) {
		echo '<strong>密碼與舊密碼不一致！</strong>' ;
		$output_form = true ;
	}
	
	else if($member_password != $confirm_password){
		echo '<strong>密碼與確認密碼不一致！</strong>' ;
		$output_form = true ;
	}
	
	else{
		$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
		$query = "UPDATE member SET member_name = '$member_name' WHERE member_id = $member_id" ;
		mysqli_query($dbc, $query) ;
		$query = "UPDATE member SET member_password = SHA('$member_password') WHERE member_id= $member_id" ;
		mysqli_query($dbc, $query) ;
		mysqli_close($dbc) ;
		echo '<h1>會員資料已編輯完成</h1>' ;
		echo '會員姓名：'. $member_name . '</br>';
		echo '會員帳號：'. $member_username . '</br>';
		echo '會員密碼：********</br>';
		}
}

else{
	$output_form = true ;
}

if($output_form){
?>
<h1>會員資料編輯</h1>
<hr>
<form method="post" action="user_edit.php">
<fieldset>
帳號：<?php echo $member_username ;?></br>
姓名：<input type="text" id="member_name" name="member_name" value="<?php echo $member_name ;?>"></br>
舊密碼：<input type="password" id="old_password" name="old_password"></br>
新密碼：<input type="password" id="member_password" name="member_password"> 如不需更換密碼，請輸入舊密碼即可</br>
確認密碼：<input type="password" id="confirm_password" name="confirm_password"> 如不需更換密碼，請輸入舊密碼即可</br>
</fieldset>
<input type="hidden" name="member_id" value="<?php echo $member_id ; ?>">
<input type="hidden" name="member_username" value="<?php echo $member_username ; ?>">
<hr>
<input type="submit" name="submit" value="送出">
</form>
<?php
}
?>
<p><a href="index.php">回到首頁</a></p>
</body>
</html>