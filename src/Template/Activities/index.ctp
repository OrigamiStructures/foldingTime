<p>The URL can accept 2 optional args '{host}/activities/index/{days}/{user_id}' where days and user_id are integers</p>
<div class="actions columns large-2 medium-3">
    <?= $this->element('General/side-nav');?>
</div>
<div class="activities index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('created') ?></th>
            <th><?= $this->Paginator->sort('modified') ?></th>
            <th><?= $this->Paginator->sort('user_id') ?></th>
            <th><?= $this->Paginator->sort('project_id') ?></th>
            <th><?= $this->Paginator->sort('time_in') ?></th>
            <th><?= $this->Paginator->sort('time_out') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($activities as $activity): ?>
        <tr>
            <td><?= $this->Number->format($activity->id) ?></td>
            <td><?= h($activity->created) ?></td>
            <td><?= h($activity->modified) ?></td>
            <td>
                <?= $activity->has('user') ? $this->Html->link($activity->user->name, ['controller' => 'Users', 'action' => 'view', $activity->user->id]) : '' ?>
            </td>
            <td>
                <?= $activity->has('project') ? $this->Html->link($activity->project->name, ['controller' => 'Projects', 'action' => 'view', $activity->project->id]) : '' ?>
            </td>
            <td><?= h($activity->time_in) ?></td>
            <td><?= h($activity->time_out) ?></td>
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
