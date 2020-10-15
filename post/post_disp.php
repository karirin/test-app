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
<a href="/post/post_delete.php/post_delete.php?post_id=<?=$post['id']?>">削除</a>
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
print'<p><a href="/comment/comment_delete.php?comment_id='.$comment['id'].'&user_id='.$current_user['id'].'&post_id='.$post['id'].'">削除</a>';
print''.convert_to_fuzzy_time($comment['created_at']).'</p>';
print'</div>';
endforeach
?>
</div>
</div>
<?php require_once('../footer.php');?>