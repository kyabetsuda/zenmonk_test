/********************************************************************************************
*各種ボタンにイベントリスナーを追加する
*********************************************************************************************/
$(document).ready(function(e)
{
  var page = $('.' + pageContainerClassName).val();
  var inputJson = {
    'page' : page
  };
  var url = '/articles/index';
  var articleContainerClassName = 'articleList';
  var paginationContainerClassName = 'pagination';
  var pageContainerClassName = 'page';
  getJsonAndInsertHtmlForArticleList(inputJson, url, articleContainerClassName, paginationContainerClassName, pageContainerClassName);

});
