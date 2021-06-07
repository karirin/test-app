<?php
require_once('../config_2.php');

try {

  $user_id = $_POST['user_id'];
  $destination_user_id = $_POST['destination_user_id'];
  $dbh = db_connect();
  if (check_relation_delete_message($user_id, $destination_user_id)) {
    $sql = 'DELETE FROM message_relation WHERE user_id=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $user_id;
    $stmt->execute($data);
    $dbh = null;
  } else {
    $sql = 'DELETE FROM message_relation WHERE user_id=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $user_id;
    $stmt->execute($data);
    $sql = 'DELETE FROM message WHERE  (user_id = :user_id and destination_user_id = :destination_user_id) or (user_id = :destination_user_id and destination_user_id = :user_id)';
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(
      ':user_id' => $user_id,
      ':destination_user_id' => $destination_user_id
    ));
    $dbh = null;
  }

  set_flash('sucsess', 'メッセージリストを削除しました');
  reload();
} catch (Exception $e) {
  _debug("メッセージ削除失敗");
  exit();
}

?>

</body>
<?php require_once('../footer.php'); ?>

</html>