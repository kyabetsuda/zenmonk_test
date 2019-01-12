//フェードは消しておく
$('head').append(
  '<style>.fadeIn{display:none;}'
);

//コンテンツがnavbarに隠れないようにする
$(window).on('load resize', function(){
  // navbarの高さを取得する
  var height = $('.navbar').height();
  // bodyのpaddingにnavbarの高さを設定する
  $('body').css('padding-top',height*2.5);

});

function search(word){
  //jsForArticlesListのメソッド
  loadArticles('articleList','/articles/getContent',word);

  var height = $('.navbar').height();
  var heightOfTopString = $('.topString').height();
  $("html,body").animate({scrollTop:heightOfTopString + (height*2.5)});
}

$(document).ready(function(e)
{
  //フェードイン
  $('.fadeIn').delay(600).fadeIn("slow");

  $('.searchBtn').click(function(){
    var word = $('.searchWord').val();
    search(word);
  });

});
