<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Time'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="times index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('created') ?></th>
            <th><?= $this->Paginator->sort('modified') ?></th>
            <th><?= $this->Paginator->sort('user_id') ?></th>
            <th><?= $this->Paginator->sort('project_id') ?></th>
            <th><?= $this->Paginator->sort('time_in') ?></th>
            <th><?= $this->Paginator->sort('time_out') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($times as $time): ?>
        <tr>
            <td><?= $this->Number->format($time->id) ?></td>
            <td><?= h($time->created) ?></td>
            <td><?= h($time->modified) ?></td>
            <td>
                <?= $time->has('user') ? $this->Html->link($time->user->name, ['controller' => 'Users', 'action' => 'view', $time->user->id]) : '' ?>
            </td>
            <td>
                <?= $time->has('project') ? $this->Html->link($time->project->name, ['controller' => 'Projects', 'action' => 'view', $time->project->id]) : '' ?>
            </td>
            <td><?= h($time->time_in) ?></td>
            <td><?= h($time->time_out) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $time->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $time->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $time->id], ['confirm' => __('Are you sure you want to delete # {0}?', $time->id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
