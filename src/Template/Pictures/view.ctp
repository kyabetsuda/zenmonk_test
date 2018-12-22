<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Picture $picture
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Picture'), ['action' => 'edit', $picture->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Picture'), ['action' => 'delete', $picture->id], ['confirm' => __('Are you sure you want to delete # {0}?', $picture->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Pictures'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Picture'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="pictures view large-9 medium-8 columns content">
    <h3><?= h($picture->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($picture->title) ?></td>
        </tr>
    	<tr>
	<td><img src="/zenmonk/pictures/<?=$picture->title . '.' . $picture->path?>"  alt="<?=$picture->title?>" title="<?=$picture->title?>"></td>
    	</tr>

    </table>
</div>
