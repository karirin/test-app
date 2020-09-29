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

スタッフ修正<br />
<br />
スタッフコード<br />
<?php print $user_id; ?>
<br />
<br />
<form method="post" action="user_edit_check.php">
<input type="hidden" name="id" value="<?php print $user_id; ?>">
スタッフ名<br />
<input type="text" name="name" style="width:200px" value="<?php print $user_name;?>"><br />
パスワードを入力してください<br />
<input type="password" name="pass" style="width:100px"><br />
パスワードをもう1度入力してください。<br />
<input type="password" name="pass2" style="width:100px"><br />
<br />
<input type="button" onclick="history.back()"value="戻る">
<input type="submit" value="OK">
</form>
</body>
<?php require_once('../footer.php'); ?>
</html>