<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'OS Time';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('main.css') ?>
    
    <?= $this->Html->script('../bower_components/modernizr/modernizr');?>
    <?php
        $this->prepend('script', $this->Html->script('app'));
        $this->prepend('script', $this->Html->script('../bower_components/foundation/js/foundation.min'));
        $this->prepend('script', $this->Html->script('../bower_components/fastclick/lib/fastclick'));
        $this->prepend('script', $this->Html->script('../bower_components/jquery/dist/jquery'));
        
        $this->start('jsGlobalVars');
            echo "var webroot = '{$this->request->webroot}';";
            echo "var action = '{$this->request->params['action']}/';";
            echo "var controller = '{$this->request->params['controller']}/';";
        $this->end();
        echo "<script type=\"text/javascript\">
        //<![CDATA[
        // global data for javascript\r";
        echo $this->fetch('jsGlobalVars');
        echo"\r//]]>
        </script>";
    ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <header>
        <?= $this->element('General/header'); ?>
    </header>
    <div id="container">

        <div id="content">
            <div id="flash_message">
                <?= $this->Flash->render() ?>                
            </div>

            <div class="row">
                <?= $this->fetch('content') ?>
            </div>
        </div>
        <footer>
        </footer>
    </div>
    <?= $this->fetch('script') ?>
</body>
</html>
