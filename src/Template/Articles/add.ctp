<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
?>
<?= $this->Html->script('jsForAddArticles.js') ?>


<legend><?= __('Add Article') ?></legend>
<hr>

<div class="row">
  <div class="mx-auto">
    <input type="radio" name="q1" value="thumbnail"> サムネイル
    <input type="radio" name="q1" value="content"> 記事
  </div>
</div>


<div class="articles form large-9 medium-8 columns content">
    <?= $this->Form->create('null', [
    	'url'=>['controller'=>'articles','action'=>'edit']
    ]) ?>
    <fieldset>
      <input type="hidden" class="articleId" value="<?=$article->id?>">
      <div class="row">
        <div class="mx-auto">
          <?php  echo $this->Form->control('title', ['class' => 'articleTitle']);?>
        </div>
      </div>

      <div class="row">
        <div class="mx-auto">
          <?=$this->Form->control('thumbnail',['type'=>'text', 'readonly' => 'readonly', 'class' => 'articleThumbnail'])?>
        </div>
      </div>

      <div class="row">
        <div class="mx-auto">
          <div class="articleCategories">
            <?php foreach($article->categories as $category): ?>
              <input type="hidden" value="<?=$category->id?>">
              <div class="btn btn-outline-dark border articleCategory"><?=$category->name?></div>
            <?php endforeach?>
          </div>
        </div>
      </div>

      <div class="row">
          <?php  echo $this->Form->textarea('content',['rows'=>20, 'cols'=>100, 'class'=>'mx-auto articleContent', 'style'=>'max-width:90%']);?>
      </div>

    </fieldset>

    <div class="row">
      <div class="mx-auto">
        <button type="button" class="uploadArticle">upload</button>
      </div>
    </div>
    <?= $this->Form->end() ?>

    <legend><?= __('Accessories') ?></legend>
    <div class="btn addCode">addCode</div>
    <div class="btn addCitation">addCitation</div>
    <select id="category_id" name="category_id">
      <?php foreach($categories as $category): ?>
        <option value="<?=$category->id?>"><?=$category->name?></option>
      <?php endforeach?>
    </select>
    <div class="btn addCategory">addCategory</div>
    <input class="plusedCategory" type="text">
    <div class="btn plusCategory">plusCategory</div>

    <?php echo $this->element('UploadPictures/uplPicture', ["callbackForLoad" => "callbackForLoad"]); ?>

</div>
