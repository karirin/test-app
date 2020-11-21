<?php
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
require_once('../post_process.php');
$current_user = get_user($_SESSION['user_id']);
$message_relations = get_message_relations($current_user['id']);
foreach ($message_relations as $message_relation) :
$destination_user=get_user($message_relation['destination_id']);
?>

<body>
    <p>
        <a href='message.php/user_id=<?= $destination_user['id'] ?>'>メッセージ</a>
    </p>
</body>
<?php endforeach ?>
<?php require_once('../footer.php'); ?>