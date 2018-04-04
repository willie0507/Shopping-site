<?php
require_once('authorize.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>訂單物品管理頁面</title>
</head>
<body>
<hr>
<?php
$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
if(isset($_POST['submit'])) {
	if($_POST['confirm'] == 'Yes'){
		$goods_id = $_POST['goods_id'] ;
		$order_id = $_POST['order_id'] ;
		$goods_name = $_POST['goods_name'] ;
		$query = "DELETE FROM order_goods WHERE goods_id = $goods_id AND order_id = $order_id LIMIT 1" ;
		mysqli_query($dbc, $query) ;
		echo '訂單物品：'.$goods_name.'已刪除</br>' ;
	}
	else{
		mysqli_close($dbc) ;
		$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/order_goods_manage.php' ;
		header('Location: '. $home_url) ;
	}
}
if(isset($_GET['goods_id'])&&isset($_GET['goods_name'])&&isset($_GET['order_id'])) {
	$goods_id = $_GET['goods_id'] ;
	$goods_name = $_GET['goods_name'] ;
	$order_id = $_GET['order_id'] ;
	echo '確定刪除訂單物品：'.$goods_name.'？' ;
	echo '<form method="post" action="order_goods_manage.php">' ;
	echo '<input type="radio" name="confirm" value="Yes">Yes' ;
	echo '<input type="radio" name="confirm" value="No" checked="checked">No</br>' ;
	echo '<input type="hidden" name="goods_id" value="'.$goods_id.'">' ;
	echo '<input type="hidden" name="order_id" value="'.$order_id.'">' ;
	echo '<input type="hidden" name="goods_name" value="'.$goods_name.'">' ;
	echo '<input type="submit" value="刪除" name="submit">' ;
	echo '</form>' ;
}
$query = "SELECT * FROM ((order_goods NATURAL JOIN goods) NATURAL JOIN order_form) NATURAL JOIN member" ;
$result = mysqli_query($dbc, $query) ;
echo '<table>' ;
echo '<tr><th>訂單編號</th><th>訂貨帳號</th><th>訂貨人</th><th>商品編號</th><th>商品名稱</th><th>下單數量</th><th>下單時間</th><th>動作</th></tr>' ;
while($row = mysqli_fetch_array($result)) {
	echo '<tr><td>'. $row['order_id'] . '</td>' ;
	echo '<td>'. $row['member_username'] . '</td>' ;
	echo '<td>'. $row['member_name'] . '</td>' ;
	echo '<td>'. $row['goods_id'] . '</td>' ;
	echo '<td>'. $row['goods_name'] . '</td>' ;
	echo '<td>'. $row['quantity'] . '</td>' ;
	echo '<td>'. $row['order_time'] . '</td>' ;
	echo '<td><a href="order_goods_manage.php?goods_id='.$row['goods_id'].'&amp;goods_name='.$row['goods_name'].'&amp;order_id='.$row['order_id'].'">刪除</a></td></tr>' ;
}
echo '</table>' ;
mysqli_close($dbc) ;
?>
<hr>
<p><a href="order_manage.php">回到訂單管理頁面</a></p>
</body>
</html>