<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Task'), ['action' => 'edit', $task->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Task'), ['action' => 'delete', $task->id], ['confirm' => __('Are you sure you want to delete # {0}?', $task->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tasks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Task'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Times'), ['controller' => 'Times', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Time'), ['controller' => 'Times', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="tasks view large-10 medium-9 columns">
    <h2><?= h($task->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Project') ?></h6>
            <p><?= $task->has('project') ? $this->Html->link($task->project->name, ['controller' => 'Projects', 'action' => 'view', $task->project->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Name') ?></h6>
            <p><?= h($task->name) ?></p>
            <h6 class="subheader"><?= __('State') ?></h6>
            <p><?= h($task->state) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($task->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($task->created) ?></p>
            <h6 class="subheader"><?= __('Modified') ?></h6>
            <p><?= h($task->modified) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Note') ?></h6>
            <?= $this->Text->autoParagraph(h($task->note)) ?>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Times') ?></h4>
    <?php if (!empty($task->times)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Created') ?></th>
            <th><?= __('Modified') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Project Id') ?></th>
            <th><?= __('Time In') ?></th>
            <th><?= __('Time Out') ?></th>
            <th><?= __('Activity') ?></th>
            <th><?= __('User') ?></th>
            <th><?= __('Project') ?></th>
            <th><?= __('Group Id') ?></th>
            <th><?= __('Status') ?></th>
            <th><?= __('Task Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($task->times as $times): ?>
        <tr>
            <td><?= h($times->id) ?></td>
            <td><?= h($times->created) ?></td>
            <td><?= h($times->modified) ?></td>
            <td><?= h($times->user_id) ?></td>
            <td><?= h($times->project_id) ?></td>
            <td><?= h($times->time_in) ?></td>
            <td><?= h($times->time_out) ?></td>
            <td><?= h($times->activity) ?></td>
            <td><?= h($times->user) ?></td>
            <td><?= h($times->project) ?></td>
            <td><?= h($times->group_id) ?></td>
            <td><?= h($times->status) ?></td>
            <td><?= h($times->task_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Times', 'action' => 'view', $times->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Times', 'action' => 'edit', $times->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Times', 'action' => 'delete', $times->id], ['confirm' => __('Are you sure you want to delete # {0}?', $times->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
