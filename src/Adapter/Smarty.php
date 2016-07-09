<?php
declare(strict_types=1);

namespace chilimatic\lib\View\Adapter;
use chilimatic\lib\View\AbstractTemplateView;
use chilimatic\lib\View\Interfaces\IViewAdapter;

/**
 * Class Smarty
 *
 * @package chilimatic\lib\View
 */
final class Smarty extends AbstractTemplateView implements IViewAdapter
{
    const FILE_EXTENSION = '.tpl';


    public function __construct()
    {
        $this->engine = new \Smarty();
    }

    /**
     * @return string
     */
    public function getExtension() {
        return self::FILE_EXTENSION;
    }

    /**
     * sets the engine vars to the current engine
     * needs to run before the engine really is accessed!
     *
     * @return boolean
     */
    public function initRender()
    {

        if (empty($this->engine_var_list)) {
            return false;
        }

        foreach ($this->engine_var_list as $key => $value) {
            if (empty($key)) {
                continue;
            }

            $this->engine->assign($key, $value);
        }

        return true;
    }

    /**
     * calls the rendering process
     *
     * (non-PHPdoc)
     *
     * @see \chilimatic\view\View_Generic::render()
     */
    public function render(string $template_file = '') : string
    {
        $this->initEngine();
        $this->initRender();

        return $this->engine->fetch($template_file);
    }
}