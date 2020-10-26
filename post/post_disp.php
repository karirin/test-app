<?php
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
require_once('../post_process.php');
?>
<body>
<?php

$post_id=$_GET['post_id'];

$post = get_post($post_id);
$post_user = get_user($post['user_id']); 
$current_user = get_user($_SESSION['user_id']);

print'<div class="post">';
print'<div class="post_list">';
print'<div class="post_user">';
print'<object><a href="/user/user_disp.php?user_id='.$current_user['id'].'&page_id='.$post_user['id'].'">';
print'<img src="/user/image/'.$post_user['image'].'">'; 
print''.$post_user['name'].'';
print'</a></object>';
print'</div>';
print'<div class="post_text">';
print''.$post['text'].'';
print'</div>';

if (!empty($post['gazou'])):
print'<img src="/post/gazou/'.$post['gazou'].'" class="post_img" >';
endif;
?>
<div class="post_info">
<form class="favorite_count" action="#" method="post">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <button type="button" name="favorite" class="btn favorite_btn" >
        <?php if (!check_favolite_duplicate($_SESSION['user_id'],$post['id'])): ?>
          <i class="far fa-star"></i>
        <?php else: ?>
          <i class="fas fa-star"></i>
        <?php endif; ?>
        </button>
        <span class="post_count"><?= current(get_post_favorite_count($post['id'])) ?></span>
</form>
<div class="post_comment_count">
<button class="btn modal_btn" data-target="#modal<?= $post['id'] ?>" type="button"><i class="fas fa-comment-dots"></i></button>
<span class="post_comment_count"><?= current(get_post_comment_count($post['id'])) ?></span>
</div>
<div class="comment_confirmation" id="modal<?= $post['id'] ?>">
            <p class="modal_title" >この投稿にコメントしますか？</p>
            <p class="post_content"><?= nl2br($post['text']) ?></p>
            <form method="post" action="../comment/comment_add_done.php" enctype="multipart/form-data">
              <p>コメント内容を入力ください。</p>
              <input type="text" name="text">
              <p>画像を選んでください。</p>
              <input type="file" name="image_name">
              <input type="hidden" name="id" value="<?= $post_id ?>">
              <button class="btn btn-outline-danger" type="submit" name="comment" value="comment">コメント</button>
              <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
            </form>
</div>
<button class="btn modal_btn" data-target="#edit_modal<?= $post['id'] ?>" type="button"><i class="fas fa-edit"></i></button>
<div class="post_edit" id="edit_modal<?= $post['id'] ?>">
投稿内容更新
<form method="post" action="../post/post_edit_done.php" enctype="multipart/form-data">
投稿内容を編集する
<input type="text" name="text" value="<?php print $post['text']; ?>">
<?php
if(!empty($disp)){
print $disp_gazou;
}
?>
画像を選んでください<br />
<input type="file" name="gazou_name" style="width:400px">
<input type="hidden" name="id" value="<?php print $post['id']; ?>">
<input type="hidden" name="gazou_name_old" value="<?php print $post['gazou']; ?>">
<button class="btn btn-outline-danger" type="submit" name="edit" value="edit">削除</button>
<button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
</form>
</div>
<button class="btn modal_btn" data-target="#delete_modal<?= $post['id'] ?>" type="button"><i class="far fa-trash-alt"></i></button>
<div class="delete_confirmation" id="delete_modal<?= $post['id'] ?>">
            <p class="modal_title" >こちらの投稿を削除しますか？</p>
            <p class="post_content"><?= nl2br($post['text']) ?></p>
            <form action="post_delete_done.php" method="post">
              <input type="hidden" name="id" value="<?= $post['id']?>">
              <input type="hidden" name="gazou_name" value="<?= $post['gazou']?>">
              <button class="btn btn-outline-danger" type="submit" name="delete" value="delete">削除</button>
              <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
            </form>
</div>
</div>
<p class="post_created_at"><?php print''.convert_to_fuzzy_time($post['created_at']).''; ?></p>
<?php
$comments = get_comments($post['id']);
foreach($comments as $comment):
if(empty($comment['comment_id'])){
$comment_user = get_user($comment['user_id']);
print'<div class="comment">';
print'<object><a href="/user/user_disp.php?user_id='.$current_user['id'].'&page_id='.$comment_user['id'].'">';
print'<div class="user_info">';
print'<img src="/user/image/'.$comment_user['image'].'">';
print''.$comment_user['name'].'';
print'</div>';
print'</object></a>';
print'<span class="comment_text">'.$comment['text'].'</span>';
if(!empty($comment['image'])){
print'<p class="comment_image"><img src="../comment/image/'.$comment['image'].'"></p>';
}
print'<div class="comment_info">';
print'<button class="btn modal_btn" data-target="#delete_modal'.$comment['id'].'" type="button"><i class="far fa-trash-alt"></i></button>';
print'<div class="delete_confirmation" id="delete_modal'.$comment['id'].'">';
print'<span class="modal_title">こちらのコメントを削除しますか？</span>';
print'<span class="post_content">'.nl2br($comment['text']).'</span>';
print'<form action="../comment/comment_delete_done.php" method="post">';
print'<input type="hidden" name="id" value="'.$comment['id'].'">';
print'<input type="hidden" name="image_name" value="'.$comment['image'].'">';
print'<input type="hidden" name="user_id" value="'.$post_user['id'].'">';
print'<input type="hidden" name="post_id" value="'.$post['id'].'">';
print'<button class="btn btn-outline-danger" type="submit" name="delete" value="delete">削除</button>';
print'<button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>';
print'</form>';
print'</div>';
print'<button class="btn modal_btn" data-target="#reply_modal'.$comment['id'].'" type="button"><i class="fas fa-reply"></i></button>';
print'<span class="post_comment_count">'.current(get_post_comment_count($comment['id'])).'</span>';
print'<div class="reply_comment_confirmation" id="reply_modal'.$comment['id'].'">';
print'<p class="modal_title">このコメントに返信しますか？</p>';
print'<p class="post_content">'.nl2br($comment['text']).'</p>';
print'<form method="post" action="../comment/comment_add_done.php" enctype="multipart/form-data">';
print'<p>コメント内容を入力ください。</p>';
print'<input type="text" name="text">';
print'<p>画像を選んでください。</p>';
print'<input type="file" name="image_name">';
print'<input type="hidden" name="id" value="'.$post_id.'">';
print'<input type="hidden" name="comment_id" value="'.$comment['id'].'">';
print'<button class="btn btn-outline-danger" type="submit" name="comment" value="comment">コメント</button>';
print'<button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>';
print'</form>';
print'</div>';
print'</div>';
print'<span class="comment_created_at">'.convert_to_fuzzy_time($comment['created_at']).'</span>';
print'<div class="reply">';
$reply_comments = get_reply_comments($post['id'],$comment['id']);
foreach($reply_comments as $reply_comment):
if($reply_comment['comment_id']==$comment['id']){
print''.$reply_comment['text'].'';
}
endforeach;
print'</div>';
print'</div>';
}
endforeach
?>
</div>
</div>
<?php require_once('../footer.php');?>