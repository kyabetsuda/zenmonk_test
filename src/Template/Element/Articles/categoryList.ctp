<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>

<?= $this->Html->script('jsForCategoryList.js') ?>

<!-- カテゴリーリスト -->
<div class="container" style="max-width:90vw; border: 1px solid #dcdcdc;">
  <br>
  <div class="row" style="display:flex; justify-content: center;"><h5 class="text-center" style="text-decoration: underline;">カテゴリー</h5></div>
  <div class="row categoryList" style="
    display: flex;
    justify-content: center;
  ">
  </div>
  <br>
</div>
