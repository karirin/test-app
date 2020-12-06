<?php
require_once('config.php');
require_once('head.php');

  if(isset($_POST)){
  
  $current_user = get_user($_SESSION['user_id']);
  $name = $_POST['name'];
  $comment_data = $_POST['comment_data'];
  $profile_image_src = $_POST['profile_image_src'];
  $user_id = $_POST['user_id'];
  move_uploaded_file($profile_image_src);

  try {
    $dsn='mysql:dbname=db;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    $sql = "UPDATE user
            SET profile = :comment_data,name = :name,image = :profile_image
            WHERE id = :user_id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':comment_data' => $comment_data,
                         ':name' => $name,
                         ':profile_image' => $profile_image_src,
                         ':user_id' => $user_id));
    _debug($profile_image_src);
    set_flash('sucsess','プロフィールを更新しました');
    echo json_encode('sucsess');
  } catch (\Exception $e) {
    set_flash('error',ERR_MSG1);
  }
  }
  require_once('footer.php');