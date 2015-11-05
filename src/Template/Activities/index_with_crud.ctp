<?php 
$this->append('css');
    echo $this->Html->css('CrudViews.crudBase');
    echo $this->Html->css('glyphicon');
$this->end();
$this->append('script');
    echo $this->Html->script('timekeep');
$this->end();

?>
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
	<?= $this->element('CrudViews.CRUD/crud_actions_ul'); ?>
</div>
<div class="tags index large-10 medium-9 columns">
	<?= $this->element('activity_crud_index'); ?>
</div>
<?php 

?>
<div class="paginator">
	<ul class="pagination">
		<?= $this->Paginator->prev('< ' . __('previous')) ?>
		<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('next') . ' >') ?>
	</ul>
	<p><?= $this->Paginator->counter() ?></p>
</div>
