<?php
/**
 * Created by PhpStorm.
 * User: j
 * Date: 09.07.16
 * Time: 19:51
 */

class SettingTraitTest extends PHPUnit_Framework_TestCase
{
    private $mockClass;

    /**
     * @before
     */
    public function prepareClass() {

        $this->mockClass = new class {
            use \chilimatic\lib\View\Traits\SettingTrait;
        };
    }

    /**
     * @test
     * @throws \chilimatic\lib\View\Exception\ViewException
     */
    public function traitReturnsCorrectSetScalarValue() {
        $this->mockClass->set('test', 12);

        self::assertEquals(12, $this->mockClass->get('test'));
    }


    /**
     * @test
     * @throws \chilimatic\lib\View\Exception\ViewException
     */
    public function traitReturnsCorrectSetArrayValue() {
        $this->mockClass->set('test', ['test' => 12]);

        self::assertEquals(['test' => 12], $this->mockClass->get('test'));
    }

    /**
     * @test
     * @throws \chilimatic\lib\View\Exception\ViewException
     */
    public function traitReturnsCorrectSetArrayValueOverridenMultipleTimes() {
        $this->mockClass->set('test', ['test' => 12]);
        $this->mockClass->set('test', ['a' => 13]);
        $this->mockClass->set('test', ['b' => 14]);

        self::assertEquals(['b' => 14], $this->mockClass->get('test'));
    }

    /**
     * @test
     * @throws \chilimatic\lib\View\Exception\ViewException
     */
    public function traitReturnsCorrectAddArrayValueMergedMultipleTimes() {
        $this->mockClass->add('test', ['test' => 12]);
        $this->mockClass->add('test', ['a' => 13]);
        $this->mockClass->add('test', ['b' => 14]);

        self::assertEquals(['test' => 12, 'a' => 13, 'b' => 14], $this->mockClass->get('test'));
    }

    /**
     * @test
     * @throws \chilimatic\lib\View\Exception\ViewException
     */
    public function traitReturnsCorrectAddNestedArrayValueMergedMultipleTimes() {
        $this->mockClass->add('test', ['test' => [12, 13]]);
        $this->mockClass->add('test', ['test' => 14]);

        self::assertEquals(['test' => [12, 13, 14]], $this->mockClass->get('test'));
    }

    /**
     * @test
     */
    public function traitSetConfigVariable() {
        $this->mockClass->setConfigVariable('key', 'value');

        self::assertEquals('value' , $this->mockClass->getConfigVariable('key'));
    }

    /**
     * @test
     */
    public function traitSetConfigVariableList() {
        $this->mockClass->setConfigVariableList(['key' => 'value', 'asdasd' => 12]);

        self::assertEquals('value' , $this->mockClass->getConfigVariable('key'));
    }

    /**
     * @test
     */
    public function traitSetTemplateVarList() {
        $this->mockClass->setList(['key' => 'value', 'asdasd' => 12]);

        self::assertEquals(['key' => 'value', 'asdasd' => 12] , $this->mockClass->getAll());
    }


    /**
     * @test
     * @throws \chilimatic\lib\View\Exception\ViewException
     */
    public function traitReturnsCorrectAddScalarValue() {
        $this->mockClass->add('test', 12);

        self::assertEquals(12, $this->mockClass->get('test'));
    }


    /**
     * @test
     * @expectedException \LogicException
     * @expectedExceptionMessage Catched TypeError
     */
    public function traitThrowsErrorByUsingNullKeyInSet()
    {
        try {
            $this->mockClass->set(null, 213);
        } catch(Throwable $t) {
            throw new \LogicException('Catched TypeError');
        }
    }

    /**
     * @test
     * @throws \chilimatic\lib\View\Exception\ViewException
     */
    public function traitReturnsCorrectAddScalarOverloadValue() {
        $this->mockClass->test = 12;

        self::assertEquals(12, $this->mockClass->test);
    }

    /**
     * @test
     * @expectedException \chilimatic\lib\View\Exception\ViewException
     */
    public function traitReturnsThrowsExceptionIfRestrictedSettingsAreAccessed() {
        $this->mockClass->setting;
    }

    /**
     * @test
     * @expectedException \chilimatic\lib\View\Exception\ViewException
     */
    public function traitReturnsThrowsExceptionIfRestrictedEngineVarListVarsAreAccessed() {
        $this->mockClass->engineVarList;
    }

}