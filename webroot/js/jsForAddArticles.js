/********************************************************************************************
*変数定義
*********************************************************************************************/
//動画パス
var mvSrc = "/mv/videos/";

//画像パス
var gzSrc = "";

//uploadPictureのためのグローバルメソッド
callbackForLoad = function(){
  addEventListenerToImg();
};

//uploadVideosのためのグローバルメソッド
callbackForMvLoad = function(){
  addEventListenerToImgForMv()
};

/********************************************************************************************
*コードブロック、または引用ブロック
*********************************************************************************************/

/*
*コードブロックの挿入
*/
function insertCodeBlock(containerClassName){
  var val = $('.' + containerClassName).val();
  //中身が空じゃないときは改行コードを入れる
  if (!val == "" ) {
    $('.' + containerClassName).val($('.' + containerClassName).val() + '\n');
  }

  $('.' + containerClassName).val($('.' + containerClassName).val()
    + '<pre>\n'
    + '<code>\n'
    + '\n'
    + '</code>\n'
    + '</pre>');
}

/*
*引用ブロックの挿入
*/
function insertCitationBlock(containerClassName){
  var val = $('.' + containerClassName).val();
  //中身が空じゃないときは改行コードを入れる
  if (!val == "" ) {
    $('.' + containerClassName).val($('.' + containerClassName).val() + '\n');
  }

  $('.' + containerClassName).val($('.' + containerClassName).val()
    + '<blockquote>\n'
    + '<p>\n'
    + '\n'
    + '</p>\n'
    + '</blockquote>');
}

/********************************************************************************************
*画像にイベントリスナーを追加する
*********************************************************************************************/

/*
*画像挿入ようHTML作成
*/
function makeGzHtmlForArticle(gzSrc){
  return "<img class='mx-auto d-block' style='max-width: 100%; margin : 1%;' src='"
      + gzSrc
      + "'>";

}

/*
*画像HTML挿入
*/
function insertGzHtmlIntoArticle(gzHtml, containerClassName){
  var val = $('.' + containerClassName).val();
  //中身が空じゃないときは改行コードを入れる
  if (!val == "" ) {
    $('.' + containerClassName).val($('.' + containerClassName).val() + '\n');
  }

  $('.' + containerClassName).val($('.' + containerClassName).val() + gzHtml);
}

/*
*画像リストにイベントリスナーを追加する
*/
function addEventListenerToImg(){
  //画像を全部挿入し終わってからイベントリスナーをつける
  $('.pictThumbnail').click(function(){
    if($('input[name=q1]:checked').val() == 'content'){
      insertGzHtmlIntoArticle(makeGzHtmlForArticle(this.src), "articleContent");
    }else if($('input[name=q1]:checked').val() == 'thumbnail'){
      var url = this.src;
      var splittedUrl = url.split('/');
      $('#thumbnail').val(splittedUrl[splittedUrl.length - 1]);
    }else{

    }
  })
}

/********************************************************************************************
*動画にイベントリスナーを追加する
*********************************************************************************************/
/*
*動画リストにイベントリスナーを追加する
*/
function addEventListenerToImgForMv(){
  //画像を全部挿入し終わってからイベントリスナーをつける
  $('.mvThumbnail').click(function(){
      insertMvHtmlIntoArticle(makeMvHtmlForArticle(mvSrc,$(this).attr('name')), "articleContent");
  });
}

/*
*動画挿入用HTML作成
*/
function makeMvHtmlForArticle(mvSrc,title){
  return "<video class='mx-auto d-block' style='max-width: 100%; margin : 1%;' src='"
      + mvSrc + title
      + "' controls></video>";

}

/*
*動画HTML挿入
*/
function insertMvHtmlIntoArticle(mvHtml, containerClassName){
  var val = $('.' + containerClassName).val();
  //中身が空じゃないときは改行コードを入れる
  if (!val == "" ) {
    val = val + '\n';
  }
  $('.' + containerClassName).val(val + mvHtml);
}


