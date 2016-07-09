<?php
declare(strict_types=1);

namespace chilimatic\lib\View\Adapter;

use chilimatic\lib\View\AbstractView;
use chilimatic\lib\View\Exception\ViewException;

/**
 * Class PHtml
 *
 * @package chilimatic\lib\View
 */
class PHtml extends AbstractView
{
    /**
     * default rendering file extension
     */
    const FILE_EXTENSION = '.phtml';

    /**
     * @var string
     */
    protected $templateFile = '';

    /**
     * rendered final Content
     *
     * @var string
     */
    protected $content = '';


    /**
     * @return mixed|void
     */
    public function initRender()
    {
        if (!$this->getTemplateFile() || !file_exists((string) $this->getTemplateFile())) {
            if ($this->getConfigVariable('templatePath')) {
                $this->setTemplateFile($this->getConfigVariable('templatePath') . self::FILE_EXTENSION);
            } else {
                throw new ViewException('No Tpl found:' . $this->getTemplateFile());
            }
        }
    }

    /**
     * @param string $templateFile
     *
     * @throws \LogicException
     * @throws \ErrorException
     * @return string
     */
    public function render(string $templateFile = '')
    {
        if ($templateFile) {
            $this->setTemplateFile($templateFile);
        }

        $this->initRender();

        if (!$this->getTemplateFile()) {
            throw new ViewException('no template given');
        }


        try {
            ob_start();
            include $this->getTemplateFile();
            $this->content = ob_get_clean();
        } catch (\Exception $e) {
            ob_end_clean();
            throw new ViewException($e->getMessage(), $e->getCode());
        }

        return $this->content;
    }


}