<?php
declare(strict_types=1);

namespace chilimatic\lib\View\Adapter;
use chilimatic\lib\View\AbstractView;

/**
 * Class Smarty
 *
 * @package chilimatic\lib\View
 */
final class Smarty extends AbstractView
{

    public function __construct()
    {
        $this->engine = new \Smarty();
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
    public function render(string $template_file = '')
    {
        $this->initEngine();
        $this->initRender();

        return $this->engine->fetch($template_file);
    }
}