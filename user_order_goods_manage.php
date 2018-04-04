<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>訂單內容查詢</title>
</head>
<body>
<?php
session_start() ;
$member_id = $_SESSION['member_id'] ;
$order_id = $_GET['order_id'] ;
$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
echo '<h1>訂單編號：'.$order_id.'</h1>' ;
$query = "SELECT * FROM ((order_goods NATURAL JOIN goods) NATURAL JOIN order_form) NATURAL JOIN member WHERE order_id = $order_id AND member_id = $member_id" ;
$result = mysqli_query($dbc, $query) ;
echo '<hr><table>' ;
echo '<tr><th>訂單編號</th><th>商品名稱</th><th>下單數量</th><th>下單時間</th></tr>' ;
while($row = mysqli_fetch_array($result)) {
	echo '<tr><td>'. $order_id . '</td>' ;
	echo '<td>'. $row['goods_name'] . '</td>' ;
	echo '<td>'. $row['quantity'] . '</td>' ;
	echo '<td>'. $row['order_time'] . '</td></tr>' ;
}
echo '</table><hr>' ;
mysqli_close($dbc) ;
?>
<p><a href="user_order_manage.php">回到訂單查詢</a></p>
</body>
</html>