<?php 
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
?>

<body>

<?php

$post_name=$_POST['name'];
$post_address=$_POST['address'];
$post_time_start=$_POST['time_start'];
$post_time_end=$_POST['time_end'];
$post_gazou=$_FILES['gazou'];

$post_name=htmlspecialchars($post_name,ENT_QUOTES,'UTF-8');
$post_address=htmlspecialchars($post_address,ENT_QUOTES,'UTF-8');
$post_time_start=htmlspecialchars($post_time_start,ENT_QUOTES,'UTF-8');
$post_time_end=htmlspecialchars($post_time_end,ENT_QUOTES,'UTF-8');

if($post_name=='')
{
	print '店名が入力されていません。<br />';
}
else
{
	print '店名:';
	print $post_name;
	print '<br />';
}

if($post_address=='')
{
	print '住所が入力されていません。<br />';
}
else
{
	print '住所:';
	print $post_address;
	print '<br />';
}

if($post_time_start=='' || $post_time_end=='')
{
	print '営業時間が入力されていません。<br />';
}
else
{
	print '営業時間:';
	print $post_time_start;
	print '~';
	print $post_time_end;
	print '<br />';
}

if($post_gazou['size']>0)
{
	if($post_gazou['size']>1000000)
	{
		print '画像が大き過ぎます';
	}
	else
	{
		move_uploaded_file($post_gazou['tmp_name'],'./gazou/'.$post_gazou['name']);
		print '<img src="./gazou/'.$post_gazou['name'].'" style="width:200px">';
		print '<br />';
	}
}

if($post_name=='' || $post_address=='' || $post_time_start=='' || $post_time_end=='' || $post_gazou['size']>1000000)
{
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
}
else
{
	print '上記の商品を追加します。<br />';
	print '<form method="post" action="post_add_done.php">';
	print '<input type="hidden" name="name" value="'.$post_name.'">';
	print '<input type="hidden" name="address" value="'.$post_address.'">';
	print '<input type="hidden" name="time_start" value="'.$post_time_start.'">';
	print '<input type="hidden" name="time_end" value="'.$post_time_end.'">';
	print '<input type="hidden" name="gazou_name" value="'.$post_gazou['name'] .'">';
	print '<br />';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '<input type="submit" value="ＯＫ">';
	print '</form>';
}

?>
</body>
</html>
