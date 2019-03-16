/********************************************************************************************
*記事をロード
*********************************************************************************************/
function loadPost(){
  var url = location.href;
  var new_url = url.replace(/\?.*$/,"");
  var splittedArr = getSplittedString(new_url, '/');
  var no = splittedArr[splittedArr.length-1];
  var inputJson = {
    'no' : no
  }
  var url = '/articles/getPost'
  var callback = new Callback();
  callback.callback = function(){

    //document.title変更
    document.title = this.result.title + " - コーディング雑記"

    //タイトル
    $('.articleTitle').append(
      this.result.title
    );

    //カテゴリー
    for(var i in this.result.categories){
      if(this.result.categories[i].id != null){
        $('.articleCategories').append(
          makeHtmlForArticleCategories(this.result.categories[i])
        );
      }
    }
    $('.articleCategory').click(function(){
      goSearchByCategory($(this).text());
    })

    //コンテンツ
    $('.articleContent').append(
      makeHtmlForArticleContent(this.result.content)
    );


  }
  getJsonAndDoSomething(inputJson, url, callback);
}

function makeHtmlForArticleContent(content){
  return '<div style="max-width:100%">'
    + '<pre class="post">'
    + content
    + '</pre>'
    + '</div>'
    + '<script src="/js/jsForArticle.js"></script>';
}

function makeHtmlForArticleCategories(category){
  return '<input type="hidden" value="' + category.id + '">'
   + '<div class="btn btn-outline-dark border articleCategory">' + category.name + '</div>'
}

/********************************************************************************************
*各種ボタンにイベントリスナーを追加する
*********************************************************************************************/
$(document).ready(function(e)
{
  //記事のロード
  loadPost();
});
