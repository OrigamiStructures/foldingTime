<?php
namespace App\View\Helper\CrudViewResources;

use CrudViews\View\Helper\CRUD\BaseColumnOutput;
use CrudViews\View\Helper\CRUD\ColumnOutputInterface;
use Cake\Utility\Text;

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
	 * Attributes:
	 *	$filed.leadPlus =>
	 *		div			// div containing the hidden full text
	 *		p			// div > p containg the full text
	 *		span		// div + span containg truncated text
	 *		truncate	// [truncate][limit] charcter count in truncated text
	 * 
	 * @param type $helper
	 */
	public function leadPlus($field, $options = []) {
		// established passed and default attributes
		$passed_attributes = $this->helper->attributes("$field.leadPlus");
		$default = new \Cake\Collection\Collection(
			['div' => ['style' => 'position: absolute; display: none;'], 
			'span' => [], 'p' => [], 'truncate' => ['limit' => [100]]]
		);
		
		// intermediary values for calculations
		$key_template = $default->map(function($value, $key){ return null; });
		// this yeilds array with all keys. values will be int if passed in, null if default
		$attribute_keys = array_flip(array_keys($passed_attributes)) + $key_template->toArray();
		
		// get attributes to use during rendering
		$attribute = $default->map(function($value, $key) use ($attribute_keys, $passed_attributes) {
			if (is_null($attribute_keys[$key])) {
				return $value;
			} else {
				return array_merge($value, $passed_attributes[$key]);
			}
		})->toArray();
		
		// output
		$hidden = $this->helper->Html->div(
				'full_text',
				$this->helper->Html->tag(
						'p', 
						$this->helper->entity->$field,
						$attribute['p']
					), 
					$attribute['div']
				);
		return $this->helper->Html->tag(
				'span', 
				Text::truncate($this->helper->entity->$field, $attribute['truncate']['limit']) . $hidden,
				$attribute['span']
			);
	}
    
    public function duration($field, $options = []) {
//        debug($this->helper);
//        die;
        return round($this->helper->entity->duration, 2);
    }
	
	public function controlledPTag($field, $options = []) {
		return $this->helper->Html->tag('p', $this->helper->entity->$field, $this->helper->attributes("$field.p"));
	}

}
