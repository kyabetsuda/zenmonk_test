//フェードは消しておく
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

function search(word){
  //jsForArticlesListのメソッド
  loadArticles('articleList','/articles/getContent',word);

  //スクロール
  var height = $('.navbar').height();
  var heightOfTopString = $('.topString').height();
  $("html,body").animate({scrollTop:heightOfTopString + (height*2.5)});
}

//json取得用汎用メソッド
//input words[] 配列
//      url     送信先url
function getJson(words, url){
  var csrf = $('input[name=_csrfToken]').val();
  var json = {
    'word' : words
  }

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
      data : json,
      url: "http://" + location.hostname + url,
      success: function(data,dataType)
      {
        return data;
      },
      /**
       * Ajax通信が失敗した場合に呼び出されるメソッド
       */
      error: function(XMLHttpRequest, textStatus, errorThrown)
      {
        alert('Error : ' + errorThrown + '\n'
          + 'textStatus : ' + textStatus + '\n'
          + 'XMLHttpRequest : ' + XMLHttpRequest.status
        );
      }
  });
}

$(document).ready(function(e)
{
  //各種グローバル変数定義

  //フェードイン
  $('.fadeIn').delay(600).fadeIn("slow");

  $('.searchBtn').click(function(){
    var word = $('.searchWord').val();
    search(word);
  });

});
