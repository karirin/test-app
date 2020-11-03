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

    $(document).on('click','.show_all',function(){
    // 省略されている投稿の高さを取得
    // var omit_height = $(document).find('#post_text').height();
    $(document).find('.post_text').removeClass('ellipsis');
    $(this).remove()
    // //投稿の省略を解除
    // 全文表示された投稿の高さを取得
    // var all_height = $(this).parent().height();
    // //一度高さを戻して
    // $(this).parent().height(omit_height);
    // //スライドで全文表示させる
    // $(this).parent().animate({
    //   height: all_height
    // },"slow","swing");

    // //ボタンを消す
    // $(this).remove()
  });

  $('.textarea').on('input',function(){
    var count = $(this).val().length;
    $('.show_count').text(count);
    if (count > 300) {
      $('.show_count').css('color','#FF7763');
    }else{
      $('.show_count').css('color','#FFF');
    }
  });


  $('.textarea').on('input',function(){
    if ($(this).val().length !== 0 && $(this).val().length <= 300){
      $('#post').prop('disabled',false);
    }else{
      $('#post').prop('disabled',true);
    }
  })

  var user_comment = $('.comment').text(),
      user_name = $('.profile_name').text(),
      user_id = $('.user_id').val();

  $(document).on('click',".modal_close",function(){
    $('body').removeClass('fixed').css({'top': 0});
    window.scrollTo( 0 , scroll_position );
    $('.modal').fadeOut();
    $('.delete_confirmation').fadeOut();
    $('.post_process').fadeOut();
    $('.post_edit').fadeOut();
    $('.comment_confirmation').fadeOut();
    $('.reply_comment_confirmation').fadeOut();
    $('.edit_comment').replaceWith('<p class="comment">' + user_comment + '</p>');
    $('.edit_name').replaceWith('<h2 class="profile_name">' + user_name + '</h2>');
    $('.btn_flex').css('display','none');
    $('.profile').removeClass('editing');
    $('.edit_btn').fadeIn();
  });

  $(document).on('click','.edit_btn',function(){
    scroll_position = $(window).scrollTop();
    $('.edit_btn').fadeOut();
    $('body').addClass('fixed').css({'top': -scroll_position});
    $('.comment').replaceWith('<textarea class="edit_comment form-control" type="text" value="">'+user_comment);
    $('.profile_name').replaceWith('<input class="edit_name form-control" type="text" value="'+user_name+'">');
    $('.btn_flex').css('display','flex');
    $('.modal').fadeIn();
    $('.profile').addClass('editing');
  });

  $(document).on('click','.profile_save',function(e){
    e.stopPropagation();
      var comment_data = $('.edit_comment').val();
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

  $(document).on('click','.thread_btn',function(){
    var $target_modal = $(this).data("target"),
        omit_height = $(this).parent().height();
    scroll_position = $(window).scrollTop();
    $(this).remove();
    $($target_modal).fadeIn();
    $(this).parent().height(omit_height);
  });

  $(document).on('click','.post_window',function(){
    //背景をスクロールできないように　&　スクロール場所を維持
    scroll_position = $(window).scrollTop();
    $('body').addClass('fixed').css({'top': -scroll_position});
    // モーダルウィンドウを開く
    $('.post_process').fadeIn();
    $('.modal').fadeIn();
  });

  $('[data-toggle="favorite"]').tooltip();
  $('[data-toggle="post"]').tooltip();
  $('[data-toggle="edit"]').tooltip();
  $('[data-toggle="delete"]').tooltip();
  $('[data-toggle="reply"]').tooltip();