<?php
declare(strict_types=1);

namespace chilimatic\lib\View;

use chilimatic\lib\View\Exception\ViewException;

class ViewBuilder
{
    /**
     * @var \chilimatic\lib\View\ViewFactory
     */
    private $viewFactory;


    /**
     * @param string $viewName
     * @param string $viewTemplateFile
     * @param ...$options
     *
     * @throws ViewException
     */
    public function build(string $viewName, $viewTemplateFile = '')
    {
        if (!$viewName) {
            throw new ViewException('No view name was selected');
        }

        $viewFactory = $this->getViewFactory();
        /**
         * @var AbstractView $view
         */
        $view = $viewFactory->make($viewName);
        $view->setConfigVariable('templateFile', $viewTemplateFile);

        return $view;
    }

    /**
     * @return ViewFactory
     */
    public function getViewFactory()
    {
        if (!$this->viewFactory) {
            $this->viewFactory = new ViewFactory();
        }

        return $this->viewFactory;
    }

    /**
     * @param ViewFactory $viewFactory
     *
     * @return $this
     */
    public function setViewFactory($viewFactory)
    {
        $this->viewFactory = $viewFactory;

        return $this;
    }
}