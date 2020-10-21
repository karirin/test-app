<?php 
foreach($posts as $post):
$post_user = get_user($post['user_id']); 

print'<div class="post">';
print'<a href="/post/post_disp.php?post_id='.$post['id'].'&user_id='.$current_user['id'].'" class="post_link">';
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
</a>
<div class="post_info">
<div class="post_favorite">
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
</div>
<?php print''.convert_to_fuzzy_time($post['created_at']).''; ?>
</div>
</div>
</div>

<?php endforeach ?>