<?php 
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
?>

<body>

<?php

$comment_text=$_POST['text'];
$comment_image=$_FILES['image'];

$comment_text=htmlspecialchars($comment_text,ENT_QUOTES,'UTF-8');

if($comment_text=='')
{
	print 'コメント内容が入力されていません。<br />';
}
else
{
	print 'コメント内容:';
	print $comment_text;
	print '<br />';
}

if($comment_image['size']>0)
{
	if($comment_image['size']>1000000)
	{
		print '画像が大き過ぎます';
	}
	else
	{
		move_uploaded_file($comment_image['tmp_name'],'./gazou/'.$comment_image['name']);
		print '<img src="./gazou/'.$comment_image['name'].'" style="width:200px">';
		print '<br />';
	}
}

if($comment_text=='' || $comment_image['size']>1000000)
{
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
}
else
{
	print '上記の商品を追加します。<br />';
	print '<form method="post" action="comment_done.php">';
	print '<input type="hidden" name="text" value="'.$comment_text.'">';
	print '<input type="hidden" name="image_name" value="'.$comment_image['name'] .'">';
	print '<br />';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '<input type="submit" value="ＯＫ">';
	print '</form>';
}
require_once('../footer.php');
?>
</body>
</html>
