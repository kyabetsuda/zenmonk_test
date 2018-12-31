$('head').append(
  '<style>.fadeIn{display:none;}'
);

//コンテンツがnavbarに隠れないようにする
$(window).on('load resize', function(){
  // navbarの高さを取得する
  var height = $('.navbar').height();
  // bodyのpaddingにnavbarの高さを設定する
  $('body').css('padding-top',height*2.5);



});

$(document).ready(function(e)
{

  //fadeのコールバックとしてrwdImageMapsを呼び出す
  $('.fadeIn').delay(600).fadeIn("slow",function(){
    $('img[usemap]').rwdImageMaps();
  });

  //Modaal
  $('.inline').modaal(
    {
      width:$(window).width()*0.8,
      fullscreen: true,
      hide_close: true
    }
  );

  //Modaalclose
  $('.modal-close').click(function(){
    $('.inline').modaal('close');
  });

  /**
  * 送信ボタンクリック
  */
  $('.showModal').click(function()
  {
    var id =  $(this).data('info').id;
    var cntName = ($(this).data('info').cntName);
    var csrf = $('input[name=_csrfToken]').val();
    var data = { request : id };
    /**
     * Ajax通信メソッド
     * @param type  : HTTP通信の種類
     * @param url   : リクエスト送信先のURL
     * @param data  : サーバに送信する値
     */
    $.ajax({
        type: 'POST',
        beforeSend: function(xhr){
          xhr.setRequestHeader('X-CSRF-Token', csrf);
        },
        datatype:'json',
        url: "http://" + location.hostname + "/" + cntName + "/getContent",
        data: data,
        success: function(data,dataType)
        {
          $('.modalTitle').empty();
          $('.modalBody').empty();
          $('.modalTitle').append(data.title);
          console.log(data.content);
          $('.modalBody').html(
                data.content
          );
          console.log($('.modalBody').children());
          $('.inline').modaal('open');
        },
        /**
         * Ajax通信が失敗した場合に呼び出されるメソッド
         */
        error: function(XMLHttpRequest, textStatus, errorThrown)
        {
          // alert('Error : ' + errorThrown + '\n'
          //   + 'textStatus : ' + textStatus + '\n'
          //   + 'XMLHttpRequest : ' + XMLHttpRequest.status
          // );

          alert("コンテンツ取得時にエラーが発生しました。");
        }
    });

    return false;

  });
});
