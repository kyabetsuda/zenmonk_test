/********************************************************************************************
*カテゴリー取得
*********************************************************************************************/
function loadCategories(){
  var categoryContainerClassName = 'categoryList';
  var inputJson = {};
  var url = '/articles/getCategories';
  var callback = new Callback();
  callback.callback = function(){
    insertHtmlIntoCategoryList(categoryContainerClassName,this.result);
    //カテゴリーにリスナー追加
    $('.category').click(function(){
      var inputJson = {
        'page' : '0',
        'word' : $(this).text()
      };
      var url = '/articles/getContentByCategory';
      //json取得とcallback起動
      var articleContainerClassName = 'articleList';
      var paginationContainerClassName = 'pagination';
      var pageContainerClassName = 'page';
      getJsonAndInsertHtmlForArticleList(inputJson, url, articleContainerClassName, paginationContainerClassName, pageContainerClassName, true);

      //スクロール
      var height = $('.navbar').height();
      var heightOfTopString = $('.topString').height();
      $("html,body").animate({scrollTop:heightOfTopString + (height*2.5)});
    });
  }
  //json取得とcallback起動
  getJsonAndDoSomething(inputJson, url, callback);

}

function insertHtmlIntoCategoryList(containerClassName, jsonData){
  for(var i in jsonData){
    $('.' + containerClassName).append(
      makeHtmlForCategoryList(jsonData[i])
    );
  }
}

function makeHtmlForCategoryList(category){
  return '<button class="btn btn-outline-dark border category">' + category.name + '</button>';
}

/********************************************************************************************
*各種ボタンにイベントリスナーを追加する
*********************************************************************************************/
$(document).ready(function(e)
{
  loadCategories();
  //カテゴリー追加(default.jsからの汎用メソッド)
  //getJsonAndDoSomething('','/articles/getCategories',loadCategories);
});
