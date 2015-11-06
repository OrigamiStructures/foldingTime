<?php
    $entityCols = isset($entityCols) ? $entityCols : 'small-10';
    $actionCols = isset($actionCols) ? $actionCols : 'small-2';
	if (!isset($entity)) {
		$entity = $activity;
	}
?>

        <div id="row_<?=$entity->id?>" class="row status<?=$entity->status?>">
            <div class="columns <?=$entityCols?>">
                <div class="row">
                    <?php
						if (!isset($this->Crud->entity)) {
							$this->Crud->entity = $entity;
						}
                        $this->Crud->strategy('responsiveRecordRows');
                        foreach ($this->Crud->whitelist() as $field) :
                            echo "\t\t\t\t" . $this->Crud->output($field) . "\n";
                        endforeach;
                    ?>
                </div>
            </div>
            <div class="columns <?=$actionCols?> recordActions">
                <?php
					echo $this->Tk->timeFormActionButtons($entity->id, $entity->status);
                ?>
            </div>
        </div>

