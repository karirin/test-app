<?php require_once('../head.php'); ?>
<body>
<?php

try
{


$post_id=$_GET['post_id'];

$dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT name,address,time_start,time_end,gazou FROM mst_postduct WHERE id=?';
$stmt=$dbh->prepare($sql);
$data[]=$post_id;
$stmt->execute($data);

$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
$post_name = $rec['name'];
$post_address = $rec['address'];
$post_time_start = $rec['time_start'];
$post_time_end = $rec['time_end'];
$post_gazou_name_old =$rec['gazou'];

$dbh = null;

if($post_gazou_name_old=='')
{
    $disp_gazou='';
}
else
{
    $disp_gazou='<img src="./gazou/'.$post_gazou_name_old.'" style="width:200px">';
}

}
catch(Exception $e)
{
    print'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>

投稿内容更新<br />
<br />
投稿コード<br />
<?php print $post_id; ?>
<br />
<br />
<form method="post" action="post_edit_check.php" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php print $post_id; ?>">
<input type="hidden" name="gazou_name_old" value="<?php print $post_gazou_name_old; ?>">
店名<br />
<input type="text" name="name" style="width:200px" value="<?php print $post_name;?>"><br />
住所<br />
<input type="text" name="price" style="width:50px" value="<?php print $post_address;?>"><br />
<br />
<?php print $disp_gazou; ?>
<br />
画像を選んでください<br />
<input type="file" name="gazou" style="width:400px"><br />
<br />
営業時間
<input type="time" name="time_start" style="width:70px" value="<?php print $post_time_start;?>">～
<input type="time" name="time_end" style="width:70px" value="<?php print $post_time_end;?>"><br />
//値が保持されない
<br />
<input type="button" onclick="history.back()"value="戻る">
<input type="submit" value="OK">
</form>
</body>
</html>