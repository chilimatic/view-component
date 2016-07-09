<?php
namespace chilimatic\lib\View\Interfaces;

/**
 * Interface IMinimalView
 *
 * @package chilimatic\lib\View
 */
interface IMinimalView
{

    /**
     * initializes the specific render presets
     *
     * @return mixed
     */
    public function initRender();

    /**
     * @return mixed
     */
    public function render();

}