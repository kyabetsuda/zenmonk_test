/********************************************************************************************
*カテゴリー取得
*********************************************************************************************/
function loadCategories(){
  var height = $('.navbar').height();
  var heightOfTopString = $('.topString').height();
  var containerClassName = 'categoryList';
  var inputJson = {};
  var url = '/articles/getCategories';
  var callback = new Callback();
  callback.callback = function(){
    insertHtmlIntoCategoryList(containerClassName,this.result);
    //カテゴリーにリスナー追加
    $('.category').click(function(){
      var inputJson = {
        'word' : $(this).text()
      };
      var url = '/articles/getContentByCategory';
      //json取得とcallback起動
      getJsonAndInsertHtmlForArticleList(inputJson, url, 'articleList');
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
