<?php
require_once('../config.php');

$current_user = get_user($_SESSION['user_id']);
$message_relations = get_message_relations($current_user['id']);
foreach ($message_relations as $message_relation):
if($message_relation['destination_user_id']==$current_user['id']){
$destination_user=get_user($message_relation['user_id']);
}else{
$destination_user=get_user($message_relation['destination_user_id']);
}
$new_message=get_new_message($current_user['id'],$destination_user['id']);
$new_message_count=current(new_message_count($current_user['id'],$destination_user['id']));
_debug(new_message_count($current_user['id'],$destination_user['id']));
?>

<body>
    <div class="row">
        <div class="col-8 offset-2">
            <a href='message.php?user_id=<?= $destination_user['id'] ?>' id="message_link">
                <div class="destination_user_list">
                    <div class='col-11 destination_user_info'>
                        <img src="../user/image/<?= $destination_user['image']?>" class="message_user_img">
                        <div class="destination_user_info_detail">
                            <div class="destination_user_name"><?= $destination_user['name']?></div>
                            <div class="destination_user_message_info"><span
                                    class="destination_user_text"><?= $new_message['text'] ?></span>
                                <span id="message_count">
                                    <?php
            if($new_message_count!=0){    
            print''.$new_message_count.'';
            }?>
                                </span>
                            </div>
                        </div>

                        <div class="col-3">
                            <span
                                class="new_message_time"><?= convert_to_fuzzy_time($new_message['created_at']); ?></span>
                        </div>
                    </div>
            </a>
            <button class="btn modal_btn message_list_delete" data-target="#delete_modal<?= $message_relation['id'] ?>"
                type="button" data-toggle="delete" title="削除"><i class="far fa-trash-alt"></i></button>
            <div class="delete_confirmation" id="delete_modal<?= $message_relation['id'] ?>">
                <p class="modal_title">こちらのユーザーとのメッセージを削除しますか？</p>
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
</body>
<?php endforeach ?>
<?php require_once('../footer.php'); ?>