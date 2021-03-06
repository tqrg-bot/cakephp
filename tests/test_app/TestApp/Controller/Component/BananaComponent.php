<?php
/**
 * BananaComponent
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 3.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace TestApp\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * BananaComponent class
 *
 */
class BananaComponent extends Component {

/**
 * testField property
 *
 * @var string 'BananaField'
 */
	public $testField = 'BananaField';

/**
 * startup method
 *
 * @param Event $event
 * @param Controller $controller
 * @return string
 */
	public function startup(Event $event) {
		$controller->bar = 'fail';
	}
}
