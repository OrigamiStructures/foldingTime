<?php
namespace App\View\Helper\CrudViewResources;

use CrudViews\View\Helper\CRUD\BaseColumnOutput;
use CrudViews\View\Helper\CRUD\ColumnOutputInterface;
use Cake\Utility\Text;
use CrudViews\Lib\Uuid;

/**
 * ColumnTypeOutput contains developer defined output strategies for custom column types
 *
 * @author dondrake
 */
class ColumnOutput extends BaseColumnOutput implements ColumnOutputInterface {

	/**
	 * Show truncated long text and hide full version for flyout
	 * 
	 * When there is a lot of text for a small area, this shows just the 
	 * truncated lead. The full text is in an element that is hidden. 
	 * Javascript or css can implement a flyout to show the full thing.
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
	public function leadPlus($field) {
		
		if (!$this->hasUuid()) {
			$uuid = new Uuid();
		} else {
			$uuid = $this->helper->entity->_uuid;
		}
		// established passed and default attributes
		$passed_attributes = $this->helper->attributes("$field.leadPlus");
		$default = new \Cake\Collection\Collection( [
			'full_text' => ['span' => [
				'id' => $uuid->uuid('full'),
				'class' => 'full_text',  
				'style' => 'cursor: pointer; display: none;', 
				'onclick' => 'var id = this.id.replace("full", "truncated"); this.style.display = "none"; document.getElementById(id).style.display = "inline-block";'				]],
			'truncated_text' => ['span' => [
				'id' => $uuid->uuid('truncated'),
				'class' => 'truncated_text', 
				'style' => 'cursor: pointer; display: inline-block;', 
				'onclick' => 'var id = this.id.replace("truncated", "full"); this.style.display = "none"; document.getElementById(id).style.display = "inline-block";',
			]],
			'truncate' => ['limit' => [100]],
			'p' => [],
		]);
		
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
		// SOMEONE SORT THIS OUT TO MAKE IT HAVE DEFAULT out-of-the-box BEHAVIOR
		$hidden = $this->helper->Html->tag(
				'span', 
				$this->helper->entity->$field, 
				$attribute['full_text']['span']);
		$text = $this->helper->Html->tag(
				'span', 
				Text::truncate($this->helper->entity->$field, $attribute['truncate']['limit']), 
				$attribute['truncated_text']['span']);
		
		return $this->helper->Html->tag('p', $text . $hidden, $attribute['p']);
	}
    
	
//    public function duration($field, $options = []) {
//        return round($this->helper->entity->duration, 2);
//    }
//	
//	public function controlledPTag($field, $options = []) {
//		return $this->helper->Html->tag('p', $this->helper->entity->$field, $this->helper->attributes("$field.p"));
//	}

}
