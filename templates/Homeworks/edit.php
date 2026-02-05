<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Homework $homework
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $papers
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $homework->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $homework->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Homeworks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="homeworks form content">
            <?= $this->Form->create($homework) ?>
            <fieldset>
                <legend><?= __('Edit Homework') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('paper_id', ['options' => $papers]);
                    echo $this->Form->control('titulo');
                    echo $this->Form->control('texto');
                    echo $this->Form->control('rating');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
