//カテゴリー取得
function loadCategories(jsonData){
  insertHtmlIntoCategoryList('categoryList',jsonData);
  $('.category').click(function(){
    getJsonAndDoSomething($(this).text(),'/articles/getContentByCategory',insertHtmlForArticleListByCategory);
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

function insertHtmlForArticleListByCategory(result){
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



/********************************************************************************************
*各種ボタンにイベントリスナーを追加する
*********************************************************************************************/
$(document).ready(function(e)
{
  //カテゴリー追加(default.jsからの汎用メソッド)
  getJsonAndDoSomething('','/articles/getCategories',loadCategories);
});
