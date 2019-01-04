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

function makeHtmlForArticle(gzSrc){
  return "<img style='max-width: 100%; margin : 1%;' src='"
      + gzSrc
      + "'>";

}

function insertGzHtmlIntoArticle(gzHtml, containerClassName){
  var val = $('.' + containerClassName).val();
  //中身が空じゃないときは改行コードを入れる
  if (!val == "" ) {
    $('.' + containerClassName).val($('.' + containerClassName).val() + '\n');
  }

  $('.' + containerClassName).val($('.' + containerClassName).val() + gzHtml);
}

function addEventListenerToImg(){
  //画像を全部挿入し終わってからイベントリスナーをつける
  $('img').click(function(){
    if($('input[name=q1]:checked').val() == 'content'){
      insertGzHtmlIntoArticle(makeHtmlForArticle(this.src), "articleContent");
    }else if($('input[name=q1]:checked').val() == 'thumbnail'){
      var url = this.src;
      var splittedUrl = url.split('/');
      $('#thumbnail').val(splittedUrl[splittedUrl.length - 1]);
    }else{

    }
  })
}

function uploadArticle(){
  var id = $('.articleId').val();
  var title = $('.articleTitle').val();
  var thumbnail = $('.articleThumbnail').val();
  var categories = [];
  var content = $('.articleContent').val();
  var csrf = $('input[name=_csrfToken]').val();

  $('.articleCategories').find('input').each(function(){
    console.log($(this).val());
    categories.push($(this).val());
  });

  var json = {
    "id" : id,
    "title" : title,
    "thumbnail" : thumbnail,
    "categories" : categories,
    "content" : content
  }

  /**
   * Ajax通信メソッド
   * @param type  : HTTP通信の種類
   * @param url   : リクエスト送信先のURL
   * @param data  : サーバに送信する値
   */
  $.ajax({
      type: 'POST',
      beforeSend: function(xhr){
        xhr.setRequestHeader('X-CSRF-Token', csrf);
      },
      datatype:'json',
      url: "http://" + location.hostname + "/articles/uploadArticle",
      data: json,
      success: function(data,dataType)
      {
        alert("成功");

      },
      /**
       * Ajax通信が失敗した場合に呼び出されるメソッド
       */
      error: function(XMLHttpRequest, textStatus, errorThrown)
      {
        // alert('Error : ' + errorThrown + '\n'
        //   + 'textStatus : ' + textStatus + '\n'
        //   + 'XMLHttpRequest : ' + XMLHttpRequest.status
        // );

        alert("コンテンツ取得時にエラーが発生しました。");
      }
  });

}

function plusCategory(){
  var category = $('.plusedCategory').val();
  var csrf = $('input[name=_csrfToken]').val();

  var json = {
    "category" : category
  }

  /**
   * Ajax通信メソッド
   * @param type  : HTTP通信の種類
   * @param url   : リクエスト送信先のURL
   * @param data  : サーバに送信する値
   */
  $.ajax({
      type: 'POST',
      beforeSend: function(xhr){
        xhr.setRequestHeader('X-CSRF-Token', csrf);
      },
      datatype:'json',
      url: "http://" + location.hostname + "/articles/plusCategory",
      data: json,
      success: function(data,dataType)
      {
        alert("成功");
        $('#category_id').empty();
        for(var i in data){
          $('#category_id').append(
            makeOptionForCategories(data[i])
          );
        }
      },
      /**
       * Ajax通信が失敗した場合に呼び出されるメソッド
       */
      error: function(XMLHttpRequest, textStatus, errorThrown)
      {
        // alert('Error : ' + errorThrown + '\n'
        //   + 'textStatus : ' + textStatus + '\n'
        //   + 'XMLHttpRequest : ' + XMLHttpRequest.status
        // );

        alert("コンテンツ取得時にエラーが発生しました。");
      }
  });
}

function makeOptionForCategories(data){
  return '<option value="' + data.id + '">' + data.name + '</option>';
}

function addCategoryToArticle(){
  var id = $('#category_id option:selected').val();
  var name = $('#category_id option:selected').text();
  var flg = true;

  var val = searchCategoryFromName('プログラミング');
  console.log(val);

  //すでにカテゴリーがある場合はreturn
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

function searchCategoryFromName(name){
  //カテゴリー名からカテゴリーIDを検索する
  var val = 0;
  $('#category_id').find('option').each(function(){
    if($(this).text() == name){
      console.log("hello");
      val = $(this).val();
    }
  });

  return val;
}

function makeBtnForCategory(id, name){
  return '<input type="hidden" value="' + id + '">'
   + '<div class="btn btn-outline-dark border articleCategory">' + name + '</div>'
}

$(document).ready(function(e)
{
  //uploadPictureのためのグローバルメソッド
  callbackForLoad = function(){
    addEventListenerToImg();
  };

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
    $(this).remove();
  });


});
