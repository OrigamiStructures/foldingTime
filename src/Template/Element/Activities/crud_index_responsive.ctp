<?php
    $this->append('css');
        echo $this->Html->css('glyphicon');
    $this->end();
	$this->append('script');
		echo $this->Html->script('timekeep');
	$this->end();
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
    <section class="activities">
    <?php
        foreach (${$this->Crud->alias()->variableName} as $entity): 
            $this->Crud->entity = $entity;
		
			echo $this->element('track_row');
		
		endforeach; 
	?>
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
