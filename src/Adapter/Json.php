<?php
declare(strict_types=1);

namespace chilimatic\lib\View\Adapter;

use chilimatic\lib\View\Interfaces\IMinimalView;
use chilimatic\lib\View\Traits\SettingTrait;

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
}