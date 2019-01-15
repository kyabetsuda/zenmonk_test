/********************************************************************************************
*bodyがnavの下に隠れないようにする
*********************************************************************************************/
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

/********************************************************************************************
*検索用
*********************************************************************************************/
function search(word){
  //jsForArticlesListのメソッド
  loadArticles('articleList','/articles/getContent',word);

  //スクロール
  var height = $('.navbar').height();
  var heightOfTopString = $('.topString').height();
  $("html,body").animate({scrollTop:heightOfTopString + (height*2.5)});
}

/********************************************************************************************
*jsonデータを取得し何かをするメソッド
*********************************************************************************************/
function getJsonAndDoSomething(words, url, callback){
  getJson(words, url).done(function(result){
    callback(result);
  });
}

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
  return $.ajax({
      type: 'POST',
      beforeSend: function(xhr){
        xhr.setRequestHeader('X-CSRF-Token', csrf);
      },
      datatype:'json',
      data : json,
      url: "http://" + location.hostname + url,
      success: function(data,dataType)
      {
        alert("success");
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

/********************************************************************************************
*記事リスト挿入用メソッド
*********************************************************************************************/
function getJsonAndInsertHtmlForArticleList(result){
  var containerClassName = 'articleList';
  $('.' + containerClassName).empty();
  insertHtmlForArticleList(containerClassName, result);
  $(window).scroll(function(){
    $('.cardWrapper').each(function(i){
      var bottom_of_object = $(this).position().top + ($(this).outerHeight()/2);
      var bottom_of_window = $(window).scrollTop() + $(window).height();
      /* If the object is completely visible in the window, fade it it */
      if( bottom_of_window > bottom_of_object ){
          $(this).animate({'opacity':'1'},500);
      }
    });
  });
}

function insertHtmlForArticleList(containerClassName, jsonData){
  for(var i in jsonData){
    $('.' + containerClassName).append(
      makeHtmlForArticleList(jsonData[i])
    );
  }
}

function makeHtmlForArticleList(article){
  return '<div class="col-sm-4 mb-1 cardWrapper" style="opacity : 0;">'
    + '<div class="card mb-3" style="max-width: 25rem;">'
    + '<a href="/articles/post/' + article.id + '">'
    + '<img class="card-img-top" src="/img/uploaded/' + article.thumbnail + '">'
    + '</a>'
    + '<div class="card-body text-center">'
    + '<span>' + article.title + '</span>'
    + '</div>'
    + '<div class="card-footer text-center" style="font-size:11px; background-color:#ffffff">'
    + '<span>' + sampleDate(new Date(article.upd_ymd.replace(/-/g,'/')),'YYYY/MM/DD') + '</span>'
    + '</div>'
    + '</div>'
    + '</div>'
    ;
}

function sampleDate(date, format) {

    format = format.replace(/YYYY/, date.getFullYear());
    format = format.replace(/MM/, date.getMonth() + 1);
    format = format.replace(/DD/, date.getDate());

    return format;
}

/********************************************************************************************
*各種ボタンにイベントリスナーを追加する
*********************************************************************************************/
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
