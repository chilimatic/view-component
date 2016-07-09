<?php
declare(strict_types=1);

namespace chilimatic\lib\View\Interfaces;

/**
 * Interface ViewInterface
 *
 * @package chilimatic\lib\View
 */
Interface IView
{
    /**
     * initializes the specific render presets
     *
     * @return mixed
     */
    public function initRender();


    /**
     * renders per engine differently
     *
     * @param string $templateFile
     */
    public function render(string $templateFile = '');
}