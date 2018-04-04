<?php
session_start() ;
$member_id = $_SESSION['member_id'] ;
$goods_id = $_GET['goods_id'] ;
$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
$query = "SELECT goods_id FROM cart WHERE member_id = $member_id AND goods_id = $goods_id" ;
$result = mysqli_query($dbc, $query) ;
if(mysqli_num_rows($result) > 0) {
	$query = "SELECT in_stock FROM goods WHERE goods_id = $goods_id" ;
	$result = mysqli_query($dbc, $query) ;
	$row = mysqli_fetch_array($result) ;
	$in_stock = $row['in_stock'] ;
	$query = "SELECT quantity FROM cart WHERE goods_id = $goods_id" ;
	$result = mysqli_query($dbc, $query) ;
	$row = mysqli_fetch_array($result) ;
	$quantity = $row['quantity'] ;
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php' ;
	if(($quantity + 1) > $in_stock){
		mysqli_close($dbc) ;
		header('Location: ' . $home_url) ;
	}
	else{
		$query = "UPDATE cart SET quantity = quantity + 1 WHERE goods_id = $goods_id LIMIT 1" ;
		mysqli_query($dbc, $query) ;
		mysqli_close($dbc) ;
		header('Location: ' . $home_url) ;
	}
}
else{
	$query = "INSERT INTO cart VALUES (0, $member_id, $goods_id, 1, now())" ;
	mysqli_query($dbc, $query) ;
	mysqli_close($dbc) ;
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php' ;
	header('Location: ' . $home_url) ;
}
?>