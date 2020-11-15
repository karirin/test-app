<?php 
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
?>

<body>
<?php

$post_text=$_POST['text'];
$post_image=$_FILES['image'];

$post_text=htmlspecialchars($post_text,ENT_QUOTES,'UTF-8');
if($post_text=='')
{
	print '投稿内容が入力されていません。<br />';
}
else
{
	print '投稿内容:';
	print $post_text;
	print '<br />';
}

if($post_image['size']>0)
{
	if($post_image['size']>1000000)
	{
		print '画像が大き過ぎます';
	}
	else
	{
		move_uploaded_file($post_image['tmp_name'],'./image/'.$post_image['name']);
		print '<img src="./image/'.$post_image['name'].'" style="width:200px">';
		print '<br />';
	}
}

if($post_text=='' || $post_image['size']>1000000)
{
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
}
else
{
	print '上記の商品を追加します。<br />';
	print '<form method="post" action="post_add_done.php">';
	print '<input type="hidden" name="text" value="'.$post_text.'">';
	print '<input type="hidden" name="image_name" value="'.$post_image['name'] .'">';
	print '<br />';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '<input type="submit" value="ＯＫ">';
	print '</form>';
}
require_once('../footer.php');
?>
</body>
</html>
