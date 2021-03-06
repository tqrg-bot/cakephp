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
namespace Cake\Test\TestCase\View\Input;

use Cake\TestSuite\TestCase;
use Cake\View\Input\File;
use Cake\View\StringTemplate;

/**
 * File input test.
 */
class FileTest extends TestCase {

/**
 * setup
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$templates = [
			'fileinput' => '<input type="file" name="{{name}}"{{attrs}}>',
		];
		$this->templates = new StringTemplate($templates);
	}

/**
 * Test render in a simple case.
 *
 * @return void
 */
	public function testRenderSimple() {
		$input = new File($this->templates);
		$result = $input->render(['name' => 'image']);
		$expected = [
			'input' => ['type' => 'file', 'name' => 'image'],
		];
		$this->assertTags($result, $expected);
	}

/**
 * Test render with a value
 *
 * @return void
 */
	public function testRenderAttributes() {
		$input = new File($this->templates);
		$data = ['name' => 'image', 'required' => true, 'val' => 'nope'];
		$result = $input->render($data);
		$expected = [
			'input' => ['type' => 'file', 'required' => 'required', 'name' => 'image'],
		];
		$this->assertTags($result, $expected);
	}

}
