
<script src=" https://code.jquery.com/jquery-3.4.1.min.js "></script>
<script src="../js/user_page.js"></script>
<?php
session_start();
session_regenerate_id(true);
require_once('config.php');
function _debug( $data, $clear_log = false ) {
  $uri_debug_file = $_SERVER['DOCUMENT_ROOT'] . '/debug.txt';
  if( $clear_log ){
    file_put_contents($uri_debug_file, print_r($data, true));
  }
  file_put_contents($uri_debug_file, print_r($data,true), FILE_APPEND);
  }
  
  if(isset($_POST)){
  
  $comment_data = $_POST['comment_data'];
  $user_id = $_POST['user_id'];

  try {
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    $sql = "UPDATE mst_staff
            SET profile = :comment_data
            WHERE code = :user_id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':comment_data' => $comment_data,
                         ':user_id' => $user_id));
    set_flash('sucsess','プロフィールを更新しました');
    echo json_encode('sucsess');
  } catch (\Exception $e) {
    set_flash('error',ERR_MSG1);
  }
  }