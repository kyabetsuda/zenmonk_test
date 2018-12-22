<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Picture $picture
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $picture->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $picture->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Pictures'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="pictures form large-9 medium-8 columns content">
    <?= $this->Form->create($picture) ?>
    <fieldset>
        <legend><?= __('Edit Picture') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('path');
            echo $this->Form->control('ins_ymd');
            echo $this->Form->control('upd_ymd');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
