<?php
require_once('authorize.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>商品編輯</title>
</head>
<body>
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
	$output_form = true ;
}
else if(isset($_POST['submit'])){
	$goods_id = $_POST['goods_id'] ;
	$goods_name = $_POST['goods_name'] ;
	$goods_price = $_POST['goods_price'] ;
	$in_stock = $_POST['in_stock'] ;
	$goods_description = $_POST['goods_description'] ;
	if(!empty($_FILES['goods_image']['name'])){
		$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
		$query = "SELECT goods_image FROM goods WHERE goods_id = $goods_id " ;
		$result = mysqli_query($dbc, $query) ;
		$row = mysqli_fetch_array($result) ;
		$pre_goods_image = $row['goods_image'] ;
		$goods_image = $_FILES['goods_image']['name'] ;
		$change_image = true ;
		mysqli_close($dbc) ;
		@unlink('images/'. $pre_goods_image) ;
	}
	else{
		$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
		$query = "SELECT * FROM goods WHERE goods_id = $goods_id " ;
		$result = mysqli_query($dbc, $query) ;
		$row = mysqli_fetch_array($result) ;
		$goods_image = $row['goods_image'] ;
		mysqli_close($dbc) ;
		$change_image = false ;
	}
	$output_form = false ;

	if(empty($goods_name)||empty($goods_price)||empty($in_stock)||empty($goods_description)){
		echo '<strong>你好像缺少了什麼資料喔</strong>' ;
		$output_form = true ;
	}
	
	else{
		if($change_image){
			if(($_FILES['goods_image']['type'] == 'image/pjpeg')||($_FILES['goods_image']['type'] == 'image/jpeg')||($_FILES['goods_image']['type'] == 'image/gif')||($_FILES['goods_image']['type'] == 'image/png')&&
			($_FILES['goods_image']['size'] > 0)&&($_FILES['goods_image']['error'] == 0)){
				$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
				$query = "UPDATE goods SET goods_name = '$goods_name' WHERE goods_id = $goods_id" ;
				mysqli_query($dbc, $query) ;
				$query = "UPDATE goods SET goods_price = $goods_price WHERE goods_id = $goods_id" ;
				mysqli_query($dbc, $query) ;
				$query = "UPDATE goods SET goods_image = '$goods_image' WHERE goods_id = $goods_id" ;
				mysqli_query($dbc, $query) ;
				$query = "UPDATE goods SET goods_description = '$goods_description' WHERE goods_id = $goods_id" ;
				mysqli_query($dbc, $query) ;
				$query = "UPDATE goods SET in_stock = $in_stock WHERE goods_id = $goods_id" ;
				mysqli_query($dbc, $query) ;
				move_uploaded_file($_FILES['goods_image']['tmp_name'], 'images/'.$goods_image) ;
				mysqli_close($dbc) ;
				echo '<h1>商品已編輯完成</h1>' ;
				echo '商品名稱：'. $goods_name . '</br>';
				echo '商品價格：'. $goods_price . '</br>';
				echo '商品庫存：'. $in_stock . '</br>';
				echo '商品描述：'. $goods_description . '</br>';
				echo '商品圖片：<p><img src="images/'. $goods_image. '"></p>' ;
			}
			else{
			echo '圖片有誤</br>' ;
			}
		}
		
		else{
				$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website') ;
				$query = "UPDATE goods SET goods_name = '$goods_name' WHERE goods_id = $goods_id" ;
				mysqli_query($dbc, $query) ;
				$query = "UPDATE goods SET goods_price = $goods_price WHERE goods_id = $goods_id" ;
				mysqli_query($dbc, $query) ;
				$query = "UPDATE goods SET goods_description = '$goods_description' WHERE goods_id = $goods_id" ;
				mysqli_query($dbc, $query) ;
				$query = "UPDATE goods SET in_stock = $in_stock WHERE goods_id = $goods_id" ;
				mysqli_query($dbc, $query) ;
				mysqli_close($dbc) ;
				echo '<h1>商品已編輯完成</h1>' ;
				echo '商品名稱：'. $goods_name . '</br>';
				echo '商品價格：'. $goods_price . '</br>';
				echo '商品庫存：'. $in_stock . '</br>';
				echo '商品描述：'. $goods_description . '</br>';
				echo '商品圖片：<p><img src="images/'. $goods_image. '"></p>' ;
		}
	}
}

else{
	$output_form = true ;
}

if($output_form){
?>
<h1>商品編輯</h1>
<hr>
<form enctype="multipart/form-data" method="post" action="goods_edit.php">
商品名稱：<input type="text" name="goods_name" value="<?php echo $goods_name ; ?>"></br>
商品價格：<input type="text" name="goods_price" value="<?php echo $goods_price ; ?>"></br>
商品庫存：<input type="text" name="in_stock" value="<?php echo $in_stock ; ?>"></br>
商品描述：<textarea id="goods_description" name="goods_description"><?php echo $goods_description ;?></textarea></br>
商品圖片：<input type="file" id="goods_image" name="goods_image"></br>
<input type="hidden" name="goods_id" value="<?php echo $goods_id ; ?>">
<hr>
<input type="submit" name="submit" value="編輯商品">
</form>
<?php
}
?>
<p><a href="goods_manage.php">回到商品管理頁面</a></p>
</body>
</html>