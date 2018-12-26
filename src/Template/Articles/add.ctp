<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
?>
<script>
function makeJsonToHtmlGzList(jsonData, containerClassName){

    var tmp = [];
    for(var i in jsonData){
      var rowDiv = $("<div></div>", {
        "class": "row"
      });

      tmp.push(makeDivForGzlist(makeImgHtmlForGzList(jsonData[i].title)));

      //要素が3の倍数個または最後の要素の場合はrowをappend
      if(i%3 == 2 | i==jsonData.length - 1){
        for(var j in tmp){
            rowDiv.append(tmp[j]);
        }
        $('.' + containerClassName).append(rowDiv);
        tmp = [];
      }
    }

}

function makeDivForGzlist(imgHtml){
  return "<div class='col-sm-4'>"
      + imgHtml
      + "</div>";
}

function makeImgHtmlForGzList(title){
  return "<img style='max-width: 100%; margin : 1%;' src='/webroot/img/uploaded/"
      + title
      + "'>";
}

function makeHtmlForArticle(title){
  return ;
}

$(window).on('load',function(){
  var csrf = $('input[name=_csrfToken]').val();
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
      url: "http://" + location.hostname + "/Uplpictures/load",
      success: function(data,dataType)
      {
        makeJsonToHtmlGzList(data, 'uploadedList');
      },
      /**
       * Ajax通信が失敗した場合に呼び出されるメソッド
       */
      error: function(XMLHttpRequest, textStatus, errorThrown)
      {
        alert('Error : ' + errorThrown + '\n'
          + 'textStatus : ' + textStatus + '\n'
          + 'XMLHttpRequest : ' + XMLHttpRequest.status
        );
      }
  });

  return false;

});

$(document).ready(function(e)
{
  /**
  * 送信ボタンクリック
  */
  $('.uploadPictures').click(function()
  {
    // フォームデータを取得
    var formdata = new FormData($('#uploadPictures').get(0));
    var csrf = $('input[name=_csrfToken]').val();
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
        url: "http://" + location.hostname + "/Uplpictures/add",
        data: formdata,
        cache       : false,
        contentType : false,
        processData : false,
        dataType    : "html",
        success: function(data,dataType)
        {
          alert("image was successfully uploaded");
        },
        /**
         * Ajax通信が失敗した場合に呼び出されるメソッド
         */
        error: function(XMLHttpRequest, textStatus, errorThrown)
        {
          alert('Error : ' + errorThrown + '\n'
            + 'textStatus : ' + textStatus + '\n'
            + 'XMLHttpRequest : ' + XMLHttpRequest.status
          );
        }
    });

    return false;

  });
});

</script>

<div class="articles form large-9 medium-8 columns content">
    <?= $this->Form->create(null, [
    	'url'=>['controller'=>'articles','action'=>'add'],
	     'type'=>'file'
    ]) ?>
    <fieldset>
      <legend><?= __('Add Article') ?></legend>
      <hr>

      <div class="row">
        <div class="mx-auto">
          <?php  echo $this->Form->control('title');?>
        </div>
      </div>

      <div class="row">
        <div class="mx-auto">
          <?php  echo $this->Form->control('category_id');?>
        </div>
      </div>

      <div class="row">
          <?php  echo $this->Form->textarea('content',['rows'=>20, 'cols'=>100, 'class'=>'mx-auto', 'style'=>'max-width:90%']);?>
      </div>

      <div class="row">
        <div class="mx-auto">
          <?=$this->Form->control('image',['type'=>'file'])?>
        </div>
      </div>

    </fieldset>

    <div class="row">
      <div class="mx-auto">
        <?= $this->Form->button(__('Submit')) ?>
      </div>
    </div>
    <?= $this->Form->end() ?>

    <?= $this->Form->create(null, [
    	'url'=>['controller'=>'Uplpictures','action'=>'add'],
	    'type'=>'file',
      'id'=>'uploadPictures'
    ]) ?>
      <legend><?= __('Uplaod Pictures') ?></legend>
      <hr>
      <div class="row">
        <div class="mx-auto">
        <?=$this->Form->control('uploadimage',['type'=>'file'])?>
        </div>
      </div>
      <div class="row">
        <div class="mx-auto">
          <button type="button" class="uploadPictures">upload</button>
        </div>
      </div>
    <?= $this->Form->end() ?>

    <div class="row mx-auto">
      <div class="mx-auto">=============</div>
    </div>

    <div class="container uploadedList">
    </div>

</div>
