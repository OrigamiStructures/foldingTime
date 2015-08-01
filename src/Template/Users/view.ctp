<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Times'), ['controller' => 'Times', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Time'), ['controller' => 'Times', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="users view large-10 medium-9 columns">
    <h2><?= h($user->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Username') ?></h6>
            <p><?= h($user->username) ?></p>
            <h6 class="subheader"><?= __('Password') ?></h6>
            <p><?= h($user->password) ?></p>
            <h6 class="subheader"><?= __('Group') ?></h6>
            <p><?= $user->has('group') ? $this->Html->link($user->group->name, ['controller' => 'Groups', 'action' => 'view', $user->group->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Name') ?></h6>
            <p><?= h($user->name) ?></p>
            <h6 class="subheader"><?= __('Photo') ?></h6>
            <p><?= h($user->photo) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($user->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($user->created) ?></p>
            <h6 class="subheader"><?= __('Modified') ?></h6>
            <p><?= h($user->modified) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Times') ?></h4>
    <?php if (!empty($user->times)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Created') ?></th>
            <th><?= __('Modified') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Project Id') ?></th>
            <th><?= __('Time In') ?></th>
            <th><?= __('Time Out') ?></th>
            <th><?= __('Activity') ?></th>
            <th><?= __('User') ?></th>
            <th><?= __('Project') ?></th>
            <th><?= __('Group Id') ?></th>
            <th><?= __('Status') ?></th>
            <th><?= __('Task Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($user->times as $times): ?>
        <tr>
            <td><?= h($times->id) ?></td>
            <td><?= h($times->created) ?></td>
            <td><?= h($times->modified) ?></td>
            <td><?= h($times->user_id) ?></td>
            <td><?= h($times->project_id) ?></td>
            <td><?= h($times->time_in) ?></td>
            <td><?= h($times->time_out) ?></td>
            <td><?= h($times->activity) ?></td>
            <td><?= h($times->user) ?></td>
            <td><?= h($times->project) ?></td>
            <td><?= h($times->group_id) ?></td>
            <td><?= h($times->status) ?></td>
            <td><?= h($times->task_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Times', 'action' => 'view', $times->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Times', 'action' => 'edit', $times->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Times', 'action' => 'delete', $times->id], ['confirm' => __('Are you sure you want to delete # {0}?', $times->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
