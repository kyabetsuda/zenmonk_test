<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Picture $picture
 */
?>
<?= $this->Html->script('jsForAddPictures.js') ?>

<div class="pictures form large-9 medium-8 columns content">
    <?= $this->Form->create(null, [
	    'url'=>['controller'=>'pictures','action'=>'add']
    ])?>
    <fieldset>
        <legend><?= __('Add Picture') ?></legend>
        <?php
            echo $this->Form->control('title');
        ?>
	       <?=$this->Form->control('thumbnail',['type'=>'text', 'readonly' => 'readonly'])?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

    <?php echo $this->element('UploadPictures/uplPicture'); ?>

</div>
