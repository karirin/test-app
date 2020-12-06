<?php
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
require_once('../post_process.php');
$current_user = get_user($_SESSION['user_id']);
$message_relations = get_message_relations($current_user['id']);
foreach ($message_relations as $message_relation) :
if($message_relation['destination_user_id']==$current_user['id']){
$destination_user=get_user($message_relation['user_id']);
}else{
$destination_user=get_user($message_relation['destination_user_id']);
}
$bottom_message=get_bottom_message($current_user['id'],$destination_user['id']);
?>

<body>
    <div class="row">
    <div class="col-8 offset-2">
    <div class="destination_user_list">
    <a href='message.php?user_id=<?= $destination_user['id'] ?>'>
    <div class='col-9 destination_user_info'>
    <img src="../user/image/<?= $destination_user['image']?>" class="message_user_img">
    <div class="destination_user_info_detail">
        <div class="destination_user_name"><?= $destination_user['name']?></div>
        <span class="destination_user_text"><?= $bottom_message['text'] ?></span>
</div>
    </div>
    </a>
    <div class="col-3">
    <span class="bottom_message_time"><?= convert_to_fuzzy_time($bottom_message['created_at']); ?></span>
        <button class="btn modal_btn message_list_delete" data-target="#delete_modal<?= $message_relation['id'] ?>" type="button" data-toggle="delete" title="削除"><i class="far fa-trash-alt"></i></button>
<div class="delete_confirmation" id="delete_modal<?= $message_relation['id'] ?>">
            <p class="modal_title" >こちらのユーザーとのメッセージを削除しますか？</p>
            <p class="post_content"><?= nl2br($destination_user['name']) ?></p>
            <form action="message_list_delete.php" method="post">
              <input type="hidden" name="id" value="<?= $message_relation['id']?>">
              <button class="btn btn-outline-danger" type="submit" name="delete" value="delete">削除</button>
              <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
            </form>
</div>
</div>
    </div>
</div>
</div>
<?php endforeach ?>
</body>
<?php require_once('../footer.php'); ?>