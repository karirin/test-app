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

?>

<body>
    <?php
try
{

$user_id = $_POST['user_id'];
$destination_user_id = $_POST['destination_user_id'];
$dbh = dbConnect();
if(check_relation_delete_message($user_id,$destination_user_id)){
  $sql = 'DELETE FROM message_relation WHERE user_id=?';
  $stmt = $dbh -> prepare($sql);
  $data[] = $user_id;
  $stmt -> execute($data);
  $dbh = null;
}else{
  $sql = 'DELETE FROM message_relation WHERE user_id=?';
  $stmt = $dbh -> prepare($sql);
  $data[] = $user_id;
  $stmt -> execute($data);
  $sql = 'DELETE FROM message WHERE  (user_id = :user_id and destination_user_id = :destination_user_id) or (user_id = :destination_user_id and destination_user_id = :user_id)';
  $stmt = $dbh->prepare($sql);
  $stmt->execute(array(':user_id' => $user_id,
                       ':destination_user_id' => $destination_user_id));
  $dbh = null;
}

set_flash('sucsess','メッセージリストを削除しました');
reload();
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