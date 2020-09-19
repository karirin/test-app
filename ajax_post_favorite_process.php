<script src=" https://code.jquery.com/jquery-3.4.1.min.js "></script>
<script src="../js/user_page.js"></script>
<?php
session_start();
session_regenerate_id(true);
require_once('config.php');

//require_once('auth.php');

// $data['debug']=var_export($POST,true);
// print json_encode($data);

  // _debug('', true);
  function _debug( $data, $clear_log = false ) {
    $uri_debug_file = $_SERVER['DOCUMENT_ROOT'] . '/debug.txt';
    if( $clear_log ){
      file_put_contents($uri_debug_file, print_r($data, true));
    }
    file_put_contents($uri_debug_file, print_r($data,true), FILE_APPEND);
    }
    _debug('test');
if(isset($_POST)){

  $current_user = get_user($_SESSION['staff_code']);
  $page_id = $_POST['page_id'];
  $post_id = $_POST['post_id'];

  $profile_user_id = $_POST['page_id'] ?: $current_user['id'];

  //既に登録されているか確認
  if(check_favolite_duplicate($current_user['code'],$post_id)){
    $action = '解除';
    $sql = "DELETE
            FROM favorite
            WHERE :user_id = user_id AND :post_id = post_id";
  }else{
    $action = '登録';
    $sql = "INSERT INTO favorite(user_id,post_id)
            VALUES(:user_id,:post_id)";
  }

  try{
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':user_id' => $current_user['code'] , ':post_id' => $post_id));

  } catch (\Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
    set_flash('error',ERR_MSG1);
    echo json_encode("error");
  }
}

