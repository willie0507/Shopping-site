<?php
if(isset($_POST['quantity'])&&isset($_POST['cart_id'])&&isset($_POST['goods_id'])){
	$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
	$cart_id = $_POST['cart_id'] ;
	$quantity = $_POST['quantity'] ;
	$goods_id = $_POST['goods_id'] ;
	$query = "SELECT in_stock FROM goods WHERE goods_id = $goods_id" ;
	$result = mysqli_query($dbc, $query) ;
	$row = mysqli_fetch_array($result) ;
	if($row['in_stock'] < $quantity){
		$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/user_cart.php?no_in_stock='. TRUE .'&goods_id='. $goods_id ;
		mysqli_close($dbc) ;
		header('Location: ' . $home_url) ;
	}
	else{
		$query = "UPDATE cart SET quantity = $quantity WHERE cart_id = $cart_id" ;
		mysqli_query($dbc, $query) ;
		$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/user_cart.php' ;
		mysqli_close($dbc) ;
		header('Location: ' . $home_url) ;
	}
}
?>