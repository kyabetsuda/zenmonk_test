<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>

<?= $this->Html->script('jsForMailForm.js') ?>
<div class="container" style="border: 1px solid #dcdcdc;">
  <br>
  <div class="row" style="display:flex; justify-content: center;"><h5 class="text-center" style="text-decoration: underline;">プロフィール</h5></div>
  <div class="row" style="display: flex; justify-content: center">
    <img src="/img/zatsu.png"/>
  </div>
  <div class="row" style="display:flex; justify-content: center;">
    <div class="mr-3 ml-3">
      <div class="">*名前 : ツダ</div>
      <div class="">*概要 : 主にコーディング関連の記事を書くつもりです。よろしくお願いします。</div>
      <div class="">*twitter : <a href="https://twitter.com/codingzakki">https://twitter.com/codingzakki</a></div>
    </div>
  </div>
  <br>
</div>
