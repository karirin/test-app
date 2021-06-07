<?php

// function db_connect()
// {
//   $dsn = 'mysql:dbname=db;host=localhost;charset=utf8';
//   $user = 'root';
//   $password = '';
//   $dbh = new PDO($dsn, $user, $password);
//   $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   return $dbh;
// }

// function _debug($data, $clear_log = false)
// {
//   $uri_debug_file = $_SERVER['DOCUMENT_ROOT'] . '/debug.txt';
//   if ($clear_log) {
//     file_put_contents($uri_debug_file, print_r('', true));
//   }
//   file_put_contents($uri_debug_file, print_r($data, true), FILE_APPEND);
// }

class User
{
  public function __construct($user_id)
  {
    $this->id = $user_id;
  }

  public function get_user()
  {
    try {
      $dbh = db_connect();
      $sql = "SELECT id,name,password,profile,image
    FROM user
    WHERE id = :id";
      $stmt = $dbh->prepare($sql);
      $stmt->execute(array(':id' => $this->id));
      return $stmt->fetch();
    } catch (\Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      set_flash('error', ERR_MSG1);
    }
  }

  public function get_users($type)
  {
    try {
      $dbh = db_connect();

      switch ($type) {
        case 'all':
          $sql = "SELECT *
              FROM user
              ORDER BY id DESC";
          $stmt = $dbh->prepare($sql);
          break;

        case 'follows':
          $sql = "SELECT follower_id
                FROM relation
                WHERE follow_id = :follow_id";
          $stmt = $dbh->prepare($sql);
          $stmt->bindValue(':follow_id', $this->id);
          break;

        case 'followers':
          $sql = "SELECT follow_id
                FROM relation
                WHERE follower_id = :follower_id";
          $stmt = $dbh->prepare($sql);
          $stmt->bindValue(':follower_id', $this->id);
          break;
      }
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (\Exception $e) {
      _debug('複数ユーザー取得失敗');
    }
  }

  public function get_user_count($object)
  {
    $dbh = db_connect();
    switch ($object) {

      case 'favorite':
        $sql = "SELECT COUNT(post_id)
          FROM favorite
          WHERE user_id = :id";
        break;

      case 'post':
        $sql = "SELECT COUNT(id)
            FROM post
            WHERE user_id = :id";
        break;

      case 'comment':
        $sql = "SELECT COUNT(id)
            FROM comment
            WHERE user_id = :id";
        break;

      case 'follow':
        $sql = "SELECT COUNT(follower_id)
          FROM relation
          WHERE follow_id = :id";
        break;

      case 'follower':
        $sql = "SELECT COUNT(follow_id)
          FROM relation
          WHERE follower_id = :id";
        break;

      case 'message':
        $sql = "SELECT COUNT(id)
          FROM message
          WHERE user_id = :id";
        break;

      case 'message_relation':
        $sql = "SELECT COUNT(id)
          FROM message_relation
          WHERE user_id = :id";
        break;
    }
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':id' => $this->id));
    return $stmt->fetch();
  }

  public function update_login_time($date)
  {
    try {
      $dbh = db_connect();
      $dbh->beginTransaction();
      $sql = 'UPDATE user SET login_time = :date WHERE id = :id';
      $stmt = $dbh->prepare($sql);
      $stmt->execute(array(':date' => $date->format('Y-m-d H:i:s'), ':id' => $this->id));
      $dbh->commit();
    } catch (\Exception $e) {
      _debug('ログイン時刻更新失敗');
      $dbh->rollback();
      reload();
    }
  }
}