<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>訂單查詢</title>
</head>
<body>
<?php
session_start() ;
$member_id = $_SESSION['member_id'] ;
$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
echo '<h1>訂單查詢</h1>' ;
$query = "SELECT * FROM order_form NATURAL JOIN member WHERE member_id = $member_id" ;
$result = mysqli_query($dbc, $query) ;
echo '<hr><table>' ;
echo '<tr><th>訂單編號</th><th>總額</th><th>下單時間</th><th></th></tr>' ;
while($row = mysqli_fetch_array($result)) {
	echo '<tr><td>'. $row['order_id'] . '</td>' ;
	echo '<td>'. $row['total_price'] . '</td>' ;
	echo '<td>'. $row['order_time'] . '</td>' ;
	echo '<td><a href="user_order_goods_manage.php?order_id='.$row['order_id'].'">訂單內容</a></td></tr>' ;
}
echo '</table><hr>' ;
mysqli_close($dbc) ;
?>
<p><a href="index.php">回到首頁</a></p>
</body>
</html>