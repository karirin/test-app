<?php 
require_once('../config.php');
set_flash('sucsess','メッセージリストを削除しました');
header('Location:../user_login/user_top.php?type=main');
require_once('../head.php');
?>
<body>
<?php
try
{

$message_id = $_POST['id'];

$dbh = dbConnect();
$sql = 'DELETE FROM message_relation WHERE id=?';
$stmt = $dbh -> prepare($sql);
$data[] = $message_id;
$stmt -> execute($data);

$dbh = null;

}   
catch (Exception $e)
{
print'ただいま障害により大変ご迷惑をお掛けしております。';
exit();
}

?>

</body>
<?php require_once('../footer.php'); ?>
</html>