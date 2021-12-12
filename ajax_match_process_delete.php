<?php
require_once('config_1.php');

if (isset($_POST)) {

  $current_user_id = $_POST['current_user_id'];
  $user_id = $_POST['user_id'];
  $action = '登録';
  $flash_type = 'sucsess';
  $sql = "delete from `match`";

  try {
    $dbh = db_connect();
    $stmt = $dbh->prepare($sql);
  } catch (\Exception $e) {
    error_log($e, 3, "../php/error.log");
    _debug('マッチ失敗');
    echo json_encode("error");
  }
}

?>

<?php
require_once('footer.php');