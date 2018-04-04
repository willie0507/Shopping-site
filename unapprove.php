<?php
require_once('authorize.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>商品下架</title>
</head>
<body>
<h1>商品下架</h1>
<hr>
<?php
if(isset($_GET['goods_id'])&&isset($_GET['goods_name'])&&isset($_GET['goods_price'])&&isset($_GET['goods_image'])&&isset($_GET['goods_date_added'])&&isset($_GET['in_stock'])){
	$goods_id = $_GET['goods_id'] ;
	$goods_name = $_GET['goods_name'] ;
	$goods_price = $_GET['goods_price'] ;
	$goods_image = $_GET['goods_image'] ;
	$goods_date_added = $_GET['goods_date_added'] ;
	$in_stock = $_GET['in_stock'] ;
	
	$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
	$query = "SELECT goods_description FROM goods WHERE goods_id = $goods_id" ;
	$result = mysqli_query($dbc, $query) ;
	$row = mysqli_fetch_array($result) ;
	$goods_description = $row['goods_description'] ;
	mysqli_close($dbc) ;
}

else if(isset($_POST['goods_id'])){
	$goods_id = $_POST['goods_id'] ;
}

else{
	echo '<strong>欲下架的商品不存在</strong>' ;
}

if(isset($_POST['submit'])){
	if($_POST['confirm'] == 'Yes'){
		$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
		$query = "UPDATE goods SET goods_active = 0 WHERE goods_id = $goods_id" ;
		mysqli_query($dbc, $query) ;
		$query = "UPDATE goods SET goods_date_approved = NULL WHERE goods_id = $goods_id" ;
		mysqli_query($dbc, $query) ;
		mysqli_close($dbc) ;
		
		echo '<strong>商品已完成下架</strong>' ;
	}
	
	else{
		echo '<strong>你已取消下架作業</strong>' ;
	}
}

else if(isset($goods_id)&&isset($goods_name)&&isset($goods_price)&&isset($goods_image)&&isset($goods_date_added)&&isset($in_stock)&&isset($goods_description)) {
	echo '<p><strong>確定要下架?</strong></p>' ;
	echo 'ID：' . $goods_id . '</br>商品名稱：'. $goods_name . '</br>商品價格：'. $goods_price .'</br>加入日期：'. $goods_date_added . '</br>商品庫存：'. $in_stock .
	'<p>商品描述：'. $goods_description . '</p>' . '<p><img src="images/'. $goods_image .'"></p>' ;
	echo '<form method="post" action="unapprove.php">' ;
	echo '<input type="radio" name="confirm" value="Yes">Yes' ;
	echo '<input type="radio" name="confirm" value="No" checked="checked">No</br>' ;
	echo '<input type="submit" value="下架" name="submit">' ;
	echo '<input type="hidden" name="goods_id" value="'. $goods_id . '">' ;
	echo '</form>' ;
}
echo '<hr>' ;
echo '<p><a href="goods_manage.php">回到商品管理頁面</a></p>' ;
?>
</body>
</html>