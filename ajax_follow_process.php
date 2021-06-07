<?php
require_once('config_1.php');

if (isset($_POST)) {

  $user_id = $_POST['user_id'];
  $current_user_id = $_POST['current_user_id'];

  // すでに登録されているか確認して登録、削除のSQL切り替え
  if (check_follow($current_user_id, $user_id)) {
    $action = '解除';
    $flash_type = 'error';
    $sql = "DELETE
              FROM relation
              WHERE :follow_id = follow_id AND :follower_id = follower_id";
  } else {
    $action = '登録';
    $flash_type = 'sucsess';
    $sql = "INSERT INTO relation(follow_id,follower_id)
              VALUES(:follow_id,:follower_id)";
  }
  try {
    $dbh = db_connect();
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':follow_id' => $current_user_id, ':follower_id' => $user_id));
    $return = array(
      'action' => $action,
      'follow_count' => current(get_user_count('follow', $current_user_id)),
      'follower_count' => current(get_user_count('follower', $current_user_id))
    );
    echo json_encode($return);
  } catch (\Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
    _debug('フォロー失敗');
    echo json_encode("error");
  }
}
require_once('footer.php');