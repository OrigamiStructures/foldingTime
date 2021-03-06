<?php
    $this->start('script');
        echo $this->Html->script('timekeep');
    $this->end();
?>

<div class="actions columns large-2 medium-3">
    <?php
        $this->start('actions');
            echo '<li>' . $this->Html->link(__('New Activity'), ['action' => 'add']) . '</li>';
        $this->end();
    ?>
    <?= $this->element('General/side-nav');?>
</div>
<?= $this->Form->create('Activity'); ?>
    <div class="activities index large-10 medium-9 columns">
        <div class="row">
            <div class="columns small-9">
                <div class="row">
                    <div class="columns small-4"><?= $this->Paginator->sort('project_id') ?></div>
                    <div class="columns small-6"><?= $this->Paginator->sort('time_in') ?></div>
                    <div class="columns small-2"><?= $this->Paginator->sort('duration') ?></div>
                </div>
            </div>
            <div class="columns small-3"><?= __('Actions') ?></div>
        </div>
        <section class="activities">
            <?php
                foreach ($activities as $activity):
                    echo $this->element('track_row', ['activity' => $activity]);
                endforeach;
            ?>
        </section>
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
