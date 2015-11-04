<?php
namespace App\View\Helper\CrudViewResources;

use CrudViews\View\Helper\CRUD\BaseColumnOutput;
use \CrudViews\View\Helper\CRUD\ColumnOutputInterface;

/**
 * ColumnTypeOutput contains developer defined output strategies for custom column types
 *
 * @author dondrake
 */
class ColumnOutput extends BaseColumnOutput implements ColumnOutputInterface {

	/**
	 * Show some of long text and hide all for flyout
	 * 
	 * When there is a lot of text for a small area, this shows just the 
	 * truncated lead. The full text is in an element that is hidden. 
	 * Javascript can implement a flyout to show the full thing.
	 * 
	 * @param type $helper
	 */
	public function leadPlus($field, $options = []) {
		$hidden = $this->helper->Html->div(
				'full_text',
				$this->helper->Html->para(
						null, 
						$this->helper->entity->$field
					), 
					['style' => 'position: absolute; display: none;']
				);
		return $this->helper->Html->tag(
				'span', 
				Text::truncate($this->helper->entity->$field, 100) .
				$hidden
			);
	}
    
    public function duration($field, $options = []) {
//        debug($this->helper);
//        die;
        return round($this->helper->entity->duration, 2);
    }
    
    public function activityNotes($field, $options = []) {
        return $this->helper->Html->tag('p', $this->helper->entity->$field, $this->helper->CrudData->attributes("$field.p"));
    }

}
