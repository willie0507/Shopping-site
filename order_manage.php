<?php
require_once('authorize.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>訂單管理頁面</title>
</head>
<body>
<hr>
<?php
$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
if(isset($_POST['submit'])) {
	if($_POST['confirm'] == 'Yes'){
		$order_id = $_POST['order_id'] ;
		$query = "DELETE FROM order_form WHERE order_id = $order_id LIMIT 1" ;
		mysqli_query($dbc, $query) ;
		$query = "DELETE FROM order_goods WHERE order_id = $order_id" ;
		mysqli_query($dbc, $query) ;
		echo '訂單編號：'.$order_id.'已刪除</br>' ;
	}
	else{
		mysqli_close($dbc) ;
		$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/order_manage.php' ;
		header('Location: '. $home_url) ;
	}
}
if(isset($_GET['order_id'])) {
	$order_id = $_GET['order_id'] ;
	echo '確定刪除訂單：'.$order_id.'？' ;
	echo '<form method="post" action="order_manage.php">' ;
	echo '<input type="radio" name="confirm" value="Yes">Yes' ;
	echo '<input type="radio" name="confirm" value="No" checked="checked">No</br>' ;
	echo '<input type="hidden" name="order_id" value="'.$order_id.'">' ;
	echo '<input type="submit" value="刪除" name="submit">' ;
	echo '</form>' ;
}
$query = "SELECT * FROM order_form NATURAL JOIN member" ;
$result = mysqli_query($dbc, $query) ;
echo '<table>' ;
echo '<tr><th>訂單編號</th><th>訂貨帳號</th><th>訂貨人</th><th>總額</th><th>下單時間</th><th>動作</th></tr>' ;
while($row = mysqli_fetch_array($result)) {
	echo '<tr><td><a href="order_goods_manage.php">'. $row['order_id'] . '</a></td>' ;
	echo '<td>'. $row['member_username'] . '</td>' ;
	echo '<td>'. $row['member_name'] . '</td>' ;
	echo '<td>'. $row['total_price'] . '</td>' ;
	echo '<td>'. $row['order_time'] . '</td>' ;
	echo '<td><a href="order_manage.php?order_id='.$row['order_id'].'">刪除</a></td></tr>' ;
}
echo '</table>' ;
mysqli_close($dbc) ;
?>
<hr>
<p><a href="admin.php">回到系統管理頁面</a></p>
</body>
</html>