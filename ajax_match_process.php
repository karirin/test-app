<?php
require_once('config_1.php');

if (isset($_POST)) {

  $current_user_id = $_POST['current_user_id'];
  $user_id = $_POST['user_id'];
  $action = '登録';
  $flash_type = 'sucsess';
  $sql = "INSERT INTO `match`(user_id,match_user_id)
  VALUES(:user_id,:matched_user_id)";
  try {
    $dbh = db_connect();
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':user_id' => $current_user_id, ':matched_user_id' => $user_id));
  } catch (\Exception $e) {
    error_log($e, 3, "../php/error.log");
    _debug('マッチ失敗');
    echo json_encode("error");
  }
}
require_once('footer.php');