<?php
require_once('authorize.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>會員管理頁面</title>
</head>
<body>
<hr>
<h1><a href="member_add.php">新增會員</a></h1>
<?php
$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website')
	or die('Error to connect to MySQL server.') ;

$query = "SELECT * FROM member" ;
$result = mysqli_query($dbc, $query)
	or die('Error querying database.') ;

echo '<table>' ;
echo '<tr><th>ID</th><th>會員姓名</th><th>會員帳號</th><th>會員密碼</th><th>加入日期</th><th>動作</th></tr>' ;
while($row = mysqli_fetch_array($result)) {
	$member_id = $row['member_id'] ;
	$member_name = $row['member_name'] ;
	$member_username = $row['member_username'] ;
	$member_password = $row['member_password'] ;
	$member_join_date = $row['member_join_date'] ;
	
	echo '<tr><td>'. $member_id . '</td>' ;
	echo '<td>'. $member_name . '</td>' ;
	echo '<td>'. $member_username . '</td>' ;
	echo '<td>'. $member_password . '</td>' ;
	echo '<td>'. $member_join_date . '</td>' ;
	echo '<td>' ;
	echo '<a href="member_edit.php?member_id='. $member_id . '&amp;member_name=' . $member_name . '&amp;member_username=' . $member_username .
	'">編輯</a> / ' ;
	echo '<a href="member_remove.php?member_id='. $member_id . '&amp;member_name=' . $member_name . '&amp;member_username=' . $member_username .
	'">刪除</a></td></tr>' ;
}
echo '</table>' ;
mysqli_close($dbc) ;
?>
<hr>
<p><a href="admin.php">回到系統管理頁面</a></p>
</body>
</html>