<?php
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
require_once('../post_process.php');
$current_user = get_user($_SESSION['user_id']);
$destination_user = get_user($_GET['user_id']);
$messages = get_messages($current_user['id'], $destination_user['id']);
$bottom_message=get_bottom_message($current_user['id'],$destination_user['id']);
reset_message_count($current_user['id'],$destination_user['id']);
?>

<body>
  <div class="row">
    <div class="col-8 offset-2">
      <div class="message">
        <h2 class="center"><?= $destination_user['name'] ?></h2>
        <?php
        foreach ($messages as $message) :
        ?>
          <div class="my_message">
            <?php if ($message['user_id'] == $current_user['id']) : ?>
              <div class="mycomment right">
                <span class="message_created_at">
                  <?= convert_to_fuzzy_time($message['created_at']) ?>
                </span>
                <p><?= $message['text'] ?>
                  <?php if (!empty($message['image'])) : ?>
                    <img src="../message/image/<?= $message['image'] ?>">
                  <?php endif; ?></p><img src="../user/image/<?= $current_user['image'] ?>" class="message_user_img">
              </div>
            <?php else : ?>

              <div class="left"><img src="../user/image/<?= $destination_user['image'] ?>" class="message_user_img">
                <div class="says"><?= $message['text'] ?>
                  <?php if (!empty($message['image'])) : ?>
                    <img src="../message/image/<?= $message['image'] ?>">
                  <?php endif; ?>
                </div><span class="message_created_at"><?= convert_to_fuzzy_time($message['created_at']) ?></span>
              <?php endif; ?>
              </div>
            <?php endforeach ?>

            <div class="message_process">
              <h2 class="message_title">メッセージ</h2>
              <form method="post" action="../message/message_add.php" enctype="multipart/form-data">
                <div class="message_text">
                  <textarea id="message_counter" class="textarea form-control" placeholder="メッセージを入力ください" name="text"></textarea>
                  <div class="counter">
                    <span class="message_count">0</span><span>/300</span>
                  </div>
                  <input type="hidden" name="destination_user_id" value="<?= $destination_user['id'] ?>">
                </div>
                <div class="message_btn">
                  <div class="message_image">
                    <label>
                      <i class="far fa-image"></i>
                      <input type="file" name="image" id="my_image" accept="image/*" multiple>
                    </label>
                  </div>
                  <button class="btn btn-outline-primary" type="submit" name="post" value="post" id="post">投稿</button>
                </div>
                <div class="message_image_detail">
                  <div><img class="my_preview"></div>
                  <input type="button" id="my_clear" value="ファイルをクリアする">
                </div>
              </form>
            </div>
          </div>
      </div>
    </div>
</body>
<?php require_once('../footer.php'); ?>
<script>
  $(window).on('load', function() {
    $('html, body').scrollTop($(document).height());
  });
</script>