<?php
require_once('../config_1.php');

$user_class = new User($_SESSION['user_id']);
$current_user = $user_class->get_user();
$chats = get_chats();
?>

<body>
    <div class="row">
        <div class="col-8 offset-2">
            <div class="message">
                <h2 class="center">チャットルーム</h2>
                <?php
                foreach ($chats as $chat) :
                ?>
                <div class="my_message">
                    <?php if ($chat['user_id'] == $current_user['id']) : ?>
                    <div class="mycomment right">
                        <span class="message_created_at">
                            <?= convert_to_fuzzy_time($chat['created_at']) ?>
                        </span>
                        <p><?= $chat['text'] ?>
                            <?php if (!empty($chat['image'])) : ?>
                            <img src="image/<?= $chat['image'] ?>">
                            <?php endif; ?>
                        </p><img src="../user/image/<?= $current_user['image'] ?>" class="message_user_img">
                    </div>
                    <?php else : ?>
                    <?php $destination_user = get_user($chat['user_id']); ?>
                    <div class="left"><img src="../user/image/<?= $destination_user['image'] ?>"
                            class="message_user_img">
                        <div class="says"><?= $chat['text'] ?>
                            <?php if (!empty($chat['image'])) : ?>
                            <img src="image/<?= $chat['image'] ?>">
                            <?php endif; ?>
                        </div><span class="message_created_at"><?= convert_to_fuzzy_time($chat['created_at']) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endforeach ?>

                    <div class="message_process">
                        <h2 class="message_title">チャット</h2>
                        <form method="post" action="chat_add.php" enctype="multipart/form-data">
                            <div class="message_text">
                                <textarea id="message_counter" class="textarea form-control" placeholder="文字を入力ください"
                                    name="text"></textarea>
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
                                <button class="btn btn-outline-primary" type="submit" name="post" value="post"
                                    id="post">送信</button>
                            </div>
                            <div class="message_image_detail">
                                <div><img class="my_preview"></div>
                                <i class="far fa-times-circle my_clear"></i>
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