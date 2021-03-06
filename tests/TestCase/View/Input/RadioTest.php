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

use Cake\Collection\Collection;
use Cake\TestSuite\TestCase;
use Cake\View\Input\Label;
use Cake\View\Input\Radio;
use Cake\View\StringTemplate;

/**
 * Radio test case
 */
class RadioTest extends TestCase {

/**
 * setup method.
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$templates = [
			'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
			'label' => '<label{{attrs}}>{{text}}</label>',
			'radioContainer' => '{{input}}{{label}}',
		];
		$this->templates = new StringTemplate($templates);
	}

/**
 * Test rendering basic radio buttons.
 *
 * @return void
 */
	public function testRenderSimple() {
		$label = new Label($this->templates);
		$radio = new Radio($this->templates, $label);
		$data = [
			'name' => 'Crayons[color]',
			'options' => ['r' => 'Red', 'b' => 'Black']
		];
		$result = $radio->render($data);
		$expected = [
			['input' => [
				'type' => 'radio',
				'name' => 'Crayons[color]',
				'value' => 'r',
				'id' => 'crayons-color-r'
			]],
			['label' => ['for' => 'crayons-color-r']],
			'Red',
			'/label',
			['input' => [
				'type' => 'radio',
				'name' => 'Crayons[color]',
				'value' => 'b',
				'id' => 'crayons-color-b'
			]],
			['label' => ['for' => 'crayons-color-b']],
			'Black',
			'/label',
		];
		$this->assertTags($result, $expected);

		$data = [
			'name' => 'Crayons[color]',
			'options' => new Collection(['r' => 'Red', 'b' => 'Black'])
		];
		$result = $radio->render($data);
		$this->assertTags($result, $expected);
	}

/**
 * Test rendering inputs with the complex option form.
 *
 * @return void
 */
	public function testRenderComplex() {
		$label = new Label($this->templates);
		$radio = new Radio($this->templates, $label);
		$data = [
			'name' => 'Crayons[color]',
			'options' => [
				['value' => 'r', 'text' => 'Red', 'id' => 'my_id'],
				['value' => 'b', 'text' => 'Black', 'id' => 'my_id_2', 'data-test' => 'test'],
			]
		];
		$result = $radio->render($data);
		$expected = [
			['input' => [
				'type' => 'radio',
				'name' => 'Crayons[color]',
				'value' => 'r',
				'id' => 'my_id'
			]],
			['label' => ['for' => 'my_id']],
			'Red',
			'/label',
			['input' => [
				'type' => 'radio',
				'name' => 'Crayons[color]',
				'value' => 'b',
				'id' => 'my_id_2',
				'data-test' => 'test'
			]],
			['label' => ['for' => 'my_id_2']],
			'Black',
			'/label',
		];
		$this->assertTags($result, $expected);
	}

/**
 * Test rendering the empty option.
 *
 * @return void
 */
	public function testRenderEmptyOption() {
		$label = new Label($this->templates);
		$radio = new Radio($this->templates, $label);
		$data = [
			'name' => 'Crayons[color]',
			'options' => ['r' => 'Red'],
			'empty' => true,
		];
		$result = $radio->render($data);
		$expected = [
			['input' => [
				'type' => 'radio',
				'name' => 'Crayons[color]',
				'value' => '',
				'id' => 'crayons-color'
			]],
			['label' => ['for' => 'crayons-color']],
			'empty',
			'/label',
			['input' => [
				'type' => 'radio',
				'name' => 'Crayons[color]',
				'value' => 'r',
				'id' => 'crayons-color-r'
			]],
			['label' => ['for' => 'crayons-color-r']],
			'Red',
			'/label',
		];
		$this->assertTags($result, $expected);

		$data['empty'] = 'Choose one';
		$result = $radio->render($data);
		$expected = [
			['input' => [
				'type' => 'radio',
				'name' => 'Crayons[color]',
				'value' => '',
				'id' => 'crayons-color'
			]],
			['label' => ['for' => 'crayons-color']],
			'Choose one',
			'/label',
			['input' => [
				'type' => 'radio',
				'name' => 'Crayons[color]',
				'value' => 'r',
				'id' => 'crayons-color-r'
			]],
			['label' => ['for' => 'crayons-color-r']],
			'Red',
			'/label',
		];
		$this->assertTags($result, $expected);
	}

/**
 * Test rendering the input inside the label.
 *
 * @return void
 */
	public function testRenderInputInsideLabel() {
		$this->templates->add([
			'label' => '<label{{attrs}}>{{input}}{{text}}</label>',
			'radioContainer' => '{{label}}',
		]);
		$label = new Label($this->templates);
		$radio = new Radio($this->templates, $label);
		$data = [
			'name' => 'Crayons[color]',
			'options' => ['r' => 'Red'],
		];
		$result = $radio->render($data);
		$expected = [
			['label' => ['for' => 'crayons-color-r']],
			['input' => [
				'type' => 'radio',
				'name' => 'Crayons[color]',
				'value' => 'r',
				'id' => 'crayons-color-r'
			]],
			'Red',
			'/label',
		];
		$this->assertTags($result, $expected);
	}

/**
 * test render() and selected inputs.
 *
 * @return void
 */
	public function testRenderSelected() {
		$label = new Label($this->templates);
		$radio = new Radio($this->templates, $label);
		$data = [
			'name' => 'Versions[ver]',
			'val' => '1',
			'options' => [
				1 => 'one',
				'1x' => 'one x',
				'2' => 'two',
			]
		];
		$result = $radio->render($data);
		$expected = [
			['input' => [
				'id' => 'versions-ver-1',
				'name' => 'Versions[ver]',
				'type' => 'radio',
				'value' => '1',
				'checked' => 'checked'
			]],
			['label' => ['for' => 'versions-ver-1']],
			'one',
			'/label',
			['input' => [
				'id' => 'versions-ver-1x',
				'name' => 'Versions[ver]',
				'type' => 'radio',
				'value' => '1x'
			]],
			['label' => ['for' => 'versions-ver-1x']],
			'one x',
			'/label',
			['input' => [
				'id' => 'versions-ver-2',
				'name' => 'Versions[ver]',
				'type' => 'radio',
				'value' => '2'
			]],
			['label' => ['for' => 'versions-ver-2']],
			'two',
			'/label',
		];
		$this->assertTags($result, $expected);
	}

/**
 * Test rendering with disable inputs
 *
 * @return void
 */
	public function testRenderDisabled() {
		$label = new Label($this->templates);
		$radio = new Radio($this->templates, $label);
		$data = [
			'name' => 'Versions[ver]',
			'options' => [
				1 => 'one',
				'1x' => 'one x',
				'2' => 'two',
			],
			'disabled' => true,
		];
		$result = $radio->render($data);
		$expected = [
			['input' => [
				'id' => 'versions-ver-1',
				'name' => 'Versions[ver]',
				'type' => 'radio',
				'value' => '1',
				'disabled' => 'disabled'
			]],
			['label' => ['for' => 'versions-ver-1']],
			'one',
			'/label',
			['input' => [
				'id' => 'versions-ver-1x',
				'name' => 'Versions[ver]',
				'type' => 'radio',
				'value' => '1x',
				'disabled' => 'disabled'
			]],
			['label' => ['for' => 'versions-ver-1x']],
			'one x',
			'/label',
		];
		$this->assertTags($result, $expected);

		$data['disabled'] = ['1'];
		$result = $radio->render($data);
		$expected = [
			['input' => [
				'id' => 'versions-ver-1',
				'name' => 'Versions[ver]',
				'type' => 'radio',
				'value' => '1',
				'disabled' => 'disabled'
			]],
			['label' => ['for' => 'versions-ver-1']],
			'one',
			'/label',
			['input' => [
				'id' => 'versions-ver-1x',
				'name' => 'Versions[ver]',
				'type' => 'radio',
				'value' => '1x',
			]],
			['label' => ['for' => 'versions-ver-1x']],
			'one x',
			'/label',
		];
		$this->assertTags($result, $expected);
	}

/**
 * Test rendering with label options.
 *
 * @return void
 */
	public function testRenderLabelOptions() {
		$label = new Label($this->templates);
		$radio = new Radio($this->templates, $label);
		$data = [
			'name' => 'Versions[ver]',
			'options' => [
				1 => 'one',
				'1x' => 'one x',
				'2' => 'two',
			],
			'label' => false,
		];
		$result = $radio->render($data);
		$expected = [
			['input' => [
				'id' => 'versions-ver-1',
				'name' => 'Versions[ver]',
				'type' => 'radio',
				'value' => '1',
			]],
			['input' => [
				'id' => 'versions-ver-1x',
				'name' => 'Versions[ver]',
				'type' => 'radio',
				'value' => '1x',
			]],
		];
		$this->assertTags($result, $expected);

		$data = [
			'name' => 'Versions[ver]',
			'options' => [
				1 => 'one',
				'1x' => 'one x',
				'2' => 'two',
			],
			'label' => [
				'class' => 'my-class',
			]
		];
		$result = $radio->render($data);
		$expected = [
			['input' => [
				'id' => 'versions-ver-1',
				'name' => 'Versions[ver]',
				'type' => 'radio',
				'value' => '1',
			]],
			['label' => ['class' => 'my-class', 'for' => 'versions-ver-1']],
			'one',
			'/label',
			['input' => [
				'id' => 'versions-ver-1x',
				'name' => 'Versions[ver]',
				'type' => 'radio',
				'value' => '1x',
			]],
			['label' => ['class' => 'my-class', 'for' => 'versions-ver-1x']],
			'one x',
			'/label',
		];
		$this->assertTags($result, $expected);
	}

/**
 * Ensure that the input + label are composed with
 * a template.
 *
 * @return void
 */
	public function testRenderContainerTemplate() {
		$this->templates->add([
			'radioContainer' => '<div class="radio">{{input}}{{label}}</div>'
		]);
		$label = new Label($this->templates);
		$radio = new Radio($this->templates, $label);
		$data = [
			'name' => 'Versions[ver]',
			'options' => [
				1 => 'one',
				'1x' => 'one x',
				'2' => 'two',
			],
		];
		$result = $radio->render($data);
		$this->assertContains(
			'<div class="radio"><input type="radio"',
			$result
		);
		$this->assertContains(
			'</label></div>',
			$result
		);
	}

}
