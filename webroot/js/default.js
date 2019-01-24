/********************************************************************************************
*bodyがnavの下に隠れないようにする
*********************************************************************************************/
//フェードは消しておく
$('head').append(
  '<style>.fadeIn{display:none;}'
);

//コンテンツがnavbarに隠れないようにする
$(window).on('load resize', function(){

  // // navbarの高さを取得する
  // var height = $('.navbar').height();
  // // bodyのpaddingにnavbarの高さを設定する
  // $('body').css('padding-top',height*2.5);

});

/********************************************************************************************
*検索用
*********************************************************************************************/
function search(word){

  //トップページ以外にいる場合
  if(!$('.articleList').length){
    var inputJson = {
      'word' : word
    }
    var url = '/articles/getContent';
    getJsonAndInsertHtmlForArticleList2(inputJson, url, 'articleList2');
    insertSearchTitleIntoArticleList('searchResult');
    return;
  }

  var inputJson = {
    'word' : word
  }
  var url = '/articles/getContent';
  getJsonAndInsertHtmlForArticleList(inputJson, url, 'articleList');

  //スクロール
  var height = $('.navbar').height();
  var heightOfTopString = $('.topString').height();
  $("html,body").animate({scrollTop:heightOfTopString + (height*2.5)});
}

function insertSearchTitleIntoArticleList(containerClassName){
  $('.' + containerClassName).empty();
  $('.' + containerClassName).prepend(makeHtmlForSearchTitle());
}

function makeHtmlForSearchTitle(){
  return '<div class="row" style="display:flex; justify-content: center;"><h2 class="text-center search_title" style="text-decoration: underline;">SearchResult</h2></div>';
}

/********************************************************************************************
*記事リスト挿入用メソッド
*********************************************************************************************/
function getJsonAndInsertHtmlForArticleList2(inputJson, url, containerClassName){
  $('.' + containerClassName).empty();

  //callbackオブジェクト定義
  var callback = new Callback();
  callback.callback = function(){
      insertHtmlForArticleList2(containerClassName, this.result);
      //スクロール
      var height = $('.navbar').height();
      $("html,body").animate({scrollTop:(height)});
  }
  //jsonデータの取得とcallback起動
  getJsonAndDoSomething(inputJson, url, callback);
}

function insertHtmlForArticleList2(containerClassName, jsonData){
  for(var i in jsonData){
    console.log(jsonData[i].upd_ymd);
    $('.' + containerClassName).append(
      makeHtmlForArticleList2(jsonData[i])
    );
  }
}

function makeHtmlForArticleList2(article){
  //opacityを設定しない
  return '<div class="col-sm-4 mb-1 cardWrapper">'
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



/********************************************************************************************
*jsonデータ取得用に渡すプロトタイプ
*********************************************************************************************/
function Callback(result){
}
Callback.prototype.setResult = function(result){
  this.result = result;
}
Callback.prototype.callback = function(){
}

/********************************************************************************************
*jsonデータを取得し何かをするメソッド
*********************************************************************************************/
function getJsonAndDoSomething(inputJson, url, callback){
  getJson(inputJson, url).done(function(result){
    //callbackは必ず上記のprototypeを渡すこと
    callback.setResult(result);
    callback.callback();
  });
}

function getJson(inputJson, url){
  var csrf = $('input[name=_csrfToken]').val();

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
      data : inputJson,
      url: "http://" + location.hostname + url,
      success: function(data,dataType)
      {
        //alert("success");
      },
      /**
       * Ajax通信が失敗した場合に呼び出されるメソッド
       */
      error: function(XMLHttpRequest, textStatus, errorThrown)
      {
        alert('コンテンツ取得エラー');
        // alert('Error : ' + errorThrown + '\n'
        //   + 'textStatus : ' + textStatus + '\n'
        //   + 'XMLHttpRequest : ' + XMLHttpRequest.status
        // );
      }
  });
}

/********************************************************************************************
*fileをajax送信し何かをするメソッド
*********************************************************************************************/
function getJsonWithFileAndDoSomething(inputJson, url, callback){
  getJsonWithFile(inputJson, url).done(function(result){
    //callbackは必ず上記のprototypeを渡すこと
    callback.setResult(result);
    callback.callback();
  });
}

function getJsonWithFile(inputJson, url){
  var csrf = $('input[name=_csrfToken]').val();
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
      url: "http://" + location.hostname + url,
      datatype:'json',
      contentType : false,
      processData : false,
      data: inputJson,
      success: function(data,dataType)
      {
        alert("success");
      },
      /**
       * Ajax通信が失敗した場合に呼び出されるメソッド
       */
      error: function(XMLHttpRequest, textStatus, errorThrown)
      {
        alert('ErrorCode : ' + XMLHttpRequest.status + '\n'
          + 'textStatus : ' + textStatus + '\n'
          + 'Error : ' + XMLHttpRequest.responseText
        );
      }
  });
}

/********************************************************************************************
*記事リスト挿入用メソッド
*********************************************************************************************/
function getJsonAndInsertHtmlForArticleList(inputJson, url, containerClassName){
  // var containerClassName = 'articleList';
  $('.' + containerClassName).empty();

  //callbackオブジェクト定義
  var callback = new Callback();
  callback.callback = function(){
      insertHtmlForArticleList(containerClassName, this.result);
  }

  //jsonデータの取得とcallback起動
  getJsonAndDoSomething(inputJson, url, callback);

  //追加されたcardに対してanimation追加
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

function sayHello(){
  return 'hello';
}

/********************************************************************************************
*各種ボタンにイベントリスナーを追加する
*********************************************************************************************/
$(document).ready(function(e)
{
  // navbarの高さを取得する
  var height = $('.navbar').height();
  // bodyのpaddingにnavbarの高さを設定する
  $('body').css('padding-top',height*2.5);

  //フェードイン
  $('.fadeIn').delay(600).fadeIn("slow");

  $('.searchBtn').click(function(){
    var word = $('.searchWord').val();
    search(word);

  });

});
