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
 * @since         CakePHP(tm) v3.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\View\Input;

use Cake\View\Input\InputInterface;

/**
 * Basic input class.
 *
 * This input class can be used to render basic simple
 * input elements like hidden, text, email, tel and other
 * types.
 */
class Basic implements InputInterface {

/**
 * StringTemplate instance.
 *
 * @var Cake\View\StringTemplate
 */
	protected $_templates;

/**
 * Constructor.
 *
 * @param StringTemplate $templates
 */
	public function __construct($templates) {
		$this->_templates = $templates;
	}

/**
 * Render a text widget or other simple widget like email/tel/number.
 *
 * This method accepts a number of keys:
 *
 * - `name` The name attribute.
 * - `val` The value attribute.
 * - `escape` Set to false to disable escaping on all attributes.
 *
 * Any other keys provided in $data will be converted into HTML attributes.
 *
 * @param array $data The data to build an input with.
 * @return string
 */
	public function render(array $data) {
		$data += [
			'name' => '',
			'val' => null,
			'type' => 'text',
			'escape' => true,
		];
		$data['value'] = $data['val'];
		unset($data['val']);

		return $this->_templates->format('input', [
			'name' => $data['name'],
			'type' => $data['type'],
			'attrs' => $this->_templates->formatAttributes(
				$data,
				['name', 'type']
			),
		]);
	}

}
