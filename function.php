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
      $sql = "SELECT mst_staff.code,mst_staff.name,mst_staff.password,mst_staff.delete_flg,mst_product.code,mst_product.name,mst_product.address,mst_product.time_start,mst_product.time_end,mst_product.gazou,mst_product.user_id
              FROM mst_staff INNER JOIN mst_product ON mst_staff.code = mst_product.user_id
              WHERE user_id = :id AND delete_flg = 0";
              //inner join ～ on でテーブル同士をくっつけている
              //from xxx inner join xxx にはxxxには結合するテーブル名を指定する
              //on xxx ではxxxに結合するためのカラムの共通の値を指定する
      break;

      //お気に入り登録した投稿を取得する
      case 'favorite':
      $sql = "SELECT mst_staff.code,mst_staff.name,mst_staff.password,mst_staff.delete_flg,mst_product.code,mst_product.name,mst_product.address,mst_product.time_start,mst_product.time_end,mst_product.gazou,mst_product.user_id
              FROM mst_product INNER JOIN favorite ON mst_staff.code = mst_product.code
              INNER JOIN mst_staff ON mst_staff.code = mst_product.user_id
              WHERE user_id = :id";
      break;

      // switch ($type) {
      //   //自分の投稿を取得する
      //   case 'my_post':
      //   $sql = "SELECT u.name,u.user_icon,p.id,p.user_id,p.post_content,p.created_at
      //           FROM users u INNER JOIN posts p ON u.id = p.user_id
      //           WHERE p.user_id = :id AND p.delete_flg = 0
      //           ORDER BY p.created_at DESC
      //           LIMIT 10 OFFSET :offset_count";
      //           //inner join ～ on でテーブル同士をくっつけている
      //           //from xxx inner join xxx にはxxxには結合するテーブル名を指定する
      //           //on xxx ではxxxに結合するためのカラムの共通の値を指定する
      //   break;
  
      //   //お気に入り登録した投稿を取得する
      //   case 'favorite':
      //   $sql = "SELECT u.name,u.user_icon,p.id,p.user_id,p.post_content,p.created_at
      //           FROM posts p INNER JOIN favorite f ON p.id = f.post_id
      //           INNER JOIN users u ON u.id = p.user_id
      //           WHERE f.user_id = :id AND p.delete_flg = 0
      //           ORDER BY f.id DESC
      //           LIMIT 10 OFFSET :offset_count";
      //     break;
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

?>