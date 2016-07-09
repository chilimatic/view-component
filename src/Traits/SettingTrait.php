<?php
declare(strict_types=1);

namespace chilimatic\lib\View;

use chilimatic\lib\View\Exception\ViewException;

trait SettingTrait
{

    /**
     * Setting object
     */
    private $setting = [];


    /**
     * engine variables (the ones who need to be displayed)
     */
    private $engineVarList = [];


    /**
     * @param string $key
     * @param mixed $value
     *
     * @return $this|bool
     */
    public function setConfigVariable(string $key, $value)
    {

        if (!$key) {
            return false;
        }

        $this->setting[$key] = $value;

        return $this;
    }


    /**
     * @param array $param
     *
     * @return $this|bool
     */
    public function setConfigVariableList(array $param)
    {

        if (!is_array($param)) {
            return false;
        }

        foreach ($param as $key => $value) {
            if (!$key) {
                continue;
            }
            $this->setting[$key] = $value;
        }

        return $this;
    }


    /**
     * @param string $key
     * @param mixed $value
     *
     * @return $this|bool
     */
    public function set(string $key, $value)
    {
        // we don't set empty fields
        if (!$key) {
            throw new ViewException('Empty keys are not allowed!');
        }

        $this->engineVarList[$key] = $value;

        return $this;
    }

    /**
     * just adds a variable to the others
     *
     * @param string $key
     * @param mixed $value
     *
     * @return $this|bool
     */
    public function add(string $key, $value)
    {
        if (!$key) {
            throw new ViewException('Empty keys are not allowed!');
        }

        if (!isset($this->engineVarList[$key])) {
            $this->engineVarList[$key] = $value;

            return $this;
        }

        if (is_array($this->engineVarList[$key])) {
            $this->engineVarList[$key] = array_merge($this->engineVarList[$key], $value);
        }

        return $this;
    }


    /**
     * @param array $param
     *
     * @return $this|bool
     */
    public function setList(array $param)
    {

        if (!is_array($param)) {
            return $this;
        }

        foreach ($param as $key => $value) {
            if (!$key) {
                continue;
            }
            $this->engineVarList[$key] = $value;
        }

        return $this;
    }

    /**
     * @param string $param
     * @return bool|mixed
     */
    public function get(string $param = '')
    {

        if (empty($param)) {
            return null;
        }

        return $this->engineVarList[$param];
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->engineVarList;
    }


    /**
     * @param string $name
     *
     * @return bool
     */
    public function getConfigVariable(string $name)
    {
        if (!$name) {
            return null;
        }

        if (!isset($this->setting[$name])) {
            return null;
        }

        return $this->setting->{$name};
    }


    /**
     * returns you an array of variables
     *
     * @param array $param
     *
     * @return array|bool
     */
    public function getConfigVariableList(array $param)
    {

        if (!$param || !is_array($param)) {
            return null;
        }

        $list = [];

        foreach ($param as $key) {
            $list[$key] = $this->setting[$key];
        }

        return $list;
    }

}
