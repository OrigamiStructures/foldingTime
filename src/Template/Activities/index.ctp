<div class="panel callout radius large-10 medium-9 large-offset-2 medium-offset-3">
    <p>The URL can accept 2 optional args '{host}/activities/index/{days}/{user_id}' where days and user_id are integers</p>
    <h3>Viewing: <?php //$activities->activity->user->name;?></h3>
</div>
<div class="actions columns large-2 medium-3">
    <?= $this->element('General/side-nav');?>
</div>
<div class="activities index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('project_id') ?></th>
            <th><?= $this->Paginator->sort('time_in') ?></th>
            <th><?= $this->Paginator->sort('time_out') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($activities as $activity): ?>
        <tr>
            <td>
                <?= $activity->has('project') ? $this->Html->link($activity->project->name, ['controller' => 'Projects', 'action' => 'view', $activity->project->id]) : '' ?>
            </td>
            <td><?= h($activity->time_in) ?></td>
            <td><?= h($activity->duration) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $activity->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $activity->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $activity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activity->id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
