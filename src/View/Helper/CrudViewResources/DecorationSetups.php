<?php

namespace App\View\Helper\CrudViewResources;

use CrudViews\View\Helper\CRUD\Decorator\BasicDecorationSetups;
use CrudViews\View\Helper\CRUD\Decorator;
use Cake\Utility\Text;
use CrudViews\View\Helper\CRUD\CrudFields;
use CrudViews\View\Helper\CRUD\Decorator\TableCellDecorator;
use CrudViews\View\Helper\CRUD\Decorator\BelongsToDecorator;
use CrudViews\View\Helper\CRUD\Decorator\BelongsToSelectDecorator;
use CrudViews\View\Helper\CRUD\Decorator\LiDecorator;
use CrudViews\View\Helper\CRUD\Decorator\LinkDecorator;

/**
 * DecorationSetups are your custom output configurations
 * 
 * The method name is the the name you'll invoke them by.
 * They should return some CrudFields sub-class possibly 
 * decorated with sub-classes of FieldDecorator.
 * 
 * return new CRUD\Decorator\BelongsToDecorator(new CRUD\CrudFields($helper));
 * 
 * They should all take one argument, $helper, which is an instance of CrudHelper
 * 
 * The methods index(), view(), edit(), add() are reserved.
 * If you implement them, they will never be called.
 *
 * @author dondrake
 */
class DecorationSetups extends BasicDecorationSetups {
	
	/**
	 * Return the decorated output for the status method
	 * 
	 * This example method 'status' returns the same as the 'index' base action.
	 * It is provided as an example of what you can do with alternate actions.
	 * 
	 * @param type $helper
	 * @return \App\View\Helper\CRUD\Decorator\TableCellDecorator
	 */
	public function status($helper) {
		return new TableCellDecorator(
//				new Decorator\LabelDecorator(
				new BelongsToDecorator(
				new CrudFields($helper)
		));
	}

	/**
	 * Return the decorated output for the menuIndex method
	 * 
	 * This example method 'status' returns the same as the 'index' base action.
	 * It is provided as an example of what you can do with alternate actions.
	 * 
	 * @param type $helper
	 * @return \App\View\Helper\CRUD\Decorator\TableCellDecorator
	 */
	public function menuIndex($helper) {
		return new TableCellDecorator(
//				new Decorator\LabelDecorator(
				new BelongsToSelectDecorator(
				new CrudFields($helper)
		));
	}
	
	public function liLink($helper) {
		return new LiDecorator(
				new LinkDecorator(
				new CrudFields($helper)
				));
	}
    
    /**
     * This is a standard index page setup
     * Repurposed for the embedded index of Time in a Project view CRUD.
     * @param type $helper
     * @return \App\View\Helper\CrudViewResources\TableCellDecorator
     */
    public function projectTime($helper) {
        return $this->status($helper);
    }
	
}
