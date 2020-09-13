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
?>