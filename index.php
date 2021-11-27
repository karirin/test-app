<?php
require_once('config_1.php');
?>
<!DOCTYPE html>
<html lang="ja">
<meta charset="utf-8">
<title>Chat</title>
<script src="http://code.jquery.com/jquery-2.2.4.js"></script>
<script>
//=====================================================
// <img>要素 → Base64形式の文字列に変換
//   img       : HTMLImageElement
//   mime_type : string "image/png", "image/jpeg" など
//=====================================================
function ImageToBase64(img, mime_type) {
    // New Canvas
    var canvas = document.createElement('canvas');
    canvas.width = img.width;
    canvas.height = img.height;
    // Draw Image
    var ctx = canvas.getContext('2d');
    ctx[0].drawImage(img, 0, 0);
    // To Base64
    return canvas.toDataURL(mime_type);
}

//=====================================================
// Base64形式の文字列 → <img>要素に変換
//   base64img: Base64形式の文字列
//   callback : 変換後のコールバック。引数は<img>要素
//=====================================================
function Base64ToImage(base64img, callback) {
    var img = new Image();
    img.onload = function() {
        callback(img);
    };
    img.src = base64img;
}
(function($) {
    var destination_user_image = $('.destination_user_image').val();
    var settings = {};

    var methods = {
        init: function(options) {
            //$.extend：複数のオブジェクトをマージ
            //https://www.tam-tam.co.jp/tipsnote/javascript/post3853.html
            //optionsとsettingsをマージしているが、optionsがわからない
            //ログにはoptions = {uri: "ws://localhost:8080", message: "#message", display: "#chat"}と表示された
            settings = $.extend({
                'uri': 'ws://localhost:8080',
                'conn': null,
                'message': '#messag',
                'display': '#display'
            }, options);
            //keypress：入力された文字のキーコードを取得するイベント
            $(settings['message']).keypress(methods['checkEvent']);
            $(this).chat('connect');
        },

        checkEvent: function(event) {
            if (event && event.which == 13) {
                var message = $(settings['message']).val();
                if (message && settings['conn']) {
                    settings['conn'].send(message + '');
                    $(this).chat('drawText', message, 'right');
                    //$(settings['message']).val('');
                }
            }
        },

        connect: function() {
            if (settings['conn'] == null) {
                settings['conn'] = new WebSocket(settings['uri']);
                settings['conn'].onopen = methods['onOpen'];
                settings['conn'].onmessage = methods['onMessage'];
                settings['conn'].onclose = methods['onClose'];
                settings['conn'].onerror = methods['onError'];
            }
        },

        // onOpen: function(event) {
        //     $(this).chat('drawText', 'サーバに接続', 'left');
        // },

        onMessage: function(event) {
            if (event && event.data) {
                $(this).chat('drawText', event.data, 'left');

            }
        },

        onError: function(event) {
            $(this).chat('drawText', 'エラー発生!', 'left');
        },

        // onClose: function(event) {
        //     $(this).chat('drawText', 'サーバと切断', 'left');
        //     settings['conn'] = null;
        //     setTimeout(methods['connect'], 1000);
        // },

        drawText: function(message, align = 'left') {
            //.text(message)：div要素に引数のメッセージ文字を渡している
            var box = $('<p class="box"></p>').text(message);
            var message_box = $('<p class="box"></p>');
            //console.log(message_box[0]);
            var destination_user_image = $('.destination_user_image').val();
            var message_image = $('.my_preview').attr('src');
            var newelm = document.createElement('img');
            newelm.setAttribute('src', message_image);
            // var $destination_user = document.getElementById("destination_user").value;
            // console.log($destination_user);
            if (align === 'left') {
                var inner = $('<div class="left"></div>').html(box);
                if (message_image != null) {
                    box[0].appendChild(newelm);
                }
                inner.prepend(
                    "<img src='../user/image/" + destination_user_image + "' class='message_user_img'>");
            } else {
                var inner = $('<div class="mycomment right"></div>').html(box);
                if (message_image != null) {
                    box[0].appendChild(newelm);
                }
                inner.append(
                    "<img src='../user/image/<?= $current_user['image'] ?>' class='message_user_img'>");
            }
            //.html：指定した要素にHTMLを挿入する
            //.prepend：指定の要素内に文字列やHTML要素を追加することができる
            $('#chat').append(inner);
            $('.my_preview').attr('src', null);
        },
    }; // end of methods

    //$.fn：メソッドの追加
    //ここではchat()を追加している
    //chat()は引数の配列を別の配列に追加している
    $.fn.chat = function(method) {
        if (methods[method]) {
            //apply：配列を別の配列に追加する
            //Array.prototype.slice.call()：引数（arguments）を配列に変換しているコード
            //https://lealog.hateblo.jp/entry/2014/02/07/012014
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist');
        }
    } // end of function

    // checkEvent: function(event) {
    //         //event.which：押されたボタンに紐づけられたキーコードを取得する
    //         //13のキーコードはEnterキー
    //         //checkEvent: function callback(form) {
    //         //this.onsubmit();
    //         if (event && event.which == 13) {
    //             //ここで送信の動きをしてるぽい
    //             //変数『message』に入力フォームの文字を渡す
    //             var message = $(settings['message']).val();
    //             if (message && settings['conn']) {
    //                 settings['conn'].send(message + '');
    //                 $(this).chat('drawText', message, 'right');
    //                 //$(settings['message']).val('');
    //             }
    //         }
    //     },
    // メッセージ機能処理
    //$(document).on('click', '.message_btn', function(e) {
    $(document).keypress(function(e) {
        e.stopPropagation();
        if (e.which == 13) {
            var message = document.getElementById("message").value,
                //image = document.getElementById("my_image"),
                destination_user_id = document.getElementById("destination_user_id").value;
            //var formdata = new FormData($('#my_image').get(0)); //これを入れると動きがfailになる
            var formdata = new FormData();
            var formdata = new FormData(document.getElementById('image')); //これを入れると動きがfailになる
            formdata.append('message', message);
            formdata.append('destination_user_id', destination_user_id);
            $.ajax({
                type: 'POST',
                url: 'message/ajax_post_message.php',
                dataType: 'html',
                data: formdata,
                cache: false,
                processData: false,
                contentType: false
            }).done(function(data) {
                //document.getElementById("message").value = '';
                $('.far.fa-times-circle.my_clear').hide();
                $('.my_preview').hide();
                $('#my_image').val('');
                //$('.my_preview').attr('src', image);
                // document.getElementsByClassName("left").append(
                //     "<img src='../user/image/" + destination_user_image +
                //     "' class='message_user_img'>"
                // );
            }).fail(function(data) {
                // }).fail(function(jqXHR, textStatus, errorThrown) {
                //     console.log(jqXHR);
                //     console.log(textStatus);
                //     console.log(errorThrown);
            });
        }
    });

})(jQuery);

