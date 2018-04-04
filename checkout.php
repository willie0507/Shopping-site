<?php
session_start() ;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>確認結帳頁面</title>
</head>
<body>
<?php
$member_id = $_SESSION['member_id'] ;
$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
if(isset($_POST['submit'])&&($_POST['total'])) {
	$query = "SELECT * FROM cart NATURAL JOIN goods WHERE member_id = $member_id" ;
	$result = mysqli_query($dbc, $query) ;
	while($row = mysqli_fetch_array($result)) {
		$quantity_available = false ;
		if($row['quantity'] <= $row['in_stock']){
			$quantity_available = true ;
		}
		else{
			$goods_name = $row['goods_name'] ;
		}
	}
	if($quantity_available) {
		$total_price = $_POST['total'] ;
		$query = "INSERT INTO order_form VALUES (0, $member_id, $total_price, now())" ;
		mysqli_query($dbc, $query) ;
		$query = "SELECT MAX(order_id) FROM order_form" ; // 待修正
		$result = mysqli_query($dbc, $query) ;
		$row = mysqli_fetch_array($result) ;
		$order_id = $row['MAX(order_id)'] ;
		$query = "SELECT * FROM (goods NATURAL JOIN cart) NATURAL JOIN order_form WHERE order_id = $order_id" ;
		$result = mysqli_query($dbc, $query) ;
		while($row = mysqli_fetch_array($result)){
			$goods_id = $row['goods_id'] ;
			$quantity = $row['quantity'] ;
			$query = "INSERT INTO order_goods VALUES ($order_id, $goods_id, $quantity)" ;
			mysqli_query($dbc, $query) ;
			$query = "UPDATE goods SET in_stock = in_stock - $quantity WHERE goods_id = $goods_id" ;
			mysqli_query($dbc, $query) ;
		}
		//$query = "SELECT count(*) FROM (goods NATURAL JOIN cart), order_form WHERE order_id = $order_id" ;
		//$result = mysqli_query($dbc, $query) ;
		//$row = mysqli_fetch_array($result) ;
		//$count = $row ;
		echo '<hr>' ;
		echo '<table>' ;
		echo '<tr><th>商品圖片</th><th>商品名稱</th><th>商品價格</th><th>數量</th><th>小計</th><th></th></tr>' ;
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
			echo '<td>'.$quantity.'</td>' ;
			$subtotal = $row['goods_price'] * $quantity ;
			echo '<td>'. $subtotal . '</td>' ;
			$count = $count + 1 ;
			$total = $total + $subtotal ;
		}
		echo '</table>' ;
		echo '<hr>' ;
		echo '總共 ' . $count . ' 件商品，消費總金額 NT$ ' . $total . ' 元 ' ;
		$query = "DELETE FROM cart WHERE member_id = $member_id" ;
		mysqli_query($dbc, $query) ;
		echo '<h1>已成功結帳！<h1>' ;
		echo '<a href="index.php">返回首頁</a>' ;
	}
	else{
		echo '商品：'.$goods_name.' 庫存不足！</br>' ;
		echo '<a href="user_cart.php">返回購物車</a>' ;
	}
	
}
else{
	echo '<hr>' ;
	echo '<table>' ;
	echo '<tr><th>商品圖片</th><th>商品名稱</th><th>商品價格</th><th>數量</th><th>小計</th><th></th></tr>' ;
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
		echo '<td>'.$quantity.'</td>' ;
		$subtotal = $row['goods_price'] * $quantity ;
		echo '<td>'. $subtotal . '</td>' ;
		$count = $count + 1 ;
		$total = $total + $subtotal ;
	}
	echo '</table>' ;
	echo '<hr>' ;
	echo '總共 ' . $count . ' 件商品，消費總金額 NT$ ' . $total . ' 元 ' ;
	echo '<a href="user_cart.php"> 返回購物車</a>' ;
	echo '<p><form method="post" action="checkout.php">' ;
	echo '<input type="hidden" name="total" value="'. $total .'">' ;
	echo '<input type="submit" name="submit" value="確認結帳"></form></p>' ;
	
}
?>

</body>
</html>