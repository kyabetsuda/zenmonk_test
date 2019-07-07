//Swiper変数
var mySwiper = null;

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
/* 検索 */
function search(word, resetFlg){
  var inputJson = {
    'word' : word
  }
  var url = '/articles/getContent';
  var articleContainerClassName = 'articleList';
  getJsonAndInsertHtmlForArticleList(inputJson, url, articleContainerClassName, resetFlg);
  $('.titleOfArticleListTitle').text('検索ワード : ' + word);
}

/* 検索に行く */
function goSearch(word){
  if(!$('.articleList').length){
    location.href = 'http://' + location.hostname + '/?word=' + word;
  }else{
    search(word, true);
    scrollToArticleListTitle();
    hideToggler();
  }
}

/* パラメータ検索 */
function searchByParam(params){
  //リクエストパラメータがセットされている時
  if(params){
    if("word" in params){
      search(params['word'], false);
      scrollToArticleListTitle();
    }
    if("category" in params){
      searchByCategory(params['category'], false);
      scrollToArticleListTitle();
    }
  }
}

/********************************************************************************************
*カテゴリー一覧
*********************************************************************************************/
/* カテゴリーリストロード */
function loadCategories(){
  var categoryContainerClassName = 'categoryList';
  var inputJson = {};
  var url = '/articles/getCategories';
  var callback = new Callback();
  callback.callback = function(){
    insertHtmlIntoCategoryList(categoryContainerClassName,this.result);
    //カテゴリーにリスナー追加
    $('.category').click(function(){
      var word = $(this).text();
      goSearchByCategory(word);
    });
  }
  //json取得とcallback起動
  getJsonAndDoSomething(inputJson, url, callback);

}

/* カテゴリーhtml挿入 */
function insertHtmlIntoCategoryList(containerClassName, jsonData){
  for(var i in jsonData){
    $('.' + containerClassName).append(
      makeHtmlForCategoryList(jsonData[i])
    );
  }
}

/* カテゴリーhtml作成 */
function makeHtmlForCategoryList(category){
  return '<button class="btn btn-outline-dark border category">' + category.name + '</button>';
}

/* カテゴリー検索用リダイレクト */
function goSearchByCategory(word){
  if(!$('.articleList').length){
   location.href = 'http://' + location.hostname + '/?category=' + word;
  }else{
   searchByCategory(word, true);
   scrollToArticleListTitle();
   hideToggler();
  }
}

/* カテゴリーによる検索 */
function searchByCategory(word, resetFlg){
  var inputJson = {
    'word' : word
  }
  var url = '/articles/getContentByCategory';
  var articleContainerClassName = 'articleList';
  getJsonAndInsertHtmlForArticleList(inputJson, url, articleContainerClassName, resetFlg);
  $('.titleOfArticleListTitle').text('カテゴリー : ' + word);
}

/********************************************************************************************
*記事リスト挿入用メソッド
*********************************************************************************************/
/* 記事リストに記事を挿入 */
function getJsonAndInsertHtmlForArticleList(inputJson, url, articleContainerClassName, resetFlg){
  $('.' + articleContainerClassName).empty();
  // callbackオブジェクト定義
  var callback = new Callback();
  callback.callback = function(){
    // 記事リスト
    insertHtmlForArticleList(articleContainerClassName, this.result);
    // フェードイン
    $('.fadeIn').fadeIn(550,function(){
    });
    if(resetFlg){
      mySwiper.update();
    }else{
      mySwiper = initializeSwiper();
    }
  }
  getJsonAndDoSomething(inputJson, url, callback);
}

/* 記事html挿入 */
function insertHtmlForArticleList(containerClassName, jsonData){
  for(var i in jsonData){
    $('.' + containerClassName).append(
      makeHtmlForArticleList(jsonData[i])
    );
  }
}

/* 記事html作成 */
function makeHtmlForArticleList(article){
  return '<div class="cardWrapper fadeIn swiper-slide">'
    + '<div class="card m-1">'
    + '<div class="card-title">'
    + '<br>'
    + '<h5 class="m-2">' + article.title + '</h5>'
    + '</div>'
    + '<a href="/articles/post/' + article.id + '">'
    + '<img class="card-img-top" src="/img/uploaded/' + article.thumbnail + '">'
    + '</a>'
    + '<div class="card-body">'
    + '<span>' + getFirstSentenceFromStr(article.content) + '...</span>'
    + '<br>'
    + '<a href="/articles/post/' + article.id + '">'
    + '<button class="btn btn-outline-dark border mt-3">続きを読む</button>'
    + '</a>'
    + '</div>'
    + '<div class="card-footer">'
    + '<span>' + sampleDate(new Date(article.upd_ymd.replace(/-/g,'/')),'YYYY/MM/DD') + '</span>'
    + '</div>'
    + '</div>'
    + '</div>'
    ;
}
/********************************************************************************************
*リクエストパラメータを取得する : https://www.ipentec.com/document/javascript-get-parameter
*********************************************************************************************/
/* リクエストパラメータを得る */
function GetQueryString() {
  if (1 < document.location.search.length) {
      // 最初の1文字 (?記号) を除いた文字列を取得する
      var query = document.location.search.substring(1);
      // クエリの区切り記号 (&) で文字列を配列に分割する
      var parameters = query.split('&');
      return getMapFromRequestParameters(parameters);
  }
  return null;
}

/* パラメータを連想配列にして返す */
function getMapFromRequestParameters(parameters){
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

/********************************************************************************************
*汎用
*********************************************************************************************/
/* stringをsplit */
function getSplittedString(str, splitter) {
  var words = str.split(splitter);
  return words;
}

/* 携帯かどうか判断 : https://coderwall.com/p/i817wa/one-line-function-to-detect-mobile-devices-with-javascript */
function isMobileDevice() {
    return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);
};

/* スクロール */
function scrollToArticleListTitle(){
  var height = $(window).height()*0.8;
  $("html,body").animate({scrollTop:height});
}

/* トグルメニューを隠す */
function hideToggler(){
  $('#topmenu').collapse('hide');
}

/* swiper initialize */
function initializeSwiper(){
  var count = 3;
  var $win = $(window),
    $mediaQueries = $('.jsc-media-queries');
  var layout = $mediaQueries.css('font-family').replace(/"/g, '');
  if(layout === 'one'){
    count = 1;
  }
  var mySwiper = new Swiper ('.swiper-container', {

    // Optional parameters
    direction: 'horizontal',

    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
      type:'fraction'
    },

    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
      draggable: true,
      hide: true
    },

    mousewheel: {
      forceToAxis: true,
      sensitivity: 9007199254740991,
      invert: true,
    },

    // slideperView
    slidesPerView: count
  })

  return mySwiper;
}

/* date型変換 */
function sampleDate(date, format) {
    format = format.replace(/YYYY/, date.getFullYear());
    format = format.replace(/MM/, date.getMonth() + 1);
    format = format.replace(/DD/, date.getDate());
    return format;
}

/* 最初の文を取得 */
function getFirstSentenceFromStr(str){
  var tmp = str.match(/^.*。/m);
  var ret = "";
  if(tmp !== null){
      ret = tmp[0].substr(0, 30);
  }
  return ret;
}

/********************************************************************************************
*メイン処理
*********************************************************************************************/
$(document).ready(function(e)
{
  // カテゴリー一覧取得
  loadCategories();

  // 検索
  var params = GetQueryString();
  searchByParam(params);

  // 検索ボタンを押下したとき
  $('.searchBtn').click(function(){
    var word = $('.searchWord').val();
    goSearch(word);
  });

  // fadeIn
  $('.fadeIn').fadeIn(1000);
});
