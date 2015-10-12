<div class="panel callout radius large-10 medium-9 large-offset-2 medium-offset-3">
</div>
<div class="actions columns large-2 medium-3">
    <?php
        $this->start('actions');
            echo '<li>' . $this->Html->link(__('Main'), ['action' => 'index']) . '</li>';
        $this->end();
    ?>
    <?= $this->element('General/side-nav');?>
</div>

<div class="activities form large-10 medium-9 columns">
    <?= $this->Form->create($activity) ?>
    <fieldset>
        <legend><?= __('Edit Activity') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->input('project_id', ['options' => $projects, 'empty' => true]);
            echo $this->Form->input('time_in_view', ['label' => 'Time In']);
            echo $this->Form->input('time_out_view', ['label' => 'Time Out']);
            echo $this->Form->input('activity');
            echo $this->Form->input('status');
            echo $this->Form->input('task_id', ['options' => $tasks, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
