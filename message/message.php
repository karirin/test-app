<?php 
require_once('../config.php');
require_once('../head.php'); 
require_once('../header.php');
require_once('../post_process.php');
$user_id = $_SESSION['user_id'];
$destination_id = $_GET['user_id'];
$messages = get_messages($user_id,$destination_id);
$destination_user = get_user($destination_id);
$current_user = get_user($user_id);
?>
<body>
<div class="row">
<div class="col-8 offset-2">
<div class="message">
<h2 class="center"><?= $destination_user['name'] ?></h2>
<?php
foreach($messages as $message):
?>
    <div class="my_message">
      <?php if($message['user_id'] == $user_id): ?>
        <div class="mycomment right"><p><?= $message['text'] ?></p><img src="../user/image/<?= $current_user['image'] ?>" class="message_user_img"></div>
      <?php else: ?>
        <div class="left"><img src="../user/image/<?= $destination_user['image'] ?>" class="message_user_img"><div class="says"><?= $message['text'] ?></div>
      <?php endif; ?>  
    </div>
<?php endforeach ?>

<div class="message_process">
  <h2 class="message_title">メッセージ</h2>
  <form method="post" action="../message/message_add.php" enctype="multipart/form-data">
  <textarea class="textarea form-control" placeholder="メッセージを入力ください" name="text"></textarea>
  <div class="counter">
                <span class="show_count">0</span><span>/300</span>
  </div>
  <div class="message_image">
  <label>
  <i class="far fa-image"></i>
  <input type="file" name="image" class="myImage" accept="image/*" multiple>
  </label>
  <p><img class="preview"></p>
  </div>
  <input type="hidden" name="destination_id" value="<?= $destination_id ?>">
  <div class="message_btn">
  <button class="btn btn-outline-danger" type="submit" name="post" value="post" id="post">投稿</button>
  <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
  </div>
  </form>
      </div>
</body>
<?php require_once('../footer.php'); ?>
<script>
  $(window).on('load', function() {
    $('html, body').scrollTop($(document).height());
  });
  </script>

