<?php
require_once('config_1.php');
if (isset($_POST)) {
  //$user = new User($_SESSION['user_id']);
  // $user = array();
  // $user['id'] = 1;
  // //$current_user = $user->get_user();
  // $message = $_POST['message'];
  $date = new DateTime();
  $date->setTimeZone(new DateTimeZone('Asia/Tokyo'));

  $message = $_POST['message'];

  //$message_image = $_FILES['image'];
  $user_id = $_SESSION['user_id'];
  //_debug($user_id);
  _debug("::::::::::");
  _debug($message);
  //_debug($_POST["image"]);
  _debug("::::::::::");
  $destination_user_id = $_POST['destination_user_id'];
  try {
    $dbh = db_connect();

    //$sql = 'INSERT INTO message(text,image,user_id,destination_user_id,created_at) VALUES (?,?,?,?,?)';
    $sql = 'INSERT INTO message(text,user_id,destination_user_id,created_at) VALUES (?,?,?,?)';
    $stmt = $dbh->prepare($sql);
    $data[] = $message;
    //$data[] = $message_image['name'];
    $data[] = $user_id;
    $data[] = $destination_user_id;

    $data[] = $date->format('Y-m-d H:i:s');

    $stmt->execute($data); //ここでエラーが起きている

    $dbh = null;
    // $message = new Message();
    // if (!$message->check_relation_message($user_id, $destination_user_id)) {
    //   $message->insert_message($user_id, $destination_user_id);
    // } elseif (!$message->check_relation_user_message($user_id, $destination_user_id)) {
    //   $message->insert_user_message($user_id, $destination_user_id);
    // }
    // $message->insert_message_count($user_id, $destination_user_id);
    //set_flash('sucsess', 'メッセージを送信しました');

  } catch (\Exception $e) {
    error_log($e, 3, '../php/error.log');
    _debug('投稿失敗');
    echo json_encode('error');
  }
}
require_once('footer.php');