<?php
declare(strict_types=1);

namespace chilimatic\lib\View\Adapter;

use chilimatic\lib\View\AbstractTemplateView;
use chilimatic\lib\View\Exception\ViewException;
use chilimatic\lib\View\Interfaces\IViewAdapter;

/**
 * Class PHtml
 *
 * @package chilimatic\lib\View
 */
final class PHtml extends AbstractTemplateView implements IViewAdapter
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
     * @return string
     */
    public function getExtension() : string {
        return self::FILE_EXTENSION;
    }

    /**
     * @return mixed|void
     */
    public function initRender()
    {
        $tmpFile = $templateFile = $this->getTemplateFile();

        if (!$templateFile) {
            if ($this->getConfigVariable('templatePath')) {
                $tmpFile = $this->getConfigVariable('templatePath') . self::FILE_EXTENSION;
            } else {
                throw new ViewException('No template-file set or passed as parameter: ' . $templateFile);
            }
        }

        if (!file_exists((string) $templateFile)) {
            throw new ViewException('Template file does not exist');
        }

        if ($tmpFile != $templateFile) {
            $this->setTemplateFile($templateFile);
        }
    }

    /**
     * @param string $templateFile
     *
     * @throws \LogicException
     * @throws \ErrorException
     * @return string
     */
    public function render(string $templateFile = '') : string
    {
        if ($templateFile) {
            $this->setTemplateFile($templateFile);
        }

        $this->initRender();


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