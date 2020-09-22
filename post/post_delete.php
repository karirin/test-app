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

$sql='SELECT name,gazou FROM post WHERE code=?';
$stmt=$dbh->prepare($sql);
$data[]=$post_id;
$stmt->execute($data);

$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
$post_name = $rec['name'];
$post_gazou_name = $rec['gazou'];

$dbh = null;

if($post_gazou_name=='')
{
    $disp_gazou='';
}
else
{
    $disp_gazou='<img src="./gazou/'.$post_gazou_name.'">';
}
}
catch(Exception $e)
{
    print'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>

商品削除<br />
<br />
商品コード<br />
<?php print $post_id; ?>
<br />
商品名<br />
<?php print $post_name;?>
<br />
<?php print $post_gazou;?>
<br />
この商品を削除してもよろしいでしょうか？<br />
<br />
<form method="post" action="post_delete_done.php">
<input type="hidden" name="code" value="<?php print $post_id; ?>">
<input type="hidden" name="gazou_name" value="<?php print $post_gazou_name; ?>">
<input type="button" onclick="history.back()"value="戻る">
<input type="submit" value="OK">
</form>
</body>
</html>