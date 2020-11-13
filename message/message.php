<div class="message">

$messages = get_messages($message_id);
<?= foreach($messages as $message): ?>
    <div class="my_message">
        <?php $message ?>
    </div>
<?php endforeach ?>
</div>