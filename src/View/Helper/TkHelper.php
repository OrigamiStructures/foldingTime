<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP TkHelper
 * @author jasont
 */

namespace App\View\Helper;

use Cake\View\Helper;
use App\Lib\dmDebug;
use Cake\View\View;

class TkHelper extends Helper {

    public $helpers = array('Form', 'Html');
    
    public $index = '';

    public function __construct(View $view, $config = []) {
        parent::__construct($view, $config);
    }

    public function beforeRender($viewFile) {
        
    }

    public function afterRender($viewFile) {
        
    }

    public function beforeLayout($viewLayout) {
        
    }

    public function afterLayout($viewLayout) {
        
    }

    public function setProjectDefaultButton($projectId = NULL) {
        $buttonOptions = array('class' => 'button small blue', 'title' => 'Set default project', 'bind' => 'click.setDefaultProject');
        if (empty($projectId)) {
            $buttonOptions['class'] = 'button small';
            $buttonOptions['disabled'] = TRUE;
        }
        return $this->Form->button($this->Html->tag('i', '', array('class' => 'icon-reply')), $buttonOptions);
    }

    public function timeFormActionButtons($index, $status) {
        $this->index = $index;
        $buttons = array(
			$this->duplicateButton(),
            $this->editButton($status)
        );
//        if($status & CLOSED){
//            $buttons[] = $this->actionButton('Refresh', 'click.timeReopen');
//            $buttons[] = $this->actionButton('Delete', 'click.timeDelete');
//        } else {
//            $buttons[] = $this->actionButton('Stop', 'click.timeStop');
//            $buttons[] = $this->pauseButton($status);
//            $buttons[] = $this->actionButton('Delete', 'click.timeDelete');
//        }
        if($status & CLOSED){
            $buttons[] = $this->actionButton('glyphicon icon-refresh', 'click.timeReopen');
            $buttons[] = $this->actionButton('glyphicon icon-trash', 'click.timeDelete');
        } else {
            $buttons[] = $this->actionButton('glyphicon icon-stop', 'click.timeStop');
            $buttons[] = $this->pauseButton($status);
            $buttons[] = $this->actionButton('glyphicon icon-trash', 'click.timeDelete');
        }
        return $this->Html->nestedList($buttons, array('class' => 'button-group round'), ['class' => 'micro button info']);
    }
    
    private function actionButton($type, $bind = NULL) {
        $attributes = [
            'escape' => FALSE, 
            'index' => $this->index];
        if($bind != NULL){
            $attributes['bind'] = $bind;
        }
        return $this->Html->link($this->Html->tag('i', '', array('class' => $type)), '', $attributes);
//        return $this->Html->link($type, '', $attributes);
    }
	
	private function duplicateButton() {
        $attributes = [
            'bind' => 'click.timeDuplicate', 
            'escape' => FALSE, 
            'index' => $this->index, 
            'title' => 'Dup to a new record'
        ];
        $icon = $this->Html->tag('i', '', array('class' => 'glyphicon icon-duplicate'));
        return $this->Html->link($icon, '', $attributes);
	}
    
    private function pauseButton($status) {
        if($status & OPEN){
            $button = $this->actionButton('glyphicon icon-pause', 'click.timePause');
        } else {
            $button = $this->actionButton('glyphicon icon-play', 'click.timeRestart');
        }
        return $button;
    }
    
    private function editButton($status) {
        $icon = $this->Html->tag('i', '', array('class' => 'glyphicon icon-edit'));
        $button = $this->Html->link($icon, ['action' => 'edit', $this->index], ['escape' => FALSE]);
        return $button;
    }
    
//    $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-info-sign')), '', array('bind' => 'click.timeInfo', 'escape' => FALSE, 'index' => $index)),

	/**
	 * Extract the correct task list for a project
	 * 
	 * given a Time record (with project_id field) and 
	 * the full task list (grouped by project id), return the 
	 * tasks for the project with a 'New task' choice prepended. 
	 * Or return just the 'New task' choice if the project has no tasks.
	 * 
	 * @param array $record
	 * @param array $tasks
	 * @return array
	 */
	public function task($record, $tasks) {
		if ($record['Time']['project_id'] != '') {
			$task = (isset($tasks[$record['Time']['project_id']])) ? array_merge(array('newtask' => 'New task'), $tasks[$record['Time']['project_id']]) : array('newtask' => 'New task');
		} else {
			$task = array('newtask' => 'New task');
		}
		return $task;
	}
	
