<?php
    $recordZoneCols = isset($recordZoneCols) ? $recordZoneCols : 'large-10 medium-9';
    $entityCols = isset($entityCols) ? $entityCols : 'small-10';
    $actionCols = isset($actionCols) ? $actionCols : 'small-2';
?>
<div class="activities index columns <?=$recordZoneCols?>">
    <div class="row labels">
        <div class="columns <?=$entityCols?>">
            <div class="row">
                <?php
                    $this->Crud->strategy('responsivePaginatorHead');
                    foreach ($this->Crud->whitelist() as $column_name) {
                        echo $this->Crud->output($column_name);
                    }
                ?>
            </div>
        </div>
        <div class="columns <?=$actionCols?>"><?= __('Actions') ?></div>
    </div>
    <section class="records">
    <?php
        foreach (${$this->Crud->alias()->variableName} as $entity): 
            $this->Crud->entity = $entity;
            $row_class = "row status".$entity->status;
            $row_id = "row_{$entity->id}";
    ?>
        <div class="<?=$row_class . ' top_row'?>" id="<?=$row_id?>">
            <div class="columns <?=$entityCols?>">
                    <?php
						$this->start('header_row');
						$this->end();
						$this->start('data_row');
						$this->end();
                        $this->Crud->strategy('responsiveRecordRows');
						$count = 0;
                        foreach ($this->Crud->whitelist() as $field) :
							if ($count < 3) {
								$this->append('header_row');
								echo "\t\t\t\t" . $this->Crud->output($field) . "\n";
								$this->end();
							} else {
								$this->append('data_row');
								echo "\t\t\t\t" . $this->Crud->output($field) . "\n";
								$this->end();
							}
							$count++;
                        endforeach;
                    ?>
				<div class="header_row row"><?=$this->fetch('header_row');?></div>
				<div class="data_row row"><?=$this->fetch('data_row');?></div>
            </div>
            <div class="columns <?=$actionCols?> recordActions">
                <?= $this->Tk->timeFormActionButtons($entity->id, $entity->status); ?>
            </div>
        </div>
    <?php endforeach; ?>
    </section>
<!--    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>-->
</div>
