<?php
require_once('config.php');
require_once('head.php');

if(isset($_POST)){

  $follow_id = $_POST['follow_id']; 
  $followed_id = $_POST['followed_id'] ?? $follow_id;

    // すでに登録されているか確認して登録、削除のSQL切り替え
    if(check_follow($follow_id,$followed_id)){
      $action = '解除';
      $flash_type = 'error';
      $sql ="DELETE
              FROM relation
              WHERE :follow_id = follow_id AND :follower_id = follower_id";
    }else{
      $action = '登録';
      $flash_type = 'sucsess';
      $sql ="INSERT INTO relation(follow_id,follower_id)
              VALUES(:follow_id,:follower_id)";
    }
    try {
      $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
      $user='root';
      $password='';
      $dbh=new PDO($dsn,$user,$password);
      $stmt = $dbh->prepare($sql);
      $stmt->execute(array(':follow_id' => $followed_id , ':follower_id' => $follow_id));       
    }    

    catch (\Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      set_flash('error',ERR_MSG1);
      echo json_encode("error");

    }
  }
  require_once('footer.php');
?>