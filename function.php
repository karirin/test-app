<?php
function set_flash($type,$message){
	$_SESSION['flash']['type'] = "flash_${type}";
	$_SESSION['flash']['message'] = $message;
}

function get_user($user_id){
    try {
      $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
      $user='root';
      $password='';
      $dbh=new PDO($dsn,$user,$password);
      $sql = "SELECT code,name,password
              FROM mst_staff
              WHERE code = :code AND delete_flg = 0 ";
      $stmt = $dbh->prepare($sql);
      $stmt->execute(array(':code' => $user_id));
      return $stmt->fetch();
    } catch (\Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      set_flash('error',ERR_MSG1);
    }
  }

  function get_user_count($object,$user_id){
      $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
      $user='root';
      $password='';
      $dbh=new PDO($dsn,$user,$password);
  
    switch ($object) {

      case 'favorite':
      $sql ="SELECT COUNT(post_id)
            FROM favorite
            WHERE user_id = :id AND delete_flg = 0";
      break;

      case 'follows':
      $sql = "SELECT follower_id
              FROM relation
              WHERE :follow_id = follow_id AND delete_flg = 0
              LIMIT 20 offset :offset_count";
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(':follow_id', $query);
      break;

      case 'followers':
      $sql = "SELECT follow_id
              FROM relation
              WHERE :follower_id = follower_id AND delete_flg = 0
              LIMIT 20 offset :offset_count";
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(':follower_id', $query);
      break;
    }
  
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':id' => $user_id));
    return $stmt->fetch();
  }

//お気に入りの重複チェック
function check_favolite_duplicate($user_id,$post_id){
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    $sql = "SELECT *
            FROM favorite
            WHERE user_id = :user_id AND post_id = :post_id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':user_id' => $user_id ,
                         ':post_id' => $post_id));
    $favorite = $stmt->fetch();
    return $favorite;
}

function get_post_favorite_count($post_id){
  $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
  $user='root';
  $password='';
  $dbh=new PDO($dsn,$user,$password);
  $sql = "SELECT COUNT(user_id)
          FROM favorite
          WHERE post_id = :post_id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute(array(':post_id' => $post_id));
  return $stmt->fetch();
}

//フォロー中かどうか確認している処理
function check_follow($follow_user,$follower_user){
  $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
  $user='root';
  $password='';
  $dbh=new PDO($dsn,$user,$password);
  $sql = "SELECT follow_id,follower_id
          FROM relation
          WHERE :follow_id =follow_id AND :follower_id = follower_id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute(array(':follow_id' => $follow_user,
                       ':follower_id' => $follower_user));
  return  $stmt->fetch();
}

?>