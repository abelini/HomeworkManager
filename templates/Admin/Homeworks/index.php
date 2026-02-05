<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Homework> $homeworks
 */
?>
<div class="homeworks index content">
    <?= $this->Html->link(__('New Homework'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Homeworks') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('paper_id') ?></th>
                    <th><?= $this->Paginator->sort('titulo') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('rating') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($homeworks as $homework): ?>
                <tr>
                    <td><?= $this->Number->format($homework->id) ?></td>
                    <td><?= $homework->has('user') ? $this->Html->link($homework->user->id, ['controller' => 'Users', 'action' => 'view', $homework->user->id]) : '' ?></td>
                    <td><?= $homework->has('paper') ? $this->Html->link($homework->paper->name, ['controller' => 'Papers', 'action' => 'view', $homework->paper->id]) : '' ?></td>
                    <td><?= h($homework->titulo) ?></td>
                    <td><?= h($homework->created) ?></td>
                    <td><?= h($homework->modified) ?></td>
                    <td><?= h($homework->rating) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $homework->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $homework->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $homework->id], ['confirm' => __('Are you sure you want to delete # {0}?', $homework->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
