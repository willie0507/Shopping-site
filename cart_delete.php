<?php
session_start() ;
//$member_id = $_SESSION['member_id'] ;
$cart_id = $_GET['cart_id'] ;
$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
$query = "DELETE FROM cart WHERE cart_id = $cart_id" ;
mysqli_query($dbc, $query) ;
$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/user_cart.php' ;
header('Location: ' . $home_url) ;
?>