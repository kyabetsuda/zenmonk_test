<?= $this->Html->script('admin/jsForUploadVideos.js') ?>

<legend><?= __('Uplaod Videos') ?></legend>
<hr>
<?= $this->Form->create(null, [
  'url'=>['controller'=>'Uplpictures','action'=>'add'],
  'type'=>'file',
  'id'=>'uploadVideos'
]) ?>
  <div class="row">
    <div class="mx-auto">
    <?=$this->Form->control('thumbnail',['type'=>'file','class' => 'videoThumbnail'])?>
    </div>
  </div>
  <div class="row">
    <div class="mx-auto">
    <?=$this->Form->control('title',['type'=>'file','class' => 'videoTitle'])?>
    </div>
  </div>
  <div class="row">
    <div class="mx-auto">
      <button type="button" class="uploadVideos">upload</button>
    </div>
  </div>
<?= $this->Form->end() ?>

<div class="row mx-auto">
<div class="mx-auto">=============</div>
</div>

<div class="container uploadedMvList">
</div>
