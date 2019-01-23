
<?= $this->Html->script('jsForPost.js') ?>

<div class="fadeIn">
<div class="row" style="display:flex; justify-content: center;">
  <h2><?=$article->title?></h2>
</div>
<br>
<div class="row">
  <div class="mx-auto">
    <div class="articleCategories" style="
      display: flex;
      justify-content: center;
      "
    >
      <?php foreach($article->categories as $category): ?>
        <input type="hidden" value="<?=$category->id?>">
        <div class="btn btn-outline-dark border articleCategory"><?=$category->name?></div>
      <?php endforeach?>
    </div>
  </div>
</div>
<br>
<div class="row">
  <div class="col-12">
  <?=$article->content?>
  </div>
</div>
</div>
