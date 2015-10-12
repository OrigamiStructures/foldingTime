<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Time'), ['action' => 'edit', $time->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Time'), ['action' => 'delete', $time->id], ['confirm' => __('Are you sure you want to delete # {0}?', $time->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Times'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Time'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="times view large-10 medium-9 columns">
    <h2><?= h($time->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('User') ?></h6>
            <p><?= $time->has('user') ? $this->Html->link($time->user->name, ['controller' => 'Users', 'action' => 'view', $time->user->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Project') ?></h6>
            <p><?= $time->has('project') ? $this->Html->link($time->project->name, ['controller' => 'Projects', 'action' => 'view', $time->project->id]) : '' ?></p>
            <h6 class="subheader"><?= __('User') ?></h6>
            <p><?= h($time->user) ?></p>
            <h6 class="subheader"><?= __('Project') ?></h6>
            <p><?= h($time->project) ?></p>
            <h6 class="subheader"><?= __('Group') ?></h6>
            <p><?= $time->has('group') ? $this->Html->link($time->group->name, ['controller' => 'Groups', 'action' => 'view', $time->group->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Task') ?></h6>
            <p><?= $time->has('task') ? $this->Html->link($time->task->name, ['controller' => 'Tasks', 'action' => 'view', $time->task->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($time->id) ?></p>
            <h6 class="subheader"><?= __('Status') ?></h6>
            <p><?= $this->Number->format($time->status) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($time->created) ?></p>
            <h6 class="subheader"><?= __('Modified') ?></h6>
            <p><?= h($time->modified) ?></p>
            <h6 class="subheader"><?= __('Time In') ?></h6>
            <p><?= h($time->time_in) ?></p>
            <h6 class="subheader"><?= __('Time Out') ?></h6>
            <p><?= h($time->time_out) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Activity') ?></h6>
            <?= $this->Text->autoParagraph(h($time->activity)) ?>
        </div>
    </div>
</div>
