<?= $this->Html->script('jsForAddVideos.js') ?>

<div class="pictures form large-9 medium-8 columns content">
    <?= $this->Form->create(null, [
	    'url'=>['controller'=>'videos','action'=>'add'],
	    'type'=>'file'
    ])?>
    <fieldset>
      <legend><?= __('Add Videos') ?></legend>
      <?php
          echo $this->Form->control('title');
      ?>

      <legend><?= __('thumbnail') ?></legend>
  	  <?=$this->Form->control('thumbnail',['type'=>'text', 'readonly' => 'readonly'])?>

      <legend><?= __('video') ?></legend>
  	  <?=$this->Form->control('video',['type'=>'file','label'=>false])?>

    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

    <?php echo $this->element('UploadPictures/uplPicture'); ?>

</div>
