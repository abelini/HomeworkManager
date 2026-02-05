<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var string[]|\Cake\Collection\CollectionInterface $groups
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Edit User') ?></legend>
                <?php
                    //echo $this->Form->control('password');
                    echo $this->Form->control('group_id', ['options' => $groups]);
                    echo $this->Form->control('nombres');
                    echo $this->Form->control('apellidos');
                    echo $this->Form->control('email');
                    echo $this->Form->control('photo');
                    echo $this->Form->control('admin');
                    //echo $this->Form->control('online');
                    //echo $this->Form->control('pr');
                   // echo $this->Form->control('register_ip');
                   //echo $this->Form->control('access_ip');
                   //echo $this->Form->control('starred');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
