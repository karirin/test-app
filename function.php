<?php
function set_flash($type,$message){
	$_SESSION['flash']['type'] = "flash_${type}";
	$_SESSION['flash']['message'] = $message;
}

function _debug( $data, $clear_log = false ) {
  $uri_debug_file = $_SERVER['DOCUMENT_ROOT'] . '/debug.txt';
  if( $clear_log ){
    file_put_contents($uri_debug_file, print_r('', true));
  }
  file_put_contents($uri_debug_file, print_r($data,true), FILE_APPEND);
}

function get_user($user_id){
    try {
      $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
      $user='root';
      $password='';
      $dbh=new PDO($dsn,$user,$password);
      $sql = "SELECT id,name,password,profile,image
              FROM user
              WHERE id = :id AND delete_flg = 0 ";
      $stmt = $dbh->prepare($sql);
      $stmt->execute(array(':id' => $user_id));
      return $stmt->fetch();
    } catch (\Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      set_flash('error',ERR_MSG1);
    }
  }

function get_users($type,$query){
  try {
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);

    switch ($type) {
      case 'all':
      $sql = "SELECT id
              FROM user
              WHERE delete_flg = 0
              ORDER BY id DESC";
      $stmt = $dbh->prepare($sql);
      break;

      case 'search':
        $sql = "SELECT id
                FROM user
                WHERE name LIKE CONCAT('%',:input,'%') AND delete_flg = 0
                ORDER BY id DESC";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':input', $query);
      break;

      case 'follows':
        $sql = "SELECT follower_id
                FROM relation
                WHERE :follow_id = follow_id AND delete_flg = 0
                ORDER BY id DESC";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':follow_id', $query);
      break;
  
      case 'followers':
        $sql = "SELECT follow_id
                FROM relation
                WHERE :follower_id = follower_id AND delete_flg = 0
                ORDER BY id DESC";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':follower_id', $query);
      break;
    }
    $stmt->execute();
    return $stmt->fetchAll();
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

    case 'post':
      $sql ="SELECT COUNT(id)
            FROM post
            WHERE user_id = :id";
    break;

    case 'follow':
    $sql ="SELECT COUNT(follower_id)
          FROM relation
          WHERE follow_id = :id AND delete_flg = 0";
      break;

    case 'follower':
    $sql ="SELECT COUNT(follow_id)
          FROM relation
          WHERE follower_id = :id AND delete_flg = 0";
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
          WHERE :follower_id =follower_id AND :follow_id = follow_id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute(array(':follow_id' => $follow_user,
                       ':follower_id' => $follower_user));
  return  $stmt->fetch();
}

function get_post($post_id){
  try {
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    $sql = "SELECT *
            FROM post
            WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':id' => $post_id));
    return $stmt->fetch();
  } catch (\Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
    set_flash('error',ERR_MSG1);
  }
}

// ユーザーの投稿を取得する
function get_posts($user_id,$type){
  try {
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    // ページに合わせてSQLを変える
    switch ($type) {
      case 'all':
      $sql = "SELECT *
              FROM post
              ORDER BY created_at DESC";
      break;
      //自分の投稿を取得する
      case 'my_post':
      $sql = "SELECT user.id,user.name,user.password,user.profile,user.delete_flg,post.id,post.gazou,post.text,post.user_id,post.created_at
              FROM user INNER JOIN post ON user.id = post.user_id
              WHERE user_id = :id AND delete_flg = 0
              ORDER BY created_at DESC";
              //inner join ～ on でテーブル同士をくっつけている
              //from xxx inner join xxx にはxxxには結合するテーブル名を指定する
              //on xxx ではxxxに結合するためのカラムの共通の値を指定する
      break;
      //お気に入り登録した投稿を取得する
      case 'favorite':
      $sql = "SELECT user.id,user.name,user.password,user.profile,user.delete_flg,post.id,post.gazou,post.text,post.user_id,post.created_at
              FROM post INNER JOIN favorite ON post.id = favorite.post_id
              INNER JOIN user ON user.id = post.user_id
              WHERE favorite.user_id = :id
              ORDER BY created_at DESC";
      break;
    }
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $user_id);
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (\Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
    set_flash('error',ERR_MSG1);
  }
}

function get_comments($post_id){
  try {
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    $sql = "SELECT *
            FROM comment
            WHERE post_id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':id' => $post_id));
    return $stmt->fetchAll();
  } catch (\Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
    set_flash('error',ERR_MSG1);
  }
}

function change_delete_flg($id,$flg){
  try {
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    $dbh->beginTransaction();
    $sql = 'UPDATE user SET delete_flg = :flg WHERE id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':flg' => $flg , ':id' => $id));
    
    $dbh->commit();
  } catch (\Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
    set_flash('error',ERR_MSG1);
    $dbh->rollback();
    reload();
  }
}

function convert_to_fuzzy_time($time_db){
  ini_set("date.timezone", "Asia/Tokyo");
  $unix = strtotime($time_db);
  $now = strtotime('now');
  $diff_sec   = $now - $unix;

  if($diff_sec < 60){
      $time   = $diff_sec;
      $unit   = "秒前";
  }
  elseif($diff_sec < 3600){
      $time   = $diff_sec/60;
      $unit   = "分前";
  }
  elseif($diff_sec < 86400){
      $time   = $diff_sec/3600;
      $unit   = "時間前";
  }
  elseif($diff_sec < 2764800){
      $time   = $diff_sec/86400;
      $unit   = "日前";
  }
  else{
      if(date("Y") != date("Y", $unix)){
          $time   = date("Y年n月j日", $unix);
      }
      else{
          $time   = date("n月j日", $unix);
      }

      return $time;
  }

  return (int)$time .$unit;
}
?>