	/*
	 * 		echo $this->Form->input('task_id', array(
			'options' => $task,
			'empty' => 'Choose a task',
			'bind' => 'change.taskChoice',
			'project_id' => $this->request->data['Time']['project_id']
		));		

	 *
	 * 		$this->Form->input("$index.Time.task_id", array(
			'options' => $task,
			'label' => FALSE,
			'div' => FALSE,
			'empty' => 'Choose a task',
			'bind' => 'change.taskChoice',
			'project_id' => $this->request->data[$index]['Time']['project_id']
		)),

	 */
	
	public function taskSelect($field, $data, $options = FALSE){
		$projectId = $data['Time']['project_id'];
		$Task = ClassRegistry::init('Task');
		$task = $Task->projectTasks($projectId);
		$attributes = array(
			'options' => $task,
			'empty' => 'Choose a task',
			'bind' => 'change.taskChoice',
			'project_id' => $projectId,
			'fieldname' => 'task_id',
			'index' => (isset($data['Time']['id'])) ? $data['Time']['id'] : ''
		);
		if ($options) {
			$attributes = array_merge($options, $attributes);
		}
		return $this->Form->input($field, $attributes);
	}
/**
 * Build a nested list (UL/OL) out of an associative array.
 *
 * @param array $list Set of elements to list
 * @param array $options Additional HTML attributes of the list (ol/ul) tag or if ul/ol use that as tag
 * @param array $itemOptions Additional HTML attributes of the list item (LI) tag
 * @param string $tag Type of list tag to use (ol/ul)
 * @return string The nested list
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::nestedList
 */
	public function nestedList($list, $options = array(), $itemOptions = array(), $tag = 'ul') {
		if (is_string($options)) {
			$tag = $options;
			$options = array();
		}
		$items = $this->_nestedListItem($list, $options, $itemOptions, $tag);
		return sprintf($this->Html->_tags[$tag], $this->Html->_parseAttributes($options, null, ' ', ''), $items);
	}

/**
 * Internal function to build a nested list (UL/OL) out of an associative array.
 *
 * @param array $items Set of elements to list
 * @param array $options Additional HTML attributes of the list (ol/ul) tag
 * @param array $itemOptions Additional HTML attributes of the list item (LI) tag
 * @param string $tag Type of list tag to use (ol/ul)
 * @return string The nested list element
 * @see HtmlHelper::nestedList()
 */
	protected function _nestedListItem($items, $options, $itemOptions, $tag) {
		$out = '';

		$index = 1;
		foreach ($items as $key => $item) {
			if (is_array($item)) {
				$item = $key . $this->nestedList($item, $options, $itemOptions, $tag);
			}
			if (isset($itemOptions['even']) && $index % 2 === 0) {
				$itemOptions['class'] = $itemOptions['even'];
			} elseif (isset($itemOptions['odd']) && $index % 2 !== 0) {
				$itemOptions['class'] = $itemOptions['odd'];
			}
			if (strpos($item, $key) === 0) {
				$out .= sprintf($this->Html->_tags['li'], $this->Html->_parseAttributes($itemOptions, array('even', 'odd'), ' ', ''), $item);
			} else {
                $heldIO = $itemOptions;
                $itemOptions = array_merge($itemOptions, array('class' => 'timerow'));
				$out .= sprintf($this->Html->_tags['li'], $this->Html->_parseAttributes($itemOptions, array('even', 'odd'), ' ', ''), "$key : {$this->spanTimeItems($item)}");
                $itemOptions = $heldIO;
			}
			$index++;
		}
		return $out;
	}
    
    /**
     * Setup span classing for times
     * 
     * @param string $item
     * @return string
     */
    protected function spanTimeItems($item) {
        return $this->Html->tag('span', $item, array('class' => 'timeInt'));
    }

}
