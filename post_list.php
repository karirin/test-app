<?php 
foreach($posts as $post):
$post_user = get_user($post['user_id']); 

print'<div class="post">';
print'<a href="/post/post_disp.php?post_id='.$post['id'].'&user_id='.$current_user['id'].'" class="post_link">';
print'<div class="post_list">';
print'<object><a href="/user/user_disp.php?user_id='.$current_user['id'].'&page_id='.$post_user['id'].'">';
print'<div class="post_user">';
print'<img src="/user/image/'.$post_user['image'].'">'; 
print''.$post_user['name'].'';
print'</div>';
print'</a></object>';
print'<div class="post_text">';
print''.$post['text'].'';
print'</div>';

if (!empty($post['gazou'])):
print'<img src="/post/gazou/'.$post['gazou'].'" class="post_img" >';
endif;
?>
<div class="post_info">
<div class="post_favorite">
<object><a href="/post/post_delete.php?post_id=<?=$post['id']?>">削除</a></object>
</div>
<?php print''.convert_to_fuzzy_time($post['created_at']).''; ?>
</div>
</div>
</a>
</div>

<?php endforeach ?>