<?php
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
require_once('../post_process.php');
$current_user = get_user($_SESSION['user_id']);
$message_relations = get_message_relations($current_user['id']);
foreach ($message_relations as $message_relation):
if($message_relation['destination_user_id']==$current_user['id']){
$destination_user=get_user($message_relation['user_id']);
}else{
$destination_user=get_user($message_relation['destination_user_id']);
}
$bottom_message=get_bottom_message($current_user['id'],$destination_user['id']);
// if(!empty(message_count($current_user['id'],$destination_user['id']))){
$message_count=current(message_count($current_user['id'],$destination_user['id']));
// }else{
// $message_count=0;
// }
_debug('$message_count:     '.$message_count.'     ');
// if(!empty(last_message_count($current_user['id'],$destination_user['id'])/*||last_message_count($current_user['id'],$destination_user['id']))==="0"*/)){
// $last_message=last_message($current_user['id'],$destination_user['id']);
$last_bottom_message=get_last_bottom_message($current_user['id'],$destination_user['id']);
// _debug('$last_bottom_message:     '.$last_bottom_message.'     ');
// _debug('$last_messag:       '.print($last_message));
// var_dump($last_message);
$last_message_count=current(last_message_count($current_user['id'],$destination_user['id']));
// _debug('$bottom_message:     '.$bottom_message.'     ');
// _debug('$last_bottom_message:     '.$last_bottom_message.'     ');
// var_dump($bottom_message);
var_dump($last_bottom_message);
if($message_count>$last_message_count){
if($bottom_message['user_id']!=$last_bottom_message['user_id']){
update_message_count($last_message_count,$current_user['id'],$destination_user['id']);
}
}else{
$last_message_count=0;
}

$last_db_message_count = current(last_db_message_count($current_user['id'],$destination_user['id']));
_debug('$last_db_message_count:     '.$last_db_message_count.'     ');

if($bottom_message['destination_user_id']==$current_user['id']){
$current_message_count = $message_count - $last_db_message_count;
}else{
$current_message_count ='';
}
// $current_message_count = $message_count - $last_db_message_count;
_debug('$current_message_count:     '.$current_message_count.'     ');
// }
?>

<body>
    <div class="row">
    <div class="col-8 offset-2">
    <div class="destination_user_list">
    <a href='message.php?user_id=<?= $destination_user['id'] ?>' id="message_link">
    <div class='col-9 destination_user_info'>
    <img src="../user/image/<?= $destination_user['image']?>" class="message_user_img">
    <div class="destination_user_info_detail">
        <div class="destination_user_name"><?= $destination_user['name']?></div>
        <span class="destination_user_text"><?= $bottom_message['text'] ?></span>
</div>

    <div class="message_notification">
        <span id="message_count"><?= $current_message_count ?></span>
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
</div>
</body>
<?php endforeach ?>
<?php require_once('../footer.php'); ?>