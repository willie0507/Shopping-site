<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>哇哈哈購物</title>
</head>
<body>
<?php
session_start() ;
if(!isset($_SESSION['member_id'])){
	if(isset($_COOKIE['member_id'])) {
		$_SESSION['member_id'] = $_COOKIE['member_id'] ;
	}
}

if(isset($_SESSION['member_id'])){
	echo '<a href="user_edit.php">會員編輯 </a>' ;
	echo '<a href="user_order_manage.php"> 訂單查詢 </a>' ;
	echo '<a href="user_cart.php"> 購物車 </a>' ;
	echo '<a href="logout.php"> 會員登出 </a>' ;
}
else{
	echo '<a href="login.php">會員登入 </a>' ;
	echo '<a href="user_register.php"> 會員註冊</a>' ;
}
$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
$query = "SELECT * FROM goods" ;
$result = mysqli_query($dbc, $query)
	or die('Error querying database.') ;

echo '<table>' ;
echo '<hr>' ;
echo '<tr><th>商品圖片</th><th>商品名稱</th><th>商品描述</th><th>商品價格</th><th>上架日期</th><th></th></tr>' ;
while($row = mysqli_fetch_array($result)) {
	$goods_id = $row['goods_id'] ;
	$goods_name = $row['goods_name'] ;
	$goods_price = $row['goods_price'] ;
	$goods_image = $row['goods_image'] ;
	$goods_date_added = $row['goods_date_added'] ;
	$in_stock = $row['in_stock'] ;
	$goods_date_approved = $row['goods_date_approved'] ;
	$goods_active = $row['goods_active'] ;
	$goods_description = $row['goods_description'] ;
	if($goods_active == 1){
		echo '<tr><td><!--images/'. /*$goods_image .*/ '--></td>' ;
		echo '<td>'. $goods_name . '</td>' ;
		echo '<td>'. $goods_description . '</td>' ;
		echo '<td>'. $goods_price . '</td>' ;
		echo '<td>'. $goods_date_approved . '</td>' ;
		echo '<td>' ;
		if(isset($_SESSION['member_id'])&&$in_stock > 0){
			echo '<a href="add_cart.php?goods_id='. $goods_id . '">加入購物車</a></td></tr>' ;
		}
		else if($in_stock == 0){
			echo '缺貨</td></tr>' ;
		}
	}
}
echo '</table>' ;
echo '<hr>' ;
mysqli_close($dbc) ;
?>
<!--<p><img src="images/99590.jpg" alt="Nice cup"></p>-->
</body>
</html>