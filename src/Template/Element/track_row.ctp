<?php
    $row_class = "row status".$activity->status;
    $row_id = "row_{$activity->id}";
?>

<div class="<?=$row_class?>" id="<?=$row_id?>">
        <div class="columns small-3"><?= $activity->has('project') ? $this->Html->link($activity->project->name, ['controller' => 'Projects', 'action' => 'view', $activity->project->id]) : '' ?></div>
        <div class="columns small-3"><?= h($activity->time_in) ?></div>
        <div class="columns small-2"><?= h(Cake\I18n\Number::precision($activity->duration, 2)) ?></div>
        <div class="columns small-4">
            <?= $this->Tk->timeFormActionButtons($activity->id, $activity->status);?>
        </div>
</div>
