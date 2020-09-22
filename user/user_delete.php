<?php require_once('../head.php'); ?>
<body>
<?php

try
{


$user_id=$_GET['user_id'];

$dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT name FROM user WHERE id=?';
$stmt=$dbh->prepare($sql);
$data[]=$user_id;
$stmt->execute($data);

$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
$user_name = $rec['name'];

$dbh = null;
}
catch(Exception $e)
{
    print'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>

スタッフ削除<br />
<br />
スタッフコード<br />
<?php print $user_id; ?>
<br />
スタッフ名<br />
<?php print $user_name;?>
<br />
このスタッフを削除してもよろしいでしょうか？<br />
<br />
<form method="post" action="user_delete_done.php">
<input type="hidden" name="id" value="<?php print $user_id; ?>">
<input type="button" onclick="history.back()"value="戻る">
<input type="submit" value="OK">
</form>
</body>
</html>