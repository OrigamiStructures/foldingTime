<?php
    $this->append('actions');
        echo '<li>' . $this->Html->link(__('Clients'), ['controller' => 'Clients', 'action' => 'index']) . '</li>';
        echo '<li>' . $this->Html->link(__('Projects'), ['controller' => 'Projects', 'action' => 'index']) . '</li>';
        echo '<li>' . $this->Html->link(__('Tasks'), ['controller' => 'Tasks', 'action' => 'index']) . '</li>';
        echo '<li>' . $this->Html->link(__('Users'), ['controller' => 'Users', 'action' => 'index']) . '</li>';
    $this->end();
?>

<div class="panel">
    <h4>Folding Time</h4>
    <ul class="side-nav">
        <?= $this->fetch('actions'); ?>
    </ul>
</div>