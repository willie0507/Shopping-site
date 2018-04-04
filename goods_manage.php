<?php
require_once('authorize.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>商品管理頁面</title>
</head>
<body>
<h1><a href="goods_add.php">新增商品</a></h1>
<hr>
<?php
$dbc = mysqli_connect('localhost', 'root', 'f1234568', 'shopping_website')
	or die('Error to connect to MySQL server.') ;

$query = "SELECT * FROM goods" ;
$result = mysqli_query($dbc, $query)
	or die('Error querying database.') ;

echo '<table>' ;
echo '<tr><th>ID</th><th>商品名稱</th><th>商品價格</th><th>圖片位置</th><th>加入日期</th><th>上架日期</th><th>商品庫存</th><th>動作</th></tr>' ;
while($row = mysqli_fetch_array($result)) {
	$goods_id = $row['goods_id'] ;
	$goods_name = $row['goods_name'] ;
	$goods_price = $row['goods_price'] ;
	$goods_image = $row['goods_image'] ;
	$goods_date_added = $row['goods_date_added'] ;
	$in_stock = $row['in_stock'] ;
	$goods_date_approved = $row['goods_date_approved'] ;
	$goods_active = $row['goods_active'] ;
	echo '<tr><td>'. $goods_id . '</td>' ;
	echo '<td>'. $goods_name . '</td>' ;
	echo '<td>'. $goods_price . '</td>' ;
	echo '<td>images/'. $goods_image . '</td>' ;
	echo '<td>'. $goods_date_added . '</td>' ;
	echo '<td>'. $goods_date_approved . '</td>' ;
	echo '<td>'. $in_stock . '</td>' ;
	echo '<td>' ;
	if($goods_active == 0){
		echo '<a href="approve.php?goods_id='. $goods_id . '&amp;goods_name=' . $goods_name . '&amp;goods_price=' . $goods_price .
	'&amp;goods_image=' . $goods_image . '&amp;goods_date_added=' . $goods_date_added . '&amp;in_stock='. $in_stock . '">上架</a> / ' ;
	}
	else{
		echo '<a href="unapprove.php?goods_id='. $goods_id . '&amp;goods_name=' . $goods_name . '&amp;goods_price=' . $goods_price .
	'&amp;goods_image=' . $goods_image . '&amp;goods_date_added=' . $goods_date_added . '&amp;in_stock='. $in_stock . '">下架</a> / ' ;
	}
	echo '<a href="goods_edit.php?goods_id='. $goods_id . '&amp;goods_name=' . $goods_name . '&amp;goods_price=' . $goods_price .
	'&amp;goods_image=' . $goods_image . '&amp;goods_date_added=' . $goods_date_added . '&amp;in_stock=' . $in_stock . '">編輯</a> / ' ;
	echo '<a href="goods_remove.php?goods_id='. $goods_id . '&amp;goods_name=' . $goods_name . '&amp;goods_price=' . $goods_price .
	'&amp;goods_image=' . $goods_image . '&amp;goods_date_added=' . $goods_date_added . '&amp;in_stock=' . $in_stock . '">刪除</a></td></tr>' ;
}
echo '</table>' ;
mysqli_close($dbc) ;
?>
<hr>
<p><a href="admin.php">回到系統管理頁面</a></p>
</body>
</html>