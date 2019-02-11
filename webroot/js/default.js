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
        //alert('コンテンツ取得エラー');
        alert('ErrorCode : ' + XMLHttpRequest.status + '\n'
          + 'textStatus : ' + textStatus + '\n'
          + 'Error : ' + XMLHttpRequest.responseText
        );
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
*検索用
*********************************************************************************************/
function search(word){

  var inputJson = {
    'page' : '0',
    'word' : word
  }
  var url = '/articles/getContent';

  //トップページ以外にいる場合
  if(!$('.articleList').length){

    var pageContainerClassName2 = 'page2';
    var paginationContainerClassName2 = 'pagination2';
    getJsonAndInsertHtmlForArticleList(inputJson, url, 'articleList2', paginationContainerClassName2, pageContainerClassName2, true);
    insertSearchTitleIntoArticleList('searchResult');
    //スクロール
    var height = $('.navbar').height();
    $("html,body").animate({scrollTop:height});
    return;

  }

  var pageContainerClassName = 'page';
  var paginationContainerClassName = 'pagination';
  getJsonAndInsertHtmlForArticleList(inputJson, url, 'articleList', paginationContainerClassName, pageContainerClassName, true);

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
  return '<div class="row" style="display:flex; justify-content: center;"><h2 class="text-center search_title" style="text-decoration: underline;">検索結果</h2></div>';
}

/********************************************************************************************
*記事リスト挿入用メソッド
*********************************************************************************************/
function getJsonAndInsertHtmlForArticleList(inputJson, url, articleContainerClassName, paginationContainerClassName, pageContainerClassName, resetFlg){
  $('.' + articleContainerClassName).empty();

  //リセットフラグがonのとき、ページネーションをリセット
  if(resetFlg){
    $('.' + pageContainerClassName).val(0);
    $('.' + paginationContainerClassName).empty();
  }

  //callbackオブジェクト定義
  var callback = new Callback();
  callback.callback = function(){
      //記事リスト
      insertHtmlForArticleList(articleContainerClassName, this.result);

      //ページネーション
      var first = this.result[0]['flg'];
      var last = this.result[this.result.length-1]['flg'];
      if(this.result.length != 1){
        //取得件数が1件のとき以外にページネーション
        console.log(this.result.length);
        insertHtmlForPagination(first, last, paginationContainerClassName, pageContainerClassName, inputJson, url, articleContainerClassName);
      }
  }

  //jsonデータの取得とcallback起動
  getJsonAndDoSomething(inputJson, url, callback);
}

function insertHtmlForArticleList(containerClassName, jsonData){
  for(var i in jsonData){
    $('.' + containerClassName).append(
      makeHtmlForArticleList(jsonData[i])
    );
  }
}

function makeHtmlForArticleList(article){
  return '<div class="col-sm-4 mb-1 cardWrapper">'
    + '<div class="card mb-3" style="max-width: 25rem;">'
    + '<a style="" href="/articles/post?no=' + article.id + '">'
    + '<img style="max-height: 10rem" class="card-img-top" src="/img/uploaded/' + article.thumbnail + '">'
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
*次へ、戻るボタン挿入メソッド
*********************************************************************************************/
function insertHtmlForPagination(first, last, paginationContainerClassName, pageContainerClassName, inputJson, url, articleContainerClassName){
  var directionPrevious = 'previous';
  var directionNext = 'next';

  $('.' + paginationContainerClassName).empty();

  //一番最初の要素がある場合には表示しない
  if( first != 'first'){
    $('.' + paginationContainerClassName).append(
      makeHtmlForPagination('previous', '前へ')
    );
    //イベントリスナーを付与
    $('.previous').click(function(){
      doPagination(directionPrevious , paginationContainerClassName, pageContainerClassName, inputJson, url, articleContainerClassName);
    });
  }

  //一番最後の要素がある場合には表示しない
  if( last != 'last'){
    $('.' + paginationContainerClassName).append(
      makeHtmlForPagination('next', '次へ')
    );
    //イベントリスナーを付与
    $('.next').click(function(){
      doPagination(directionNext ,paginationContainerClassName, pageContainerClassName, inputJson, url, articleContainerClassName);
    })
  }

}

function makeHtmlForPagination(className, text){
  return '<button class="btn btn-outline-dark border ' + className + '" style="margin : 2px">' + text + '</button>';
}

/********************************************************************************************
*ページネーション
*********************************************************************************************/
function doPagination(direction, paginationContainerClassName, pageContainerClassName, inputJson, url, articleContainerClassName){
  var page = $('.' + pageContainerClassName).val();
  if( direction == 'previous'){
    $('.' + pageContainerClassName).val(parseInt(page, 10) - 1);
    page = parseInt($('.' + pageContainerClassName).val(), 10)*3;

    inputJson.page = page
    //記事の取得および記事リストへの挿入
    getJsonAndInsertHtmlForArticleList(inputJson, url, articleContainerClassName, paginationContainerClassName, pageContainerClassName, false);
  }else if( direction == 'next'){
    $('.' + pageContainerClassName).val(parseInt(page, 10) + 1);
    page = parseInt($('.' + pageContainerClassName).val(), 10)*3;

    inputJson.page = page
    //記事の取得および記事リストへの挿入
    getJsonAndInsertHtmlForArticleList(inputJson, url, articleContainerClassName, paginationContainerClassName, pageContainerClassName, false);
  }
}

/********************************************************************************************
*リクエストパラメータを取得する : https://www.ipentec.com/document/javascript-get-parameter
*********************************************************************************************/
function GetQueryString() {
  if (1 < document.location.search.length) {
      // 最初の1文字 (?記号) を除いた文字列を取得する
      var query = document.location.search.substring(1);

      // クエリの区切り記号 (&) で文字列を配列に分割する
      var parameters = query.split('&');

      var result = new Object();
      for (var i = 0; i < parameters.length; i++) {
          // パラメータ名とパラメータ値に分割する
          var element = parameters[i].split('=');

          var paramName = decodeURIComponent(element[0]);
          var paramValue = decodeURIComponent(element[1]);

          // パラメータ名をキーとして連想配列に追加する
          result[paramName] = decodeURIComponent(paramValue);
      }
      return result;
  }
  return null;
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
