<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>購物車</title>
</head>
<body>
<?php
session_start() ;
$member_id = $_SESSION['member_id'] ;
$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
$query = "SELECT * FROM member WHERE member_id = $member_id" ;
$result = mysqli_query($dbc, $query) ;
$row = mysqli_fetch_array($result) ;
echo '<h1>您好！會員 '. $row['member_name'] .'：</a></h1>' ;
echo '<hr>' ;
echo '<table>' ;
echo '<tr><th>商品圖片</th><th>商品名稱</th><th>商品價格</th><th>庫存</th><th>數量變更</th><th>數量</th><th>小計</th><th></th><th></th><th></th></tr>' ;
$query = "SELECT * FROM (goods NATURAL JOIN member) NATURAL JOIN cart WHERE member_id = $member_id" ;
$result = mysqli_query($dbc, $query) ;
$count = 0 ;
$total = 0 ;
$subtotal = 0 ;
while($row = mysqli_fetch_array($result)) {
	$cart_id = $row['cart_id'] ;
	$quantity = $row['quantity'] ;
	echo '<tr><td><!--images/'. /*$row['goods_image'] . */'--></td>' ;
	echo '<td>'. $row['goods_name'] . '</td>' ;
	echo '<td>'. $row['goods_price'] . '</td>' ;
	echo '<td>' ;
	if($row['in_stock'] > 0){
		echo '有</td>' ;
	} 
	else {
		echo '無</td>' ;
	}
	echo '<td><form action="cart_quantity_modify.php" method="post">' ;
	echo '<select name="'.'quantity'.'">' ;
	echo '<option value="' . 1 . '" selected> ' . 1 . '</option>' ;
	for($i = 2 ; $i < 11 ; $i++){
		echo '<option value="' . $i . '"> ' . $i . '</option>' ;
	}
	echo '</select><input type="hidden" name="' .'cart_id'. '" value="'. $cart_id .'"><input type="hidden" name="' .'goods_id'. '" value="'. $row['goods_id'] .'"><input type="submit" value="變更"></form></td>' ;
	echo '<td>'.$quantity.'</td>' ;
	$subtotal = $row['goods_price'] * $quantity ;
	echo '<td>'. $subtotal . '</td>' ;
	echo '<td></td>' ;
	echo '<td><a href="cart_delete.php?cart_id=' . $cart_id . '">刪除</a></td>' ;
	echo '<td>' ;
	if(isset($_GET['no_in_stock'])&&isset($_GET['goods_id'])&&($_GET['no_in_stock'] == 1)&&($_GET['goods_id'] == $row['goods_id'])) {
		echo '<strong> 庫存不足！</strong>' ;
	}
	echo '</td></tr>' ;
	$count = $count + 1 ;
	$total = $total + $subtotal ;
}
echo '</table>' ;
echo '<hr>' ;
echo '購物車內含有 ' . $count . ' 件商品，消費總金額 NT$ ' . $total . ' 元' ;
echo '<a href="checkout.php"> 進入結帳頁面 </a>' ;
mysqli_close($dbc) ;
?>
<!--<form method="post" action="checkout.php">
<input type="hidden" name="goods_id" value="<?php// echo $goods_id ; ?>">-->
<a href="index.php"> 繼續選購 </a>
</body>
</html>