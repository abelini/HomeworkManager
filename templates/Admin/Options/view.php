<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Option $option
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Option'), ['action' => 'edit', $option->name], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Option'), ['action' => 'delete', $option->name], ['confirm' => __('Are you sure you want to delete # {0}?', $option->name), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Options'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Option'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="options view content">
            <h3><?= h($option->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($option->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Value') ?></th>
                    <td><?= h($option->value) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
