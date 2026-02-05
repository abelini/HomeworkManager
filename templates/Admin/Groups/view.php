<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Group $group
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Group'), ['action' => 'edit', $group->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Group'), ['action' => 'delete', $group->id], ['confirm' => __('Are you sure you want to delete # {0}?', $group->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Groups'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Group'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="groups view content">
            <h3><?= h($group->grupo) ?></h3>
            <table>
                <tr>
                    <th><?= __('Turno') ?></th>
                    <td><?= h($group->turno) ?></td>
                </tr>
                <tr>
                    <th><?= __('Grupo') ?></th>
                    <td><?= h($group->grupo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Icon') ?></th>
                    <td><?= h($group->icon) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($group->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Notecomments') ?></h4>
                <?php if (!empty($group->notecomments)) : ?>
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
                        <?php foreach ($group->notecomments as $notecomments) : ?>
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
            <div class="related">
                <h4><?= __('Related Papers') ?></h4>
                <?php if (!empty($group->papers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Group Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Slide') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Expiration') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($group->papers as $papers) : ?>
                        <tr>
                            <td><?= h($papers->id) ?></td>
                            <td><?= h($papers->group_id) ?></td>
                            <td><?= h($papers->name) ?></td>
                            <td><?= h($papers->slide) ?></td>
                            <td><?= h($papers->description) ?></td>
                            <td><?= h($papers->created) ?></td>
                            <td><?= h($papers->expiration) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Papers', 'action' => 'view', $papers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Papers', 'action' => 'edit', $papers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Papers', 'action' => 'delete', $papers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $papers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($group->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Group Id') ?></th>
                            <th><?= __('Nombres') ?></th>
                            <th><?= __('Apellidos') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Photo') ?></th>
                            <th><?= __('Admin') ?></th>
                            <th><?= __('Online') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Pr') ?></th>
                            <th><?= __('Accepted') ?></th>
                            <th><?= __('Register Ip') ?></th>
                            <th><?= __('Access Ip') ?></th>
                            <th><?= __('Starred') ?></th>
                            <th><?= __('Status Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($group->users as $users) : ?>
                        <tr>
                            <td><?= h($users->id) ?></td>
                            <td><?= h($users->password) ?></td>
                            <td><?= h($users->group_id) ?></td>
                            <td><?= h($users->nombres) ?></td>
                            <td><?= h($users->apellidos) ?></td>
                            <td><?= h($users->email) ?></td>
                            <td><?= h($users->photo) ?></td>
                            <td><?= h($users->admin) ?></td>
                            <td><?= h($users->online) ?></td>
                            <td><?= h($users->created) ?></td>
                            <td><?= h($users->modified) ?></td>
                            <td><?= h($users->pr) ?></td>
                            <td><?= h($users->accepted) ?></td>
                            <td><?= h($users->register_ip) ?></td>
                            <td><?= h($users->access_ip) ?></td>
                            <td><?= h($users->starred) ?></td>
                            <td><?= h($users->status_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
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
