<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use App\Lib\dmDebug;
use Cake\Routing\Router;
use CrudViews\Controller\AppController as BaseController;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends BaseController {
	
	public $helpers = ['Form', 'Html', 'Cake3xMarkdown.CakeMarkdown'];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Flash');
		$this->connectCrudViews([
            'Clients',
            'Groups',
            'Projects',
            'Tasks',
            'Times',
            'Users',
//            'Activities.duplicateActivityRow',
            'Activities.index'
            ]);
		$this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [            
                    'fields' => [
                        'username' => 'username', 
                        'password' => 'pass3'
                    ]
                ]
            ],
			'loginRedirect' => [
				'controller' => 'Times',
				'action' => 'index'
			],
			'logoutRedirect' => [
				'controller' => 'Pages',
				'action' => 'display',
				'home'
			]
		]);
    }
	
	/**
	 * Pass this call through to CrudView plugin
	 */
	public function beforeFilter(Event $event) {
			parent::beforeFilter($event);
            Router::parseNamedParams($this->request);
//			$this->Auth->allow(['index', 'view', 'display', 'edit']);
	}

	/**
	 * Pass this call through to the CrudView plugin
	 *
	 * @param Event $event
	 */
	public function beforeRender(Event $event) {
			parent::beforeRender($event);
			// do whatever else you want
	}
    
}
