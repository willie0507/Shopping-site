<?php
require_once('authorize.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>會員刪除</title>
</head>
<body>
<h1>會員刪除</h1>
<hr>
<?php
if(isset($_GET['member_id'])&&isset($_GET['member_name'])&&isset($_GET['member_username'])){
	$member_id = $_GET['member_id'] ;
	$member_name = $_GET['member_name'] ;
	$member_username = $_GET['member_username'] ;
}

else if(isset($_POST['member_id'])&&isset($_POST['member_name'])&&isset($_POST['member_username'])){
	$member_id = $_POST['member_id'] ;
	$member_name = $_POST['member_name'] ;
	$member_username = $_POST['member_username'] ;
}

else{
	echo '<strong>欲刪除的資料不存在</strong>' ;
}

if(isset($_POST['submit'])){
	if($_POST['confirm'] == 'Yes'){
		$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
		$query = "DELETE FROM member WHERE member_id = $member_id LIMIT 1" ;
		mysqli_query($dbc, $query) ;
		mysqli_close($dbc) ;
		
		echo '<p>會員：' . $member_username . '</br></br>已刪除</p>' ;
	}
	
	else{
		echo '你已取消刪除作業' ;
	}
}

else if(isset($member_id)&&isset($member_name)&&isset($member_username)) {
	echo '<p><strong>確定要刪除此會員?</strong></p>' ;
	echo 'ID：' . $member_id . '</br>會員姓名：'. $member_name . '</br>會員帳號：'. $member_username ; 
	echo '<form method="post" action="member_remove.php">' ;
	echo '<input type="radio" name="confirm" value="Yes">Yes' ;
	echo '<input type="radio" name="confirm" value="No" checked="checked">No</br>' ;
	echo '<input type="submit" value="刪除" name="submit">' ;
	echo '<input type="hidden" name="member_id" value="'. $member_id . '">' ;
	echo '<input type="hidden" name="member_name" value="'. $member_name . '">' ;
	echo '<input type="hidden" name="member_username" value="'. $member_username . '">' ;
	echo '</form>' ;
}
echo '<hr>' ;
echo '<p><a href="user_manage.php">回到會員管理頁面</a></p>' ;
?>
</body>
</html>