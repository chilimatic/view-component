<?php


class PHtmlTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function adapterImplementsInterface() {
        $phtml = new \chilimatic\lib\View\Adapter\PHtml();

        self::assertInstanceOf('\chilimatic\lib\View\Interfaces\IView', $phtml);
    }

    /**
     * @test
     * @expectedException \chilimatic\lib\View\Exception\ViewException
     * @expectedExceptionMessage No template-file set or passed as parameter
     */
    public function adapterRenderWithNoTemplateFile() {
        $phtml = new \chilimatic\lib\View\Adapter\PHtml();
        $phtml->render();
    }


    /**
     * @test
     * @expectedException \chilimatic\lib\View\Exception\ViewException
     * @expectedExceptionMessage Template file does not exist
     */
    public function adapterRenderWithInvalidTemplateFileAsParameter() {
        $phtml = new \chilimatic\lib\View\Adapter\PHtml();
        $phtml->render('something.phtml');
    }

    /**
     * @test
     */
    public function adapterRenderWithValidTemplateFileAsSetting() {
        $phtml = new \chilimatic\lib\View\Adapter\PHtml();
        $phtml->setTemplateFile(__DIR__ . '/test.phtml');

        self::assertEquals('<div></div>', $phtml->render());
    }

    /**
     * @test
     */
    public function adapterRenderWithValidTemplateFileAsSettingAndATemplateVar() {
        $phtml = new \chilimatic\lib\View\Adapter\PHtml();
        $phtml->setTemplateFile(__DIR__ . '/test.phtml');
        $phtml->test = 'test123';

        self::assertEquals('<div>test123</div>', $phtml->render());
    }


    /**
     * @test
     */
    public function adapterRenderWithValidTemplateFileAsParamAndATemplateVar() {
        $phtml = new \chilimatic\lib\View\Adapter\PHtml();
        $phtml->test = 'test123';

        self::assertEquals('<div>test123</div>', $phtml->render(__DIR__ . '/test.phtml'));
    }
}