$(function() {
    $(this).chat({
        'uri': 'ws://localhost:8080',
        'message': '#message',
        'display': '#chat'
    });
});
</script>
</head>

<body>
    <?php
    $user = new User($_SESSION['user_id']);
    $current_user = $user->get_user();
    $user = new User($_GET['user_id']);
    $destination_user = $user->get_user();
    $message = new Message();
    $messages = $message->get_messages($current_user['id'], $destination_user['id']);
    $bottom_message = $message->get_new_message($current_user['id'], $destination_user['id']);
    $message->reset_message_count($current_user['id'], $destination_user['id']);
    ?>
    <div class="row">
        <div class="col-8 offset-2">
            <h2 class="center"><?= $destination_user['name'] ?></h2>
            <div class="message">
                <?php
                foreach ($messages as $message) :
                ?>
                <div class="my_message">
                    <?php if ($message['user_id'] == $current_user['id']) : ?>
                    <div class="mycomment right">
                        <span class="message_created_at">
                            <?= convert_to_fuzzy_time($message['created_at']) ?>
                        </span>
                        <p><?= $message['text'] ?>
                            <?php if (!empty($message['image'])) : ?>
                            <img src="../message/image/<?= $message['image'] ?>">
                            <?php endif; ?>
                        </p><img src="../user/image/<?= $current_user['image'] ?>" class="message_user_img">
                    </div>
                    <?php else : ?>

                    <div class="left"><img src="../user/image/<?= $destination_user['image'] ?>"
                            class="message_user_img">
                        <div class="says"><?= $message['text'] ?>
                            <?php if (!empty($message['image'])) : ?>
                            <img src="../message/image/<?= $message['image'] ?>">
                            <?php endif; ?>
                        </div><span
                            class="message_created_at"><?= convert_to_fuzzy_time($message['created_at']) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endforeach ?>
                </div>
                <div id="chat" class="container">
                </div>
                <input type="text" id="message" size="50" />
                <div class="message_image">
                    <label>
                        <form id="image">
                            <i class="far fa-image"></i>
                            <input type="file" name="image" id="my_image" accept="image/*" multiple>
                        </form>
                    </label>
                </div>
                <div class="message_image_detail">
                    <div><img class="my_preview"></div>
                    <i class="far fa-times-circle my_clear"></i>
                </div>
                <input type="hidden" name="destination_user" class="destination_user_image"
                    value="<?= $destination_user["image"] ?>">
                <input type="hidden" name="destination_user_id" id="destination_user_id"
                    value="<?= $destination_user['id'] ?>">
            </div>
        </div>
</body>
<?php
if (isset($_SESSION['login']) == true) {
    require('profile.php');
}
?>

<script src="/js/user_page.js"></script>

</html>