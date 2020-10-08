<?php foreach($posts as $post):
$post_user = get_user($post['user_id']); 
print'<img src="/user/image/'.$post_user['image'].'" style="width:200px">'; 
print''.$post_user['name'].'';
print'<textarea>'.$post['text'].'</textarea>';
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
<?php endforeach ?>