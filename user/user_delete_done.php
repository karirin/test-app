<?php require_once('../head.php'); ?>
<body>

<?php

try
{

$user_id = $_POST['id'];

$dbh = dbConnect();
$sql = 'DELETE FROM user WHERE id=?';
$stmt = $dbh -> prepare($sql);
$data[] = $user_id;
$stmt -> execute($data);

$dbh = null;

}   
catch (Exception $e)
{
print'ただいま障害により大変ご迷惑をお掛けしております。';
exit();
}

?>

削除しました。<br />
<br />
<a href="user_list.php">戻る</a>
</body>
<?php require_once('../footer.php'); ?>
</html>