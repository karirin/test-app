<?php
if (!empty($_POST['search_user'])) {
    $hoge = $_POST['search_input'];
    header("Location:user_list.php?type=search&query=${hoge}");
}
require_once('../config_1.php');
$page_type = $_GET['type'];
?>

<body>
    <?php if (basename($_SERVER['PHP_SELF']) === 'user_list.php') :
        switch ($page_type) {
            case ('all'):
                print '<h2 class="center">ユーザー一覧</h2>';
                $u = $_SESSION['page_userlist'];
                break;
            case ('followers'):
                print '<h2 class="center">フォロワー一覧</h2>';
                $u = $_SESSION['page_follower'];
                break;
            case ('follows'):
                print '<h2 class="center margin_top_bottom">フォロー一覧</h2>';
                $u = $_SESSION['page_follow'];
                break;
        }
    endif; ?>
    <div class="col-8 offset-2">
        <?php
        if (isset($_GET['page_id']) && $_GET['page_id'] != 'current_user') {
            $user = new User($_GET['page_id']);
        } else {
            $user = new User($_SESSION['user_id']);
        }
        $current_user = $user->get_user();
        $users = $user->get_users($page_type, '');
        $block = pagination_block($users);

        if (isset($block[0])) :
            foreach ($block[$u] as $user) :
        ?>
        <a href="../user_login/user_top.php?user_id=<?= $current_user['id'] ?>&page_id=<?= $user['id'] ?>&type=main&page_type=my_post"
            class="user_link">
            <div class="user">
                <?php if (basename($_SERVER['PHP_SELF']) === 'user_top.php') : ?>
                <div class="user_info top">
                    <?php else : ?>
                    <div class="user_info" style="width: 25%;">
                        <?php endif; ?>
                        <?php if (!empty($user['image'])) : ?>
                        <img style="vertical-align: text-top;margin-left: 1rem;"
                            src="data:image/jpeg;base64,<?= $user['image']; ?>">
                        <?php endif; ?>
                        <div class="user_name">
                            <?= $user['name'] ?>
                            <?php if ($current_user != $user) : ?>
                            <object><a href="../message/message.php?user_id=<?= $user['id'] ?>">
                                    <i class="fas fa-envelope-square"></i>
                                </a></object>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (!empty($user['profile'])) : ?>
                    <?php if (basename($_SERVER['PHP_SELF']) === 'user_top.php') : ?>
                    <span class="user_profile" style="font-size: 1rem;margin-top:1rem;width: 100%;">
                        <?= $user['workhistory'] ?></span>
                    <?php else : ?>
                    <div class="user_profile"><?= $user['workhistory'] ?></div>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
        </a>
        <?php endforeach ?>
        <?php endif ?>
    </div>
    <div class="user_pagination">
        <?php
        switch ($page_type) {
            case ('all'):
                require('../pagination_userlist.php');
                break;
            case ('followers'):
                require('../pagination_follower.php');
                break;
            case ('follows'):
                require('../pagination_follow.php');
                break;
        }
        ?>
    </div>
</body>
<?php require_once('../footer.php'); ?>