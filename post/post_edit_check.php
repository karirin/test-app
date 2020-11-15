<?php require_once('../head.php'); ?>
<body>

<?php

$post_id=$_POST['id'];
$post_name=$_POST['name'];
$post_price=$_POST['price'];
$post_image_name_old=$_POST['image_name_old'];
$post_image=$_FILES['image'];

$post_id=htmlspecialchars($post_id,ENT_QUOTES,'UTF-8');
$post_name=htmlspecialchars($post_name,ENT_QUOTES,'UTF-8');
$post_price=htmlspecialchars($post_price,ENT_QUOTES,'UTF-8');

if($post_name=='')
{
	print '商品名が入力されていません。<br />';
}
else
{
	print '商品名:';
	print $post_name;
	print '<br />';
}

if(preg_match('/\A[0-9]+\z/',$post_price)==0)
{
	print '価格をきちんと入力してください。<br />';
}
else
{
	print '価格:';
	print $post_price;
	print '円<br />';
}

if($post_image['size']>0)
{
	if($post_image['size']>1000000)
	{
		print'画像が大き過ぎます。';
	}
	else
	{
		move_uploaded_file($post_image['tmp_name'],'./image/'.$post_image['name']);
		print'<img src="./image/'.$post_image['name'].'">';
		print'<br />';
	}
}

if($post_name=='' || preg_match('/\A[0-9]+\z/',$post_price)==0||$post_image['size']>1000000)
{
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
}
else
{
	print '上記のように変更します。<br />';
	print '<form method="post" action="post_edit_done.php">';
	print '<input type="hidden" name="id" value="'.$post_id.'">';
	print '<input type="hidden" name="name" value="'.$post_name.'">';
	print '<input type="hidden" name="price" value="'.$post_price.'">';
	print '<input type="hidden" name="image_name_old" value="'.$post_image_name_old.'">';
	print '<input type="hidden" name="image_name" value="'.$post_image['name'].'">';
	print '<br />';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '<input type="submit" value="ＯＫ">';
	print '</form>';
}

?>
<?php require_once('../footer.php'); ?>
</body>
</html>