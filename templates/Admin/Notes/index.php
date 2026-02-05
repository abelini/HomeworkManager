<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Note> $notes
 */
?>
<div class="notes index content">
    <?= $this->Html->link(__('New Note'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Notes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('group_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notes as $note): ?>
                <tr>
                    <td><?= $this->Number->format($note->id) ?></td>
                    <td><?= $note->has('group') ? $this->Html->link($note->group->grupo, ['controller' => 'Groups', 'action' => 'view', $note->group->id]) : '' ?></td>
                    <td><?= h($note->name) ?></td>
                    <td><?= h($note->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $note->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $note->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $note->id], ['confirm' => __('Are you sure you want to delete # {0}?', $note->id)]) ?>
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
