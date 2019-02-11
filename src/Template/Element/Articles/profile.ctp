<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>

<?= $this->Html->script('jsForMailForm.js') ?>

<!-- メールフォーム -->
<div class="container" style="max-width:90vw;">
  <div class="row" style="display:flex; justify-content: center;"><h2 class="text-center" style="text-decoration: underline;">プロフィール</h2></div>
  <div class="row" style="display: flex; justify-content: center">
    <img src="/img/zatsu.png"/>
  </div>
  <div class="row" style="display:flex; justify-content: center; margin-bottom:1.5vh">
    <div>
      <div class="col-12">*名前 : ツダ</div>
      <div class="col-12">*概要 : 主にコーディング関連の記事を書くつもりです。よろしくお願いします。</div>
      <div class="col-12">*趣味 : 読書、カフェ巡りなど</div>
      <div class="col-12">*twitter : <a href="https://twitter.com/codingzakki">https://twitter.com/codingzakki</a></div>
    </div>
  </div>
</div>

<!--csrfトークン生成-->
<!-- <?= $this->Form->create(null, [
'url'=>['controller'=>'Article','action'=>'index'],
]) ?>
<?= $this->Form->end() ?> -->
