<?php require_once('../head.php'); ?>
<body>

<?php

$pro_name=$_POST['name'];
$pro_address=$_POST['address'];
$pro_time_start=$_POST['time_start'];
$pro_time_end=$_POST['time_end'];
$pro_gazou=$_FILES['gazou'];

$pro_name=htmlspecialchars($pro_name,ENT_QUOTES,'UTF-8');
$pro_address=htmlspecialchars($pro_address,ENT_QUOTES,'UTF-8');
$pro_time_start=htmlspecialchars($pro_time_start,ENT_QUOTES,'UTF-8');
$pro_time_end=htmlspecialchars($pro_time_end,ENT_QUOTES,'UTF-8');

if($pro_name=='')
{
	print '店名が入力されていません。<br />';
}
else
{
	print '店名:';
	print $pro_name;
	print '<br />';
}

if($pro_address=='')
{
	print '住所が入力されていません。<br />';
}
else
{
	print '住所:';
	print $pro_address;
	print '<br />';
}

if($pro_time_start=='' || $pro_time_end=='')
{
	print '営業時間が入力されていません。<br />';
}
else
{
	print '営業時間:';
	print $pro_time_start;
	print '~';
	print $pro_time_end;
	print '<br />';
}

if($pro_gazou['size']>0)
{
	if($pro_gazou['size']>1000000)
	{
		print '画像が大き過ぎます';
	}
	else
	{
		move_uploaded_file($pro_gazou['tmp_name'],'./gazou/'.$pro_gazou['name']);
		print '<img src="./gazou/'.$pro_gazou['name'].'" style="width:200px">';
		print '<br />';
	}
}

if($pro_name=='' || $pro_address=='' || $pro_time_start=='' || $pro_time_end=='' || $pro_gazou['size']>1000000)
{
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
}
else
{
	print '上記の商品を追加します。<br />';
	print '<form method="post" action="pro_add_done.php">';
	print '<input type="hidden" name="name" value="'.$pro_name.'">';
	print '<input type="hidden" name="address" value="'.$pro_address.'">';
	print '<input type="hidden" name="time_start" value="'.$pro_time_start.'">';
	print '<input type="hidden" name="time_end" value="'.$pro_time_end.'">';
	print '<input type="hidden" name="gazou_name" value="'.$pro_gazou['name'] .'">';
	print '<br />';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '<input type="submit" value="ＯＫ">';
	print '</form>';
}

?>
</body>
</html>
