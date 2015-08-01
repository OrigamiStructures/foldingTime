<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $time->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $time->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Times'), ['action' => 'index']) ?></li>
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
<div class="times form large-10 medium-9 columns">
    <?= $this->Form->create($time) ?>
    <fieldset>
        <legend><?= __('Edit Time') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->input('project_id', ['options' => $projects, 'empty' => true]);
            echo $this->Form->input('time_in');
            echo $this->Form->input('time_out');
            echo $this->Form->input('activity');
            echo $this->Form->input('user');
            echo $this->Form->input('project');
            echo $this->Form->input('group_id', ['options' => $groups, 'empty' => true]);
            echo $this->Form->input('status');
            echo $this->Form->input('task_id', ['options' => $tasks, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
