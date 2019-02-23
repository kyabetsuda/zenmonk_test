<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>

<?= $this->Html->css('cssForArticleList.css') ?>
<?= $this->Html->script('jsForArticlesList.js') ?>

<div class="row articleListTitle" style="display:flex; justify-content: center;"><h2 class="text-center titleOfArticleListTitle" style="text-decoration: underline;"></h2></div>
<!-- Slider main container -->
<div class="row">
  <div class="mr-auto swiper-container">
      <!-- Additional required wrapper -->
      <div class="swiper-wrapper articleList">
      </div>
      <!-- If we need pagination -->
      <br>
      <div class="swiper-pagination"></div>
      <br>
      <!-- If we need scrollbar -->
      <div class="swiper-scrollbar"></div>
  </div>
</div>
