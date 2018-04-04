<?php
require_once('authorize.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>商品刪除</title>
</head>
<body>
<h1>商品刪除</h1>
<hr>
<?php
if(isset($_GET['goods_id'])&&isset($_GET['goods_name'])&&isset($_GET['goods_price'])&&isset($_GET['goods_image'])&&isset($_GET['goods_date_added'])&&isset($_GET['in_stock'])){
	$goods_id = $_GET['goods_id'] ;
	$goods_name = $_GET['goods_name'] ;
	$goods_price = $_GET['goods_price'] ;
	$goods_image = $_GET['goods_image'] ;
	$goods_date_added = $_GET['goods_date_added'] ;
	$in_stock = $_GET['in_stock'] ;
}

else if(isset($_POST['goods_id'])&&isset($_POST['goods_name'])&&isset($_POST['goods_date_added'])&&isset($_POST['goods_image'])){
	$goods_id = $_POST['goods_id'] ;
	$goods_name = $_POST['goods_name'] ;
	$goods_date_added = $_POST['goods_date_added'] ;
	$goods_image = $_POST['goods_image'] ;
}

else{
	echo '<strong>欲刪除的資料不存在</strong>' ;
}

if(isset($_POST['submit'])){
	if($_POST['confirm'] == 'Yes'){
		@unlink('images/'. $goods_image) ;
		
		$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
		$query = "DELETE FROM goods WHERE goods_id = $goods_id LIMIT 1" ;
		mysqli_query($dbc, $query) ;
		mysqli_close($dbc) ;
		
		echo '<p>商品：' . $goods_name . '</br>ID：' . $goods_id . '</br>加入日期：'. $goods_date_added . '</br></br>已刪除</p>' ;
	}
	
	else{
		echo '你已取消刪除作業' ;
	}
}

else if(isset($goods_id)&&isset($goods_name)&&isset($goods_price)&&isset($goods_image)&&isset($goods_date_added)&&isset($in_stock)) {
	echo '<p><strong>確定要刪除此筆資料?</strong></p>' ;
	echo 'ID：' . $goods_id . '</br>商品名稱：'. $goods_name . '</br>商品價格：'. $goods_price .'</br>加入日期：'. $goods_date_added . '</br>商品庫存：'. $in_stock ; 
	echo '<form method="post" action="goods_remove.php">' ;
	echo '<input type="radio" name="confirm" value="Yes">Yes' ;
	echo '<input type="radio" name="confirm" value="No" checked="checked">No</br>' ;
	echo '<input type="submit" value="刪除" name="submit">' ;
	echo '<input type="hidden" name="goods_id" value="'. $goods_id . '">' ;
	echo '<input type="hidden" name="goods_name" value="'. $goods_name . '">' ;
	echo '<input type="hidden" name="goods_date_added" value="'. $goods_date_added . '">' ;
	echo '<input type="hidden" name="goods_image" value="'. $goods_image . '">' ;
	echo '</form>' ;
}
echo '<hr>' ;
echo '<p><a href="goods_manage.php">回到商品管理頁面</a></p>' ;
?>
</body>
</html>