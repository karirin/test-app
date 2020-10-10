<?php foreach($posts as $post):

$post_user = get_user($post['user_id']); 

print'<div class="post">';
print'<div class="post_text">';
print''.$post['text'].'';
print'</div>';
print'<div class="post_user">';
print'<img src="/user/image/'.$post_user['image'].'">'; 
print''.$post_user['name'].'';
print'</div>';
?>
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
<a href="/post/post_delete.php/post_delete.php?post_id=<?=$post['id']?>">削除</a>
<?php print''.convert_to_fuzzy_time($post['created_at']).''; ?>
<?php print'</div>'; ?>
<?php endforeach ?>