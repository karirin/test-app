<?php
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
?>
<body>
<?php

$post_id=$_GET['post_id'];

$post = get_post($post_id);
$post_user = get_user($post['user_id']); 
$current_user = get_user($_SESSION['user_id']);

print'<div class="modal modal_close"></div>';
print'<div class="post">';
print'<div class="post_list">';
print'<div class="post_user">';
print'<img src="/user/image/'.$post_user['image'].'">'; 
print''.$post_user['name'].'';
print'</div>';
print'<div class="post_text">';
print''.$post['text'].'';
print'</div>';

if (!empty($post['gazou'])):
print'<img src="/post/gazou/'.$post['gazou'].'" class="post_img" >';
endif;
?>
<div class="post_info">
<div class="post_favorite">
<form class="favorite_count" action="#" method="post">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <button type="button" name="favorite" class="favorite_btn" >
        <?php if (!check_favolite_duplicate($_SESSION['user_id'],$post['id'])): ?>
          いいね
        <?php else: ?>
          いいね解除
        <?php endif; ?>
        </button>
        <span class="post_count"><?= current(get_post_favorite_count($post['id'])) ?></span>
</form>
<a href="../comment/comment_add.php?post_id=<?= $post['id']?>"><i class="fas fa-comment-dots"></i></a>
</div>
<button class="btn delete_btn" data-target="#modal<?= $post['id'] ?>" type="button"><i class="far fa-trash-alt"></i></button>
<div class="delete_confirmation" id="modal<?= $post['id'] ?>">
            <p class="modal_title" >こちらの投稿を削除しますか？</p>
            <p class="post_content"><?= nl2br($post['text']) ?></p>
            <form action="post_delete_done.php" method="post">
              <input type="hidden" name="id" value="<?= $post['id']?>">
              <input type="hidden" name="gazou_name" value="<?= $post['gazou']?>">
              <button class="btn btn-outline-danger" type="submit" name="delete" value="delete">削除</button>
              <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
            </form>
</div>
<?php print''.convert_to_fuzzy_time($post['created_at']).''; ?>
</div>
<?php
$comments = get_comments($post_id);
foreach($comments as $comment):
$comment_user = get_user($comment['user_id']);
print'<div class="comment">';
print'<div class="user_info">';
print'<img src="/user/image/'.$comment_user['image'].'">';
print''.$comment_user['name'].'';
print'</div>';
print''.$comment['text'].'';
print'<button class="btn delete_btn" data-target="#modal'.$comment['id'].'" type="button"><i class="far fa-trash-alt"></i></button>';
print'<div class="delete_confirmation" id="modal'.$comment['id'].'">';
print'<span class="modal_title">こちらのコメントを削除しますか？</span>';
print''.nl2br($comment['text']).'';
print'<form action="../comment/comment_delete_done.php" method="post">';
print'<input type="hidden" name="id" value="'.$comment['id'].'">';
print'<input type="hidden" name="image_name" value="'.$comment['image'].'">';
print'<input type="hidden" name="user_id" value="'.$post_user['id'].'">';
print'<input type="hidden" name="post_id" value="'.$post['id'].'">';
print'<button class="btn btn-outline-danger" type="submit" name="delete" value="delete">削除</button>';
print'<button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>';
print'</form>';
print'</div>';
print''.convert_to_fuzzy_time($comment['created_at']).'</p>';
print'</div>';
endforeach
?>
</div>
</div>
<?php require_once('../footer.php');?>