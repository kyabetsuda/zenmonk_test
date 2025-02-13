<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
?>

<link rel="stylesheet" href="/css/cssForAddArticles.css<?php echo '?time='.time(); ?>"/>
<script src="/js/admin/jsForAddArticles.js<?php echo '?time='.time(); ?>"></script>

<legend><?= __('Edit Article') ?></legend>
<hr>

<div class="row">
  <div class="mx-auto">
    <input type="radio" name="q1" value="thumbnail"> サムネイル
    <input type="radio" name="q1" value="content"> 記事
  </div>
</div>

<div class="row">
  <div class="mx-auto">
    現在値 : <?=$article->draft?>
    <input type="radio" name="q2" value="draft"> 下書き
    <input type="radio" name="q2" value="clean"> 清書
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
          <?php  echo $this->Form->control('title', ['value' => $article->title, 'class' => 'articleTitle']);?>
        </div>
      </div>

      <div class="row">
        <div class="mx-auto">
          <?=$this->Form->control('thumbnail',['value' => $article->thumbnail, 'type'=>'text', 'readonly' => 'readonly', 'class' => 'articleThumbnail'])?>
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
          <?php  echo $this->Form->textarea('content',['value' => htmlspecialchars_decode($article->content,ENT_QUOTES|ENT_HTML5), 'rows'=>20, 'cols'=>100, 'class'=>'mx-auto articleContent', 'style'=>'max-width:90%']);?>
      </div>

    </fieldset>

    <div class="row">
      <div class="mx-auto">
        <button type="button" class="uploadArticle">upload</button>
        <button type="button" class="previewArticle">preview</button>
      </div>
    </div>
    <?= $this->Form->end() ?>

    <legend><?= __('Accessories') ?></legend>
    <div class="btn addCode">addCode</div>
    <div class="btn addCitation">addCitation</div>
    <div class="btn addHeading">addHeading</div>
    <div class="btn addToc">addToc</div>
    <div class="btn addHref">addHref</div>
    <div class="btn addSmallHref">addSmallHref</div>
    <div class="btn addCenteredFont">addCenteredFont</div>
    <select class="font-color" name="font-color">
      <option value="#000000">black</option>
      <option value="#ff0000">red</option>
      <option value="#ffff00">yellow</option>
    </select>
    <div class="btn addColorFont">addColorFont</div>
    <select id="category_id" name="category_id">
      <?php foreach($categories as $category): ?>
        <option value="<?=$category->id?>"><?=$category->name?></option>
      <?php endforeach?>
    </select>
    <div class="btn addCategory">addCategory</div>
    <input class="plusedCategory" type="text">
    <div class="btn plusCategory">plusCategory</div>
    <input class="addedCitation" type="text">
    <div class="btn addArticleCitation">addCitation</div>

    <?php echo $this->element('UploadPictures/uplPicture', ["callbackForLoad" => "callbackForLoad"]); ?>
    <?php echo $this->element('UploadVideos/uplVideos'); ?>
    <div class="container">
      <div id="previewArticle" class="row" style="display:none;">
      </div>
    </div>
</div>
