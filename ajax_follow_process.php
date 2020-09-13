<script src=" https://code.jquery.com/jquery-3.4.1.min.js "></script>
<script src="../js/user_page.js"></script>
<?php
session_start();
session_regenerate_id(true);
require_once('config.php');
//require_once('auth.php');

function _debug( $data, $clear_log = false ) {
	$uri_debug_file = $_SERVER['DOCUMENT_ROOT'] . '/debug.txt';
	if( $clear_log ){
	  file_put_contents($uri_debug_file, print_r($data, true));
	}
	file_put_contents($uri_debug_file, print_r($data,true), FILE_APPEND);
  }

if(isset($_POST)){

  $current_user = get_user($_SESSION['staff_code']);
  _debug('test');
  $follow_id = $_POST['follow_id'];
  $followed_id = $_POST['followed_id'] ?? $follow_id;

    // すでに登録されているか確認して登録、削除のSQL切り替え
    if(check_follow($current_user['code'],$follow_id)){
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
      $stmt->execute(array(':follow_id' => $current_user['code'] , ':follower_id' => $follow_id));


      $return = array('action' => $action,
                      'follow_count' => current(get_user_count('follow', $followed_id)),
                      'follower_count' => current(get_user_count('follower', $followed_id)));
      echo json_encode($return);

    } catch (\Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      set_flash('error',ERR_MSG1);
      echo json_encode("error");
    }
  }
}

