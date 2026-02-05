<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Paper $paper
 * @var \Cake\Collection\CollectionInterface|string[] $groups
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Papers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="papers form content">
            <?= $this->Form->create($paper) ?>
            <fieldset>
                <legend><?= __('Add Paper') ?></legend>
                <?php
                    echo $this->Form->control('group_id', ['options' => $groups]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('slide');
                    echo $this->Form->control('description');
                    echo $this->Form->control('expiration');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
