/********************************************************************************************
*各種ボタンにイベントリスナーを追加する
*********************************************************************************************/
$(document).ready(function(e)
{
  var inputJson = {};
  var url = '/articles/index';
  var articleContainerClassName = 'articleList';
  var params = GetQueryString();
  //リクエストパラメータが無いとき
  if(!params){
    getJsonAndInsertHtmlForArticleList(inputJson, url, articleContainerClassName, false);
  }else{
    //リクエストパラメータはあるけど、wordがないとき
    if(!"word" in params){
      getJsonAndInsertHtmlForArticleList(inputJson, url, articleContainerClassName, false);
    }
  }
});
