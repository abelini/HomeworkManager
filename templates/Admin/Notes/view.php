<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Note $note
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Note'), ['action' => 'edit', $note->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Note'), ['action' => 'delete', $note->id], ['confirm' => __('Are you sure you want to delete # {0}?', $note->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Notes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Note'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="notes view content">
            <h3><?= h($note->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Group') ?></th>
                    <td><?= $note->has('group') ? $this->Html->link($note->group->grupo, ['controller' => 'Groups', 'action' => 'view', $note->group->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($note->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($note->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($note->created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($note->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Notecomments') ?></h4>
                <?php if (!empty($note->notecomments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Comment') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Paper Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($note->notecomments as $notecomments) : ?>
                        <tr>
                            <td><?= h($notecomments->id) ?></td>
                            <td><?= h($notecomments->comment) ?></td>
                            <td><?= h($notecomments->user_id) ?></td>
                            <td><?= h($notecomments->paper_id) ?></td>
                            <td><?= h($notecomments->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Notecomments', 'action' => 'view', $notecomments->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Notecomments', 'action' => 'edit', $notecomments->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Notecomments', 'action' => 'delete', $notecomments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notecomments->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
