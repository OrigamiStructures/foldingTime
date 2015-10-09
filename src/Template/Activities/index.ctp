<?php
//    $this->start('script');
//        echo $this->Html->script('timekeep');
//    $this->end();
?>

<div class="panel callout radius large-10 medium-9 large-offset-2 medium-offset-3">
    <p>The URL can accept 2 optional args '{host}/activities/index/{days}/{user_id}' where days and user_id are integers</p>
    <h3>Viewing: <?php //$activities->activity->user->name;?></h3>
</div>
<div class="actions columns large-2 medium-3">
    <?= $this->element('General/side-nav');?>
</div>
<?= $this->Form->create('Activity'); ?>
    <div class="activities index large-10 medium-9 columns">
        <div class="row">
            <div class="columns small-3"><?= $this->Paginator->sort('project_id') ?></div>
            <div class="columns small-3"><?= $this->Paginator->sort('time_in') ?></div>
            <div class="columns small-3"><?= $this->Paginator->sort('duration') ?></div>
            <div class="columns small-3"><?= __('Actions') ?></div>
        </div>
        <?php
            foreach ($activities as $activity):
            $row_class = "row status".$activity->status;
            $row_id = "row_{$activity->id}";
        ?>
        <div class="<?=$row_class?>" id="<?=$row_id?>">
                <div class="columns small-3"><?= $activity->has('project') ? $this->Html->link($activity->project->name, ['controller' => 'Projects', 'action' => 'view', $activity->project->id]) : '' ?></div>
                <div class="columns small-3"><?= h($activity->time_in) ?></div>
                <div class="columns small-3"><?= h($activity->duration) ?></div>
                <div class="columns small-3">
                    <?= $this->Tk->timeFormActionButtons($activity->id, $activity->status);?>
                </div>
        </div>
        <?php endforeach; ?>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>
    </div>
<?= $this->Form->end(); ?>
