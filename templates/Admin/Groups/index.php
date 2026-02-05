<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Group> $groups
 */
?>
<div class="groups index content">
    <?= $this->Html->link(__('New Group'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Groups') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('turno') ?></th>
                    <th><?= $this->Paginator->sort('grupo') ?></th>
                    <th><?= $this->Paginator->sort('icon') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($groups as $group): ?>
                <tr>
                    <td><?= $this->Number->format($group->id) ?></td>
                    <td><?= h($group->turno) ?></td>
                    <td><?= h($group->grupo) ?></td>
                    <td><?= h($group->icon) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $group->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $group->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $group->id], ['confirm' => __('Are you sure you want to delete # {0}?', $group->id)]) ?>
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
