<?php

//  デバッグ
function _debug($data, $clear_log = false)
{
  $uri_debug_file = $_SERVER['DOCUMENT_ROOT'] . '/debug.txt';
  if ($clear_log) {
    file_put_contents($uri_debug_file, print_r('', true));
  }
  file_put_contents($uri_debug_file, print_r($data, true), FILE_APPEND);
}

//  複数のユーザーを取得する
function get_users($query)
{
  try {
    $dbh = db_connect();
    $sql = "SELECT *
                FROM user
                WHERE name LIKE CONCAT('%',:input,'%')
                ORDER BY id DESC";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':input', $query);
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (\Exception $e) {
    error_log($e, 3, "error.log");
    _debug('複数ユーザー取得失敗');
  }
}

//  コメントがある投稿か確認する
function check_comment($post_id)
{
  $dbh = db_connect();
  $sql = "SELECT *
          FROM comment
          WHERE post_id = :post_id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute(array(':post_id' => $post_id));
  $favorite = $stmt->fetch();
  return $favorite;
}

//  お気に入りの重複を確認する
function check_favolite_duplicate($user_id, $post_id)
{
  $dbh = db_connect();
  $sql = "SELECT *
          FROM favorite
          WHERE user_id = :user_id AND post_id = :post_id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute(array(
    ':user_id' => $user_id,
    ':post_id' => $post_id
  ));
  $favorite = $stmt->fetch();
  return $favorite;
}

//  チャットを取得する
function get_chats()
{
  try {
    $dbh = db_connect();
    $sql = "SELECT *
            FROM chat";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (\Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
  }
}

//  ページネーション
function pagination_block($data)
{
  global $block;
  $data_count = count($data);
  $block_count = ceil($data_count / 3);
  $k = 0;
  for ($i = 0; $i < $block_count; $i++) {
    for ($j = 0; $j < 3; $j++) {
      if ($data_count == $k) {
        break;
      }
      $block[$i][$j] = $data[$k];
      $k++;
    }
  }
  return $block;
}

//  作成時間を～前で表示する
function convert_to_fuzzy_time($time_db)
{
  ini_set("date.timezone", "Asia/Tokyo");
  $unix = strtotime($time_db);
  $now = strtotime('now');
  $diff_sec   = $now - $unix;

  if ($diff_sec < 60) {
    $time   = $diff_sec;
    $unit   = "秒前";
  } elseif ($diff_sec < 3600) {
    $time   = $diff_sec / 60;
    $unit   = "分前";
  } elseif ($diff_sec < 86400) {
    $time   = $diff_sec / 3600;
    $unit   = "時間前";
  } elseif ($diff_sec < 2764800) {
    $time   = $diff_sec / 86400;
    $unit   = "日前";
  } else {
    if (date("Y") != date("Y", $unix)) {
      $time   = date("Y年n月j日", $unix);
    } else {
      $time   = date("n月j日", $unix);
    }

    return $time;
  }

  return (int)$time . $unit;
}

//  ページを再読み込みする
function reload()
{
  header('Location:' . $_SERVER['HTTP_REFERER']);
  exit();
}

//　フラッシュメッセージ
function set_flash($type, $message)
{
  $_SESSION['flash']['type'] = "flash_${type}";
  $_SESSION['flash']['message'] = $message;
}

function get_message()
{
  try {
    $dbh = db_connect();
    $sql = "SELECT *
      FROM message";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (\Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
  }
}

function check_match($user_id, $current_user_id)
{
  try {
    $dbh = db_connect();
    $sql = "SELECT user_id,match_user_id
        FROM `match`
        WHERE :user_id = user_id AND :match_user_id = match_user_id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(
      ':user_id' => $current_user_id,
      ':match_user_id' => $user_id
    ));
    return  $stmt->fetch();
  } catch (\Exception $e) {
    error_log($e, 3, "error.log");
    _debug('フォロー確認失敗');
  }
}

function check_unmatch($user_id, $current_user_id)
{
  try {
    $dbh = db_connect();
    $sql = "SELECT user_id,match_user_id,`unmatch_flg`
        FROM `match`
        WHERE ((user_id = :user_id and match_user_id = :match_user_id) or (user_id = :match_user_id and match_user_id = :user_id)) and unmatch_flg = 1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(
      ':user_id' => $current_user_id,
      ':match_user_id' => $user_id
    ));
    return  $stmt->fetch();
  } catch (\Exception $e) {
    error_log($e, 3, "error.log");
    _debug('アンマッチ確認失敗');
  }
}

function check_matchs($user_id, $current_user_id)
{
  try {
    $dbh = db_connect();
    $sql = "SELECT user_id,match_user_id
        FROM `match`
        WHERE (user_id = :user_id and match_user_id = :match_user_id) or (user_id = :match_user_id and match_user_id = :user_id)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(
      ':user_id' => $current_user_id,
      ':match_user_id' => $user_id
    ));
    return $stmt->fetchAll();
  } catch (\Exception $e) {
    error_log($e, 3, "error.log");
    _debug('フォロー確認失敗');
  }
}

function get_matchs()
{
  try {
    $dbh = db_connect();
    $sql = "SELECT *
        FROM `match`";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (\Exception $e) {
    error_log($e, 3, "error.log");
    _debug('フォロー確認失敗');
  }
}
