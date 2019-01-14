<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>

<?= $this->Html->script('jsForArticlesList.js') ?>

<div class="row articleListTitle" style="display:flex; justify-content: center;"><h2 class="text-center" style="text-decoration: underline;">Articles</h2></div>
<div
  class="row articleList"
>
</div>

<!--csrfトークン生成-->
<?= $this->Form->create(null, [
'url'=>['controller'=>'Article','action'=>'index'],
]) ?>
<?= $this->Form->end() ?>
