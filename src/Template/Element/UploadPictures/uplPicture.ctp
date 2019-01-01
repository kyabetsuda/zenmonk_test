<?= $this->Html->script('jsForUploadPictures.js') ?>

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