/********************************************************************************************
*記事のアップロード
*********************************************************************************************/
function uploadArticle(){
  var id = $('.articleId').val();
  var title = $('.articleTitle').val();
  var thumbnail = $('.articleThumbnail').val();
  var categories = [];
  var content = $('.articleContent').val();
  var draft = -1;

  //下書きが清書か判定する
  if($('input[name=q2]:checked').val() == 'draft'){
    draft = 1;
  }else if($('input[name=q2]:checked').val() == 'clean'){
    draft = 0;
  }
  var csrf = $('input[name=_csrfToken]').val();

  //カテゴリーを全て追加する
  $('.articleCategories').find('input').each(function(){
    //console.log($(this).val());
    categories.push($(this).val());
  });

  //記事をアップロードする
  var inputJson = {
    "id" : id,
    "title" : title,
    "thumbnail" : thumbnail,
    "categories" : categories,
    "content" : content,
    "draft" : draft
  }
  for(var i in categories){
    console.log(categories[i]);
  }
  var url = '/articles/uploadArticle';
  var callback = new Callback();
  callback.callback = function(){
    alert("成功");
  }
  getJsonAndDoSomething(inputJson, url, callback);
}

/********************************************************************************************
*新規カテゴリー追加
*********************************************************************************************/
function plusCategory(){
  var category = $('.plusedCategory').val();
  var inputJson = {
    "category" : category
  }
  var url = '/articles/plusCategory';
  var callback = new Callback();
  callback.callback = function(){
    alert("成功");
    $('#category_id').empty();
    for(var i in this.result){
      $('#category_id').append(
        makeOptionForCategories(this.result[i])
      );
    }
  }
  getJsonAndDoSomething(inputJson, url, callback);
}

/*
*セレクトボックス挿入用の HTML 作成
*/
function makeOptionForCategories(data){
  return '<option value="' + data.id + '">' + data.name + '</option>';
}

/*
*記事にカテゴリーを追加する
*/
function addCategoryToArticle(){
  var id = $('#category_id option:selected').val();
  var name = $('#category_id option:selected').text();
  var flg = true;

  //すでにカテゴリーがある場合はflg = false
  $('.articleCategories').find('input').each(function(){
    if($(this).val() == id){
      flg = false;
    }
  });

  if(flg){
    $('.articleCategories').append(makeBtnForCategory(id, name)).ready(function(){
      //callbackでクリックしたら削除を追加
      $('.articleCategory').click(function(){
        var inputId = searchCategoryFromName($(this).text());
        $(this).remove();
        //同時にinput要素も削除
        $('.articleCategories').find('input[value="' + inputId + '"]').remove();
      });
    });
  }
}

/*
*カテゴリー名からカテゴリーIDを検索する
*/
function searchCategoryFromName(name){
  var val = 0;
  $('#category_id').find('option').each(function(){
    if($(this).text() == name){
      console.log("hello");
      val = $(this).val();
    }
  });

  return val;
}

/*
*カテゴリー追加ようのHTML作成
*/
function makeBtnForCategory(id, name){
  return '<input type="hidden" value="' + id + '">'
   + '<div class="btn btn-outline-dark border articleCategory">' + name + '</div>'
}

/********************************************************************************************
*各種ボタンにイベントリスナーを追加する
*********************************************************************************************/
$(document).ready(function(e)
{
  //uploadpictures
  loadPictures('uploadedList',callbackForLoad);
  $('.uploadPictures').click(function()
  {
    uploadPictures(function(){loadPictures('uploadedList',callbackForLoad)});
    return false;
  });

  //uploadvideos
  loadVideos('uploadedMvList',callbackForMvLoad);
  $('.uploadVideos').click(function()
  {
    uploadVideos(function(){loadVideos('uploadedMvList',callbackForMvLoad)});
    return false;
  });


  $('.addCode').click(function(){
    insertCodeBlock('articleContent');
  });

  $('.addCitation').click(function(){
    insertCitationBlock('articleContent');
  });

  $('.addCategory').click(function(){
    addCategoryToArticle();
  });

  $('.plusCategory').click(function(){
    plusCategory();
  });

  $('.uploadArticle').click(function(){
    uploadArticle();
  });

  $('.articleCategory').click(function(){
    var inputId = searchCategoryFromName($(this).text());
    $(this).remove();
    $('.articleCategories').find('input[value="' + inputId + '"]').remove();
  });


});
