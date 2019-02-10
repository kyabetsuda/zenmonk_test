<?= $this->Html->script('admin/jsForUploadPictures.js',['id' => 'thisFile', 'data-callbackforload' => '{$' . $callbackForLoad . '}' ]) ?>

<legend><?= __('Uplaod Pictures') ?></legend>
<hr>
<?= $this->Form->create(null, [
  'url'=>['controller'=>'Uplpictures','action'=>'add'],
  'type'=>'file',
  'id'=>'uploadPictures'
]) ?>
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
