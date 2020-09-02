<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>coffeeapp</title>
</head>
<body>
<?php

try
{


$pro_code=$_GET['procode'];

$dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT name,address,time_start,time_end,gazou FROM mst_product WHERE code=?';
$stmt=$dbh->prepare($sql);
$data[]=$pro_code;
$stmt->execute($data);

$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
$pro_name = $rec['name'];
$pro_address = $rec['address'];
$pro_time_start = $rec['time_start'];
$pro_time_end = $rec['time_end'];
$pro_gazou_name_old =$rec['gazou'];

$dbh = null;

if($pro_gazou_name_old=='')
{
    $disp_gazou='';
}
else
{
    $disp_gazou='<img src="./gazou/'.$pro_gazou_name_old.'" style="width:200px">';
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
<?php print $pro_code; ?>
<br />
<br />
<form method="post" action="pro_edit_check.php" enctype="multipart/form-data">
<input type="hidden" name="code" value="<?php print $pro_code; ?>">
<input type="hidden" name="gazou_name_old" value="<?php print $pro_gazou_name_old; ?>">
店名<br />
<input type="text" name="name" style="width:200px" value="<?php print $pro_name;?>"><br />
住所<br />
<input type="text" name="price" style="width:50px" value="<?php print $pro_address;?>"><br />
<br />
<?php print $disp_gazou; ?>
<br />
画像を選んでください<br />
<input type="file" name="gazou" style="width:400px"><br />
<br />
営業時間
<input type="time" name="time_start" style="width:70px" value="<?php print $pro_time_start;?>">～
<input type="time" name="time_end" style="width:70px" value="<?php print $pro_time_end;?>"><br />
//値が保持されない
<br />
<input type="button" onclick="history.back()"value="戻る">
<input type="submit" value="OK">
</form>
</body>
</html>