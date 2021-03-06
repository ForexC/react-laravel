<?php

use React\React;

class WrapperTagTest extends PHPUnit_Framework_TestCase {
  
  protected $react;

  public function setUp() {
    $this->react = new React($GLOBALS['reactSource'], $GLOBALS['componentsSource']);
  }

  public function testDataAttributesWithoutProps() {
    $elementString = $this->react->render('Alert');
    $element = TestHelpers::stringToElement($elementString);

    $this->assertEquals('Alert', $element->getAttribute('data-react-class'));
    $this->assertEquals('null', $element->getAttribute('data-react-props'));
  }

  public function testDataAttributesWithProps() {
    $props = [ 'name' => 'react-laravel' ];
    $elementString = $this->react->render('Alert', $props);
    $element = TestHelpers::stringToElement($elementString);

    $this->assertEquals('Alert', $element->getAttribute('data-react-class'));
    $this->assertEquals(json_encode($props),
                        $element->getAttribute('data-react-props'));
  }

  public function testDataAttributesWithMoreProps() {
    $props = [
      'name' => 'react-laravel',
      'anotherProp' => 'value'
    ];

    $elementString = $this->react->render('Alert', $props);

    $element = TestHelpers::stringToElement($elementString);

    $this->assertEquals('Alert', $element->getAttribute('data-react-class'));
    $this->assertEquals(json_encode($props),
                        $element->getAttribute('data-react-props'));
  }

  public function testDefaultWrapperTagName() {
    $elementString = $this->react->render('Alert');
    $element = TestHelpers::stringToElement($elementString);

    $this->assertEquals('div', $element->tagName);
  }

  public function testCustomWrapperTagName() {
    $elementString = $this->react->render('Alert', null, [ 'tag' => 'span' ]);
    $element = TestHelpers::stringToElement($elementString);

    $this->assertEquals('span', $element->tagName);
  }

  public function testHTMLAttributes() {

    $attributes = [
      'id' => 'react-laravel',
      'class' => 'react_laravel_class',
      'tag' => 'span'
    ];

    $elementString = $this->react->render('Alert', null, $attributes);
    
    $element = TestHelpers::stringToElement($elementString);

    $this->assertTrue($element->hasAttributes());
    $this->assertEquals('react-laravel', $element->getAttribute('id'));
    $this->assertEquals('react_laravel_class', $element->getAttribute('class'));
    $this->assertEquals('', $element->getAttribute('tag'));
    $this->assertEquals('', $element->getAttribute('prerender'));
  }
}