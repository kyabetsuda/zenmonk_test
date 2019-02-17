<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>

<?= $this->Html->script('jsForMailForm.js') ?>

<!-- メールフォーム -->
<div class="container" style="max-width:90vw; border: 1px solid #dcdcdc;">
    <br>
    <div class="row" style="display:flex; justify-content: center;"><h5 class="text-center" style="text-decoration: underline;">フォーム</h5></div>
    <div class="row" style="margin-bottom:1.5vh;display:flex; justify-content: center;">
      <input type="text" placeholder="*名前" class="mailName" style="width:90%;border: 1px solid #dcdcdc;">
    </div>
    <div class="row" style="margin-bottom:1.5vh;display:flex; justify-content: center;">
      <input type="text" placeholder="*タイトル" class="mailTitle" style="width:90%;border: 1px solid #dcdcdc;">
    </div>
    <div class="row" style="margin-bottom:1.5vh;display:flex; justify-content: center;">
      <textarea class="mailContent" rows="5" style="width:90%;border: 1px solid #dcdcdc;"></textarea>
    </div>
    <div class="row" style="display:flex; justify-content: center;">
      <div class="btn btn-outline-dark border sendMail">
        送信
      </div>
    </div>
    <br>
</div>
