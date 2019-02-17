<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>

<?= $this->Html->css('cssForArticleList.css') ?>
<?= $this->Html->script('jsForArticlesList.js') ?>

<div class="row articleListTitle" style="display:flex; justify-content: center;"><h2 class="text-center" style="text-decoration: underline;"></h2></div>
<div
  class="row articleList"
>
</div>
<div class="row" style="display:flex; justify-content: center;">
  <div class="pagination">
  </div>
  <input type="hidden" class="page" value="0" />
</div>
