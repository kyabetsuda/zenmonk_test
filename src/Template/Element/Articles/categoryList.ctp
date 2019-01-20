<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>

<?= $this->Html->script('jsForCategoryList.js') ?>

<!-- カテゴリーリスト -->
<div class="container" style="max-width:90vw;">
  <div class="row" style="display:flex; justify-content: center;"><h2 class="text-center" style="text-decoration: underline;">Categories</h2></div>
  <div class="row categoryList" style="
    display: flex;
    justify-content: center;
  ">
  </div>
</div>

<!--csrfトークン生成-->
<!-- <?= $this->Form->create(null, [
'url'=>['controller'=>'Article','action'=>'index'],
]) ?>
<?= $this->Form->end() ?> -->
