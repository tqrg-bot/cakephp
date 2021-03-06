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
use Cake\View\Input\Button;
use Cake\View\StringTemplate;

/**
 * Basic input test.
 */
class ButtonTest extends TestCase {

	public function setUp() {
		parent::setUp();
		$templates = [
			'button' => '<button type="{{type}}"{{attrs}}>{{text}}</button>',
		];
		$this->templates = new StringTemplate($templates);
	}

/**
 * Test render in a simple case.
 *
 * @return void
 */
	public function testRenderSimple() {
		$button = new Button($this->templates);
		$result = $button->render(['name' => 'my_input']);
		$expected = [
			'button' => ['type' => 'submit', 'name' => 'my_input'],
			'/button'
		];
		$this->assertTags($result, $expected);
	}

/**
 * Test render with custom type
 *
 * @return void
 */
	public function testRenderType() {
		$button = new Button($this->templates);
		$data = [
			'name' => 'my_input',
			'type' => 'button',
			'text' => 'Some button'
		];
		$result = $button->render($data);
		$expected = [
			'button' => ['type' => 'button', 'name' => 'my_input'],
			'Some button',
			'/button'
		];
		$this->assertTags($result, $expected);
	}

/**
 * Test render with a text
 *
 * @return void
 */
	public function testRenderWithText() {
		$button = new Button($this->templates);
		$data = [
			'text' => 'Some <value>'
		];
		$result = $button->render($data);
		$expected = [
			'button' => ['type' => 'submit'],
			'Some <value>',
			'/button'
		];
		$this->assertTags($result, $expected);

		$data['escape'] = true;
		$result = $button->render($data);
		$expected = [
			'button' => ['type' => 'submit'],
			'Some &lt;value&gt;',
			'/button'
		];
		$this->assertTags($result, $expected);
	}

/**
 * Test render with additional attributes.
 *
 * @return void
 */
	public function testRenderAttributes() {
		$button = new Button($this->templates);
		$data = [
			'name' => 'my_input',
			'text' => 'Go',
			'class' => 'btn',
			'required' => true
		];
		$result = $button->render($data);
		$expected = [
			'button' => [
				'type' => 'submit',
				'name' => 'my_input',
				'class' => 'btn',
				'required' => 'required'
			],
			'Go',
			'/button'
		];
		$this->assertTags($result, $expected);
	}

}
