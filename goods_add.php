<?php
require_once('authorize.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>商品加入</title>
</head>
<body>
<?php
if(isset($_POST['submit'])){
	$goods_name = $_POST['goods_name'] ;
	$goods_price = $_POST['goods_price'] ;
	$in_stock = $_POST['in_stock'] ;
	$goods_description = $_POST['goods_description'] ;
	$goods_image = $_FILES['goods_image']['name'] ;
	$output_form = false ;

	if(empty($goods_name)||empty($goods_price)||empty($in_stock)||empty($goods_description)||empty($goods_image)){
		echo '<strong>你好像缺少了什麼資料喔</strong>' ;
		$output_form = true ;
	}
	
	else{
		if(($_FILES['goods_image']['type'] == 'image/pjpeg')||($_FILES['goods_image']['type'] == 'image/jpeg')||($_FILES['goods_image']['type'] == 'image/gif')||($_FILES['goods_image']['type'] == 'image/png')&&
		($_FILES['goods_image']['size'] > 0)&&($_FILES['goods_image']['error'] == 0)){
			$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
			$query = "INSERT INTO goods VALUES (0, '$goods_name', '$goods_price', '$goods_image', now(), NULL , '$goods_description', $in_stock, 0)" ;
			mysqli_query($dbc, $query) ;
			move_uploaded_file($_FILES['goods_image']['tmp_name'], 'images/'.$goods_image) ;
			mysqli_close($dbc) ;
			echo '<h1>商品已加入完成</h1>' ;
			echo '商品名稱：'. $goods_name . '</br>';
			echo '商品價格：'. $goods_price . '</br>';
			echo '商品庫存：'. $in_stock . '</br>';
			echo '商品描述：'. $goods_description . '</br>';
			echo '商品圖片：'. $goods_image. '</br>' ;
		}
		
		else{
			echo '圖片有誤</br>' ;
			echo '<p><a href="goods_manage.php">回到商品管理頁面</a></p>' ;
		}
	}
}

else{
	$output_form = true ;
}

if($output_form){
?>
<h1>商品加入頁面</h1>
<hr>
<form enctype="multipart/form-data" method="post" action="goods_add.php">
商品名稱：<input type="text" name="goods_name"></br>
商品價格：<input type="text" name="goods_price"></br>
商品庫存：<input type="text" name="in_stock"></br>
商品描述：<textarea id="goods_description" name="goods_description"></textarea></br>
商品圖片：<input type="file" id="goods_image" name="goods_image"></br>
<hr>
<input type="submit" name="submit" value="加入商品">
</form>
<?php
}
?>
<p><a href="goods_manage.php">回到商品管理頁面</a></p>
</body>
</html>