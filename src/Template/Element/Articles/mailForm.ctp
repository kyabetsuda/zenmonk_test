<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>

<?= $this->Html->script('jsForMailForm.js') ?>

<!-- メールフォーム -->
<div class="container" style="max-width:90vw;">
  <div class="row" style="display:flex; justify-content: center;"><h2 class="text-center" style="text-decoration: underline;">フォーム</h2></div>
  <div class="row" style="margin-bottom:1.5vh">
    <div>*名前</div>
    <input type="text" class="mailName" style="width:100vw;">
  </div>
  <div class="row" style="margin-bottom:1.5vh">
    <div>*タイトル</div>
    <input type="text" class="mailTitle" style="width:100vw;">
  </div>
  <div class="row" style="margin-bottom:1.5vh">
    <div>*本文</div>
    <textarea class="mailContent" rows="10" style="width:100vw;border: 1px solid #dcdcdc;"></textarea>
  </div>
  <div class="row">
    <div class="btn btn-outline-dark border sendMail">
      送信
    </div>
  </div>
</div>

<!--csrfトークン生成-->
<!-- <?= $this->Form->create(null, [
'url'=>['controller'=>'Article','action'=>'index'],
]) ?>
<?= $this->Form->end() ?> -->
