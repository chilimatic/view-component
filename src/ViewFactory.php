<?php
declare(strict_types=1);

namespace chilimatic\lib\View;
use chilimatic\lib\Interfaces\IFactoryOptions;
use chilimatic\lib\Traits\ClassExists;

/**
 * Class ViewFactory
 * @package chilimatic\lib\View
 */
class ViewFactory implements IFactoryOptions
{

    /**
     * trait that checks if a class does exist
     */
    use ClassExists;

    /**
     * @param string $className
     * @param array $options
     * @return null
     */
    public function make(string $className, $options = [])
    {
        if (!$className || !$this->exists($className)) {
            return null;
        }

        return new $className($options);
    }

    /**
     * @param string $name
     * @param $options
     *
     * @return mixed|null
     */
    public function __invoke(string $name, $options)
    {
        return $this->make($name, $options);
    }
}