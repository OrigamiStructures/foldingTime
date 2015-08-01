<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Task'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Times'), ['controller' => 'Times', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Time'), ['controller' => 'Times', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="tasks index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('project_id') ?></th>
            <th><?= $this->Paginator->sort('name') ?></th>
            <th><?= $this->Paginator->sort('created') ?></th>
            <th><?= $this->Paginator->sort('modified') ?></th>
            <th><?= $this->Paginator->sort('state') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($tasks as $task): ?>
        <tr>
            <td><?= $this->Number->format($task->id) ?></td>
            <td>
                <?= $task->has('project') ? $this->Html->link($task->project->name, ['controller' => 'Projects', 'action' => 'view', $task->project->id]) : '' ?>
            </td>
            <td><?= h($task->name) ?></td>
            <td><?= h($task->created) ?></td>
            <td><?= h($task->modified) ?></td>
            <td><?= h($task->state) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $task->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $task->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $task->id], ['confirm' => __('Are you sure you want to delete # {0}?', $task->id)]) ?>
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
