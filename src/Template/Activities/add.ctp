<?php
    $tasks_json = json_encode($tasks);
    $this->start('jsGlobalVars');
        echo "tasks = {$tasks_json};";
    $this->end();
?>
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
        <legend><?= __('Add Activity') ?></legend>
        <?php
            $default_user_id = $this->request->session()->read('Auth.User.id');
            echo $this->Form->input('user_id', [
                'options' => $users, 
                'default' => $default_user_id]);
            echo $this->Form->input('project_id', ['options' => $projects, 'empty' => true]);
            echo $this->Form->input('task_id', ['options' => $tasks, 'empty' => true]);
            echo $this->Form->input('activity');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

