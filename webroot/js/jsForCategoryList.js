/********************************************************************************************
*カテゴリー取得
*********************************************************************************************/
function loadCategories(jsonData){
  var height = $('.navbar').height();
  var heightOfTopString = $('.topString').height();
  insertHtmlIntoCategoryList('categoryList',jsonData);
  $('.category').click(function(){
    getJsonAndDoSomething($(this).text(),'/articles/getContentByCategory',getJsonAndInsertHtmlForArticleList);
    $("html,body").animate({scrollTop:heightOfTopString + (height*2.5)});
  });
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
  //カテゴリー追加(default.jsからの汎用メソッド)
  getJsonAndDoSomething('','/articles/getCategories',loadCategories);
});
