<?php require_once('class.php');
?>
<nav class="navbar navbar-dark">
    <div class="modal"></div>
    <?php if (isset($_SESSION['login']) == false) : ?>
    <ul class="main_ul">
        <li class="top_link">
            <a sytle="margin: -0.5rem 0 0 -1.2rem;" href="../index.php" class="top_link_header"><img
                    src="../Untitled.svg"></a>
        </li>
        <li class="header"><a href="../user_login/user_login.php" style="vertical-align: middle;"><i
                    class="fas fa-sign-in-alt" style="margin-right: 0.5rem;"></i>ログイン</a></li>
        <li class="header"><a href="../user/user_add.php" style="vertical-align: middle;"><i class="fas fa-user-plus"
                    style="margin-right: 0.5rem;"></i>新規登録</a></li>
        <?php
    else :
        if (isset($_GET['page_id']) && $_GET['page_id'] != 'current_user') {
            $user = new User($_GET['page_id']);
            $current_user = $user->get_user();
        } else {
            $user = new User($_SESSION['user_id']);
            $current_user = $user->get_user();
        }
        ?>
        <ul class="main_ul">
            <li class="top_link">
                <a sytle="margin: -0.5rem 0 0 -1.2rem;" href="../index.php?page_type=my_post"><img src="../Untitled.svg"
                        width="128" /></a>
            </li>
            <li class="top_link prof_page"><a class="prof_modal" href="#"><img
                        src="data:image/jpeg;base64,<?= $current_user['image'] ?>" class="user_image"></a></li>
            <li class="header_menu_wide"><a href="../user/user_list.php?type=all&page_id=current_user"
                    style="vertical-align: middle;"><i class="fas fa-users"
                        style="margin-right: 0.5rem;font-size: 1.5rem;"></i>ユーザー一覧</a>
            </li>
            <li class="header_menu"><a href="../message/message_top.php" style="vertical-align: middle;">
                    <i class="fas fa-comment" style="margin-right: 0.5rem;"></i>メッセージ<?php
                                                                                            $message = new Message();
                                                                                            if ($user->get_user_count('message_relation')[0] != 0) {
                                                                                                if ($message->message_count($_SESSION['user_id'])[0]['SUM(message_count)'] != 0) {
                                                                                                    print '' . $message->message_count($_SESSION['user_id'])[0]['SUM(message_count)'] . '';
                                                                                                }
                                                                                            }
                                                                                            ?>
                </a></li>
            <li class="header_menu post_modal"><a href="#" style="vertical-align: middle;"><i class="fas fa-edit"
                        style="margin-right: 0.5rem;margin-bottom: 0;"></i>投稿</a></li>
            <li class="header_menu_wide" style="vertical-align: middle;"><a href="../user_login/user_logout.php"
                    style="vertical-align: middle;"><i class="fas fa-sign-out-alt"
                        style="margin-right: 0.5rem;"></i>ログアウト</a>
            </li>
            <li class="show_menu">メニュー
                <div class="slide_menu">
                    <a class="modal_close" href="#">
                        <p><i class="fas fa-angle-left"></i></p>
                    </a>
                    <ul>
                        <a href="../user/user_list.php?type=all">
                            <li>ユーザー一覧</li>
                        </a>
                        <a href="../message/message_top.php">
                            <li class="slide_menu_message">
                                メッセージ<?php
                                            $message = new Message();
                                            if ($user->get_user_count('message_relation')[0] != 0) {
                                                if ($message->message_count($_SESSION['user_id'])[0]['SUM(message_count)'] != 0) {
                                                    print '' . $message->message_count($_SESSION['user_id'])[0]['SUM(message_count)'] . '';
                                                }
                                            }
                                            ?>
                            </li>
                        </a>
                        <a href="#" class="slide_menu_message post_modal">
                            <li>投稿</li>
                        </a>
                        <a href="../user_login/user_logout.php">
                            <li>ログアウト</li>
                        </a>
                    </ul>
                </div>
            </li>
        </ul>
        <?php
    endif;
        ?>
</nav>
<p class="flash">
    <?php
    if (isset($flash_messages)) :
        foreach ((array)$flash_messages as $message) :
            print '<span class="flash_message">' . $message . '</span>';
        endforeach;
    endif;
    ?>
</p>