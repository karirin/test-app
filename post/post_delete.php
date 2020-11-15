<?php require_once('../head.php'); ?>
<body>
<?php

try
{

$post_id=$_GET['post_id'];

$dsn = 'mysql:dbname=db;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT text,image,user_id,created_at FROM post WHERE id=?';
$stmt=$dbh->prepare($sql);
$data[]=$post_id;
$stmt->execute($data);

$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
$post_text = $rec['text'];
$post_image_name = $rec['image'];

$dbh = null;

if($post_image_name=='')
{
    $disp_image='';
}
else
{
    $disp_image='<img src="./image/'.$post_image_name.'">';
}
}
catch(Exception $e)
{
    print'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>

投稿削除<br />
<br />
投稿コード<br />
<?php print $post_id; ?>
<br />
投稿内容<br />
<?php print $post_text;?>
<br />
<?php print $post_image_name;?>
<br />
この投稿を削除してもよろしいでしょうか？<br />
<br />
<form method="post" action="post_delete_done.php?post_id=<?= $post_id ?>">
<input type="hidden" name="id" value="<?= $post_id; ?>">
<input type="hidden" name="image_name" value="<?= $post_image_name; ?>">
<input type="button" onclick="history.back()"value="戻る">
<input type="submit" value="OK">
</form>
</body>
<?php require_once('../footer.php'); ?>
</html>