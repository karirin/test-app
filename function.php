<?php
function set_flash($type,$message){
	$_SESSION['flash']['type'] = "flash_${type}";
	$_SESSION['flash']['message'] = $message;
}

function _debug( $data, $clear_log = false ) {
	$uri_debug_file = $_SERVER['DOCUMENT_ROOT'] . '/debug.txt';
	if( $clear_log ){
	file_put_contents($uri_debug_file, print_r($data, true));
	}
	file_put_contents($uri_debug_file, print_r($data,true), FILE_APPEND);
  }

function get_user($user_id){
    try {
      $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
      $user='root';
      $password='';
      $dbh=new PDO($dsn,$user,$password);
      $sql = "SELECT id,name,password,profile
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

  function get_users($type){
    try {
      $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
      $user='root';
      $password='';
      $dbh=new PDO($dsn,$user,$password);
  
      switch ($type) {
        case 'all':
        $sql = "SELECT id,name,password,profile
                FROM user
                WHERE delete_flg = 0";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
        break;
      }
    } catch (\Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      set_flash('error',ERR_MSG1);
    }
    _debug($stmt);
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
          WHERE :follow_id =follow_id AND :follower_id = follower_id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute(array(':follow_id' => $follow_user,
                       ':follower_id' => $follower_user));
  return  $stmt->fetch();
}

// ユーザーの投稿を取得する
function get_posts($page_id,$type){
  try {
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    // ページに合わせてSQLを変える
    switch ($type) {
      //自分の投稿を取得する
      case 'my_post':
      $sql = "SELECT user.id,user.name,user.password,user.delete_flg,post.id,post.name,post.address,post.time_start,post.time_end,post.gazou,post.user_id
              FROM user INNER JOIN post ON user.id = post.user_id
              WHERE user_id = :id AND delete_flg = 0";
              //inner join ～ on でテーブル同士をくっつけている
              //from xxx inner join xxx にはxxxには結合するテーブル名を指定する
              //on xxx ではxxxに結合するためのカラムの共通の値を指定する
      break;
      //お気に入り登録した投稿を取得する
      case 'favorite':
      $sql = "SELECT user.id,user.name,user.password,user.delete_flg,post.id,post.name,post.address,post.time_start,post.time_end,post.gazou,post.user_id
              FROM post INNER JOIN favorite ON post.id = favorite.post_id
              INNER JOIN user ON user.id = post.user_id
              WHERE favorite.user_id = :id";
      break;

    }
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $page_id);
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (\Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
    set_flash('error',ERR_MSG1);
  }
}

function change_delete_flg($user_id,$flg){
  try {
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    $dbh->beginTransaction();
    $sql = 'UPDATE user SET delete_flg = :flg WHERE id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':flg' => $flg , ':id' => $user_id));
    
    _debug($user_id);
    $dbh->commit();
  } catch (\Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
    set_flash('error',ERR_MSG1);
    $dbh->rollback();
    reload();
  }
}

?>