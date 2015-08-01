<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Client'), ['action' => 'edit', $client->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Client'), ['action' => 'delete', $client->id], ['confirm' => __('Are you sure you want to delete # {0}?', $client->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Clients'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="clients view large-10 medium-9 columns">
    <h2><?= h($client->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Name') ?></h6>
            <p><?= h($client->name) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($client->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($client->created) ?></p>
            <h6 class="subheader"><?= __('Modified') ?></h6>
            <p><?= h($client->modified) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Projects') ?></h4>
    <?php if (!empty($client->projects)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Client Id') ?></th>
            <th><?= __('Name') ?></th>
            <th><?= __('Note') ?></th>
            <th><?= __('Created') ?></th>
            <th><?= __('Modified') ?></th>
            <th><?= __('State') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($client->projects as $projects): ?>
        <tr>
            <td><?= h($projects->id) ?></td>
            <td><?= h($projects->client_id) ?></td>
            <td><?= h($projects->name) ?></td>
            <td><?= h($projects->note) ?></td>
            <td><?= h($projects->created) ?></td>
            <td><?= h($projects->modified) ?></td>
            <td><?= h($projects->state) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Projects', 'action' => 'view', $projects->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Projects', 'action' => 'edit', $projects->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Projects', 'action' => 'delete', $projects->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projects->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
