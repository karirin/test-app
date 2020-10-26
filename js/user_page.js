function get_param(name, url) {
    if (!url) url = window.location.href;
    //window.location.hrefは現在のURLを取得
    name = name.replace(/[\[\]]/g, "\\$&");
    //replaceは文字の置換を行う
    //`//g`は//の中の文字をすべて第二引数の文字に変換する
    // []はその中の文字があるかを判断
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
    //RegExpは引数の値があったときにtureを返す
        results = regex.exec(url);
            //regexp.exec(url)でregexとurlがマッチしている値をresultsに返しています
    if (!results) return null;
    if (!results[2]) return false;
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

$(document).on('click','.favorite_btn',function(e){
    e.stopPropagation();
    var $this = $(this),
        post_id = $this.prev().val();
        //prev()は$thisの直前にあるhtml要素を取得する
        //val()は取得したいhtml要素のvalue値を取得する
    $.ajax({
        type: 'POST',
        url: '../ajax_post_favorite_process.php',
        dataType: 'json',
        data: {
        post_id: post_id}
    }).done(function(data){
      location.reload();
    }).fail(function() {
      location.reload();
    });
  });

  $(document).on('click','.follow_btn',function(e){
    e.stopPropagation();
    var $this = $(this),
    current_user_id = $('.current_user_id').val();
    user_id = $this.prev().val();
      //prev()は指定した$thisの直前にあるHTML要素を取得する
    $.ajax({
        type: 'POST',
        url: '../ajax_follow_process.php',
        dataType: 'json',
        data: { current_user_id: current_user_id,
                user_id: user_id }
    // }).beforeSend(function(xhr) {
    //   xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
    //$.ajax(...).beforeSendが未定義で関数をよびだすことができない（関数は(...)のこと→beforeSend(...)）
    }).done(function(data){
      location.reload();
    }).fail(function(jqXHR,textStatus,errorThrown){
      location.reload();
    });
  });

  user_comment = $('.profile_comment').text();

  $(document).on('click',".modal_close",function(){
    $('body').removeClass('fixed').css({'top': 0});
    window.scrollTo( 0 , scroll_position );
    $('.modal').fadeOut();
    $('.delete_confirmation').fadeOut();
    $('.post_process').fadeOut();
    $('.post_edit').fadeOut();
    $('.comment_confirmation').fadeOut();
    $('.reply_comment_confirmation').fadeOut();
    $('.edit_comment').replaceWith('<p class="profile_comment">' + user_comment + '</p>');
    $('.btn_flex').css('display','none');
  });

  $(document).on('click','.edit_btn',function(){
    $('.profile_comment').replaceWith('<textarea class="edit_comment border_white" type="text">');
    $('.btn_flex').css('display','flex');
  });

  $(document).on('click','.profile_save',function(e){
    e.stopPropagation();
      var comment_data = $('.edit_comment').val(),
          user_id = get_param('user_id');
    $.ajax({
      type: 'POST',
      url: '../ajax_edit_profile.php',
      dataType: 'text',
      data: {comment_data: comment_data,
             user_id: user_id}
    }).done(function(){
      location.reload();
    }).fail(function(){
      location.reload();
    });
  });

  $(function (){
    $message = ('.flash_message');
    // 渡されたメッセージを表示させる
    setTimeout(function(){ $($message).slideToggle('slow');} , 2000);
  });

  $(document).on('click','.modal_btn',function(){
    var $target_modal = $(this).data("target")
        //背景をスクロールできないように　&　スクロール場所を維持
        scroll_position = $(window).scrollTop();
        $('body').addClass('fixed').css({'top': -scroll_position});
        // モーダルウィンドウを開く
        $($target_modal).fadeIn();
        $('.modal').fadeIn();
  });

  $(document).on('click','.post_window',function(){
        //背景をスクロールできないように　&　スクロール場所を維持
        scroll_position = $(window).scrollTop();
        $('body').addClass('fixed').css({'top': -scroll_position});
        // モーダルウィンドウを開く
        $('.post_process').fadeIn();
        $('.modal').fadeIn();
  });