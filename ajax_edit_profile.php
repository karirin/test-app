<?php
require_once('config_2.php');

if (isset($_POST)) {
  $user = new User($_SESSION['user_id']);
  $current_user = $user->get_user();
  $name = $_POST['user_name'];
  $comment_data = $_POST['user_comment'];
  if (empty($_FILES['image_name']['name'])) {
    $image['name'] = $current_user['image'];
  } else {
    $image = $_FILES['image_name'];
  }
  $user_skill = $_POST['skills'];
  $user_licence = $_POST['licences'];
  $user_id = $_POST['id'];

  if ($name == '') {
    set_flash('danger', '名前が未記入です');
    reload();
  }

  if (!empty($_FILES['image_name']['name'])) {
    if ($image['size'] > 0) {
      if ($image['size'] > 1000000) {
        set_flash('danger', '画像が大きすぎます');
        reload();
      } else {
        move_uploaded_file($image['tmp_name'], 'user/image/' . $image['name']);
      }
    }
  }

  try {
    $dbh = db_connect();
    $sql = "UPDATE user
            SET profile = :comment_data,name = :name,image = :image,skill = :skill,licence = :licence
            WHERE id = :user_id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(
      ':comment_data' => $comment_data,
      ':name' => $name,
      ':image' => $image['name'],
      ':user_id' => $user_id,
      ':skill' => $user_skill,
      ':licence' => $user_licence
    ));
    set_flash('sucsess', 'プロフィールを更新しました');
    reload();
  } catch (\Exception $e) {
    error_log($e, 3, "../../php/error.log");
    _debug('プロフィール更新失敗');
  }
}
require_once('footer.php');