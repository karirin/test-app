<?php 
session_start();
@session_regenerate_id(true);

require_once('../db_connect.php');
require_once('../function.php');

if(isset($_SESSION['flash'])){
    $flash_messages = $_SESSION['flash']['message'];
    $flash_type = $_SESSION['flash']['type'];
    }
    unset($_SESSION['flash']);
  
  $error_messages = array();
  
set_flash('sucsess','メッセージリストを削除しました');
reload();
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