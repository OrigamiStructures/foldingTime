<?php
//    $recordZoneCols = isset($recordZoneCols) ? $recordZoneCols : 'large-10 medium-9';
    $entityCols = isset($entityCols) ? $entityCols : 'small-10';
    $actionCols = isset($actionCols) ? $actionCols : 'small-2';
//    $this->append('css');
//        echo $this->Html->css('glyphicon');
//    $this->end();
//    $row_class = "row status".$activity->status;
//    $row_id = "row_{$activity->id}";
?>

<!--        <div id="row_<?=$entity->id?>" class="row status<?=$entity->status?>">
            <div class="columns <?=$entityCols?>">
                <div class="row">
                    <?php
//						if (!isset($this->Crud->entity)) {
//							$this->Crud->entity = $entity;
//						}
//						debug($this->Crud->entity);
//						debug($this->Crud->whitelist());die;
//                        $this->Crud->strategy('responsiveRecordRows');
//                        foreach ($this->Crud->whitelist() as $field) :
////                            echo "\t\t\t\t" . $this->Crud->output($field) . "\n";
//                        endforeach;
                    ?>
                </div>
            </div>
            <div class="columns <?=$actionCols?> recordActions">
                <?php
//					echo $this->Tk->timeFormActionButtons($entity->id, $entity->status);
                ?>
            </div>
        </div>-->


<div class="<?=$row_class . ' top_row'?>" id="<?=$row_id?>">
    <div class="columns small-9">
        <div class="row">
            <div class="columns small-4"><?= $activity->has('project') ? $this->Html->link($activity->project->name, ['controller' => 'Projects', 'action' => 'view', $activity->project->id]) : '' ?></div>
            <div class="columns small-6"><?= h($activity->time_in) ?></div>
            <div class="columns small-2"><?= h($activity->duration) ?></div>
        </div>
        <div class="row">
            <div class="columns small-4"><?= $activity->has('task') ? h($activity->task->name) : '' ?></div>
            <div class="columns small-8"><?= h($activity->activity) ?></div>
        </div>
    </div>
    <div class="columns small-3">
        <?= $this->Tk->timeFormActionButtons($activity->id, $activity->status);?>
    </div>
</div>
