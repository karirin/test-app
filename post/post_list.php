<?php
$block = array();
$block = pagination_block($posts);

if (isset($block[0])) :
    foreach ($block[$_SESSION[$i]] as $post) :

        $post_user = get_user($post['user_id']);
?>
<div class="post">
    <a href="/post/post_disp.php?post_id=<?= $post['id'] ?>&user_id=<?= $current_user['id'] ?>" class="post_link">

        <div class="post_list">
            <div class="post_user">
                <object><a
                        href="/user/user_disp.php?user_id=<?= $current_user['id'] ?>&page_id=<?= $post_user['id'] ?>&type=main">
                        <img src="/user/image/<?= $post_user['image'] ?>">
                        <?php print '' . $post_user['name'] . ''; ?>
                    </a></object>
            </div>
            <div class="post_text ellipsis" id="post_text"><?php print '' . $post['text'] . ''; ?></div>
            <?php
                    if (!empty($post['image'])) :
                        print '<img src="/post/image/' . $post['image'] . '" class="post_img" >';
                    endif;
                    ?>
    </a>
    <?php require('post_info.php'); ?>
    <p class="post_created_at"><?php print '' . convert_to_fuzzy_time($post['created_at']) . ''; ?></p>
</div>
</div>

<?php endforeach ?>
<?php endif ?>
<?php require('../pagination.php'); ?>