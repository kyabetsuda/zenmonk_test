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
    <?= $this->Form->create(null, [
    	'url'=>['controller'=>'articles','action'=>'add']
    ]) ?>
    <fieldset>
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
        <div class="mx-auto">
          <?=$this->Form->control('thumbnail',['type'=>'text', 'readonly' => 'readonly'])?>
        </div>
      </div>

      <div class="row">
          <?php  echo $this->Form->textarea('content',['rows'=>20, 'cols'=>100, 'class'=>'mx-auto articleContent', 'style'=>'max-width:90%']);?>
      </div>

    </fieldset>

    <div class="row">
      <div class="mx-auto">
        <?= $this->Form->button(__('Submit')) ?>
      </div>
    </div>
    <?= $this->Form->end() ?>

    <legend><?= __('Accessories') ?></legend>
    <div class="btn addCode">addCode</div>
    <div class="btn addCitation">addCitation</div>

    <?php echo $this->element('UploadPictures/uplPicture', ["callbackForLoad" => "callbackForLoad"]); ?>

</div>
