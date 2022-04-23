<?php
require_once('config_1.php');
_debug($_POST);
if (isset($_POST)) {

  $current_user_id = $_POST['current_user_id'];
  $user_id = $_POST['user_id'];
  $flash_type = 'sucsess';
  $sql1 = "INSERT INTO `match`(user_id,match_user_id)
  VALUES(:user_id,0)";
  $sql2 = "INSERT INTO `match`(user_id,match_user_id)
   VALUES(0,:match_user_id)";
  try {
    $dbh = db_connect();
    $stmt1 = $dbh->prepare($sql1);
    $stmt1->execute(array(':user_id' => $current_user_id));
    $stmt2 = $dbh->prepare($sql2);
    $stmt2->execute(array(':matched_user_id' => $user_id));
  } catch (\Exception $e) {
    error_log($e, 3, "../php/error.log");
    _debug('アンマッチ失敗');
    echo json_encode("error");
  }
}

?>

<?php
require_once('footer.php');