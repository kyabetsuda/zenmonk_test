/********************************************************************************************
*記事をロード
*********************************************************************************************/
function loadPost(){
  var params = GetQueryString();
  var inputJson = {
    'no' : params["no"]
  }
  var url = '/articles/getPost'
  var callback = new Callback();
  callback.callback = function(){
    console.log(this.result);
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
      searchByCategory($(this).text());
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
*カテゴリーから記事を取得
*********************************************************************************************/
function searchByCategory(word){
  var inputJson = {
    'page' : '0',
    'word' : word
  }
  var url = '/articles/getContentByCategory';
  var articleContainerClassName = 'articleList2';
  var paginationContainerClassName = 'pagination2';
  var pageContainerClassName = 'page2';
  getJsonAndInsertHtmlForArticleList(inputJson, url, articleContainerClassName, paginationContainerClassName, pageContainerClassName, true);
  insertSearchTitleIntoArticleList('searchResult');
}

/********************************************************************************************
*各種ボタンにイベントリスナーを追加する
*********************************************************************************************/
$(document).ready(function(e)
{
  loadPost();
});
