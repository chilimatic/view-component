<?php
declare(strict_types=1);

namespace chilimatic\lib\View;
use chilimatic\lib\View\Interfaces\IView;
use chilimatic\lib\View\Traits\SettingTrait;

/**
 * Class Generic
 *
 * @package chilimatic\lib\View
 */
abstract class AbstractView implements IView
{
    const TEMPLATE_FILE_INDEX = 'templateFile';

    /**
     * trait for inheritance
     */
    use SettingTrait;

    /**
     * 3rd party Engine (like Smarty and such)
     *
     * @var mixed|null
     */
    protected $engine;

    /**
     * sets the engine vars to the current engine
     * needs to run before the engine really is accessed!
     *
     * @return boolean
     */
    public function initEngine()
    {

        if (!$this->setting) {
            return false;
        }

        foreach ($this->setting as $key => $value) {
            if (!isset($this->engine[$key])) {
                continue;
            }

            $this->engine->{$key} = $this->setting->{$key};
        }

        return true;
    }

    /**
     * @return mixed
     */
    abstract public function initRender();


    /**
     * @param string $templateFile
     * @return mixed
     */
    abstract public function render(string $templateFile = '');


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->getConfigVariable(self::TEMPLATE_FILE_INDEX);
    }


    /**
     * @param string $templateFile
     *
     * @return $this
     */
    public function setTemplateFile(string $templateFile)
    {
        if (!$templateFile) {
            return $this;
        }
        $this->setConfigVariable(self::TEMPLATE_FILE_INDEX, (string) $templateFile);

        return $this;
    }
}
