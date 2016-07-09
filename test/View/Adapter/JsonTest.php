<?php

class JsonTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function adapterImplementsInterface() {
        $json = new \chilimatic\lib\View\Adapter\Json();

        self::assertInstanceOf('\chilimatic\lib\View\Interfaces\IMinimalView', $json);
    }

    /**
     * @test
     */
    public function adapterRender() {
        $json = new \chilimatic\lib\View\Adapter\Json();
        $json->test = 12;

        self::assertEquals('{"test":12}', $json->render());
    }

}