<?php
declare(strict_types=1);

namespace chilimatic\lib\View\Adapter;

use chilimatic\lib\View\Interfaces\IMinimalView;
use chilimatic\lib\View\SettingTrait;

class Json implements IMinimalView
{
    /**
     * <p>
     * this is the HTTP header command so the client knows it's a json
     * he's receiving
     * </p>
     *
     * @var string
     */
    const CONTENT_TYPE_JSON = 'Content-Type: application/json';


    use SettingTrait;


    /**
     * @return string
     */
    public function render()
    {
        $this->initRender();

        return json_encode($this->getAll(), JSON_NUMERIC_CHECK);
    }

    /**
     * @return void
     */
    public function initRender(){}

    /**
     * @param string $key
     * @return bool
     */
    public function __isset(string $key) {
        return isset($this->{$key});
    }

    /**
     * @param string $key
     * @param mixed $val
     */
    public function __set(string $key, $val)
    {
        $this->set($key, $val);
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function __get(string $key)
    {
        return $this->get($key);
    }
}