<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
?>
<?= $this->Html->script('jsForAddArticles.js') ?>

<div class="articles form large-9 medium-8 columns content">
    <?= $this->Form->create(null, [
    	'url'=>['controller'=>'articles','action'=>'add'],
	     'type'=>'file'
    ]) ?>
    <fieldset>
      <legend><?= __('Add Article') ?></legend>
      <hr>

      <div class="row">
        <div class="mx-auto">
          <?php  echo $this->Form->control('title');?>
        </div>
      </div>

      <div class="row">
        <div class="mx-auto">
          <?php  echo $this->Form->control('category_id');?>
        </div>
      </div>

      <div class="row">
          <?php  echo $this->Form->textarea('content',['rows'=>20, 'cols'=>100, 'class'=>'mx-auto articleContent', 'style'=>'max-width:90%']);?>
      </div>

      <div class="row">
        <div class="mx-auto">
          <?=$this->Form->control('image',['type'=>'file'])?>
        </div>
      </div>

    </fieldset>

    <div class="row">
      <div class="mx-auto">
        <?= $this->Form->button(__('Submit')) ?>
      </div>
    </div>
    <?= $this->Form->end() ?>

    <?= $this->Form->create(null, [
    	'url'=>['controller'=>'Uplpictures','action'=>'add'],
	    'type'=>'file',
      'id'=>'uploadPictures'
    ]) ?>
    <legend><?= __('Accessories') ?></legend>
    <div class="btn addCode">addCode</div>
    <div class="btn addCitation">addCitation</div>

    <legend><?= __('Uplaod Pictures') ?></legend>
    <hr>
    <div class="row">
      <div class="mx-auto">
      <?=$this->Form->control('uploadimage',['type'=>'file'])?>
      </div>
    </div>
    <div class="row">
      <div class="mx-auto">
        <button type="button" class="uploadPictures">upload</button>
      </div>
    </div>
    <?= $this->Form->end() ?>

    <div class="row mx-auto">
    <div class="mx-auto">=============</div>
    </div>

    <div class="container uploadedList">
    </div>

</div>
