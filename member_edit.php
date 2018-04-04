<?php
require_once('authorize.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>會員編輯</title>
</head>
<body>
<?php
if(isset($_GET['member_id'])&&isset($_GET['member_name'])&&isset($_GET['member_username'])){
	$member_id = $_GET['member_id'] ;
	$member_name = $_GET['member_name'] ;
	$member_username = $_GET['member_username'] ;
	
	$output_form = true ;
}
else if(isset($_POST['submit'])){
	$member_id = $_POST['member_id'] ;
	$member_name = $_POST['member_name'] ;
	$member_username = $_POST['member_username'] ;
	$member_password = $_POST['member_password'] ;
	$confirm_password = $_POST['confirm_password'] ;
	
	$output_form = false ;

	if(empty($member_name)||empty($member_username)||empty($member_password)){
		echo '<strong>你好像缺少了什麼資料喔</strong>' ;
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
		$query = "UPDATE member SET member_username = '$member_username' WHERE member_id = $member_id" ;
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
<form method="post" action="member_edit.php">
<fieldset>
姓名：<input type="text" id="member_name" name="member_name" value="<?php if(!empty($member_name)) echo $member_name ;?>"></br>
帳號：<input type="text" id="member_username" name="member_username" value="<?php if(!empty($member_username)) echo $member_username ;?>"></br>
密碼：<input type="password" id="member_password" name="member_password"></br>
確認密碼：<input type="password" id="confirm_password" name="confirm_password"></br>
</fieldset>
<input type="hidden" name="member_id" value="<?php echo $member_id ; ?>">
<hr>
<input type="submit" name="submit" value="送出">
</form>
<?php
}
?>
<p><a href="user_manage.php">回到會員管理頁面</a></p>
</body>
</html>