<?php
declare(strict_types=1);

namespace chilimatic\lib\View\traits;

use chilimatic\lib\Parser\Annotation\AnnotationViewParser;
use chilimatic\lib\View\AbstractView;

trait MethodAnnotationTemplateHelper
{
    /**
     * @var array
     */
    private static $annotationTemplateCache = [];

    /**
     * @var AnnotationViewParser
     */
    private $annotationViewParser;


    /**
     * @param string $callerName
     * @param string $relativePath
     * @return AbstractView|string
     */
    public function getViewFromAnnotation(string $callerName, string $relativePath)
    {
        $method = str_replace(__CLASS__ . '::', '', $callerName);
        if (!method_exists(__CLASS__, $method)) {
            return '';
        }

        if (!isset(self::$annotationTemplateCache[__CLASS__][$callerName])) {
            if (!$this->annotationViewParser) {
                $this->annotationViewParser = new AnnotationViewParser();
            }

            $reflection = new \ReflectionClass($this);
            $method = $reflection->getMethod($callerName);

            // checks the doc header of the class
            $tokens = $this->annotationViewParser->parse(
                $method->getDocComment()
            );

            /**
             * @var AbstractView $class
             */
            $class = self::$annotationTemplateCache[__CLASS__][$callerName]['class'] = new $tokens[0];
            self::$annotationTemplateCache[__CLASS__][$callerName]['token'] = $tokens;
        } else {
            $class = self::$annotationTemplateCache[__CLASS__][$callerName]['class'];
            $tokens = self::$annotationTemplateCache[__CLASS__][$callerName]['token'];
        }

        if ($relativePath && $tokens[1]) {
            $class->setTemplateFile($relativePath . '/' . $tokens[1]);
        }

        return $class;
    }
}