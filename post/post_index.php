<?php
if (!empty($_POST['search_post'])) {
    $hoge = $_POST['search_input'];
    header("Location:post_index.php?type=search&query=${hoge}");
}
require_once('../config_1.php');
?>
<div class="col-6 offset-3">
    <h2 class="center margin_top">投稿一覧</h2>
    <form method="post" action="#" class="search_container">
        <div class="input-group mb-2">
            <input type="text" name="search_input" class="form-control" placeholder="投稿検索">
            <div class="input-group-append">
                <input type="submit" name="search_post" class="btn btn-outline-secondary">
                <?php

                $user_class = new User($_SESSION['user_id']);
                $current_user = $user_class->get_user();
                $post_class = new Post(0);
                $page_type = $_GET['type'];

                switch ($page_type) {
                    case 'all':
                        $posts = $post_class->get_posts('', 'all', 0);
                        break;

                    case 'search':
                        $posts = $post_class->get_posts('', 'search', $_GET['query']);
                        break;
                }
                ?>
            </div>
        </div>
    </form>
    <?php
    require_once('post_list.php');
    print '</div>';
    require_once('../footer.php');
    ?>