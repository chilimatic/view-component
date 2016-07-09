<?php
declare(strict_types=1);

namespace chilimatic\lib\View\Traits;

use chilimatic\lib\View\Exception\ViewException;

/**
 * Class SettingTrait
 * @package chilimatic\lib\View\Traits
 */
trait SettingTrait
{

    /**
     * Setting
     * @var array
     */
    private $setting = [];

    /**
     * engine variables (the ones who need to be displayed)
     * @var array
     */
    private $engineVarList = [];

    /**
     * this is only so the magic methods cannot be used to access the engineVarList and setting
     *
     * @var array
     */
    private static $restrictedPropertyList = ['setting', 'engineVarList'];


    /**
     * @param string $key
     * @param mixed $value
     *
     * @return $this|bool
     * @throws ViewException
     */
    public function setConfigVariable(string $key, $value)
    {

        if ($key === '' || $key === null) {
            // if you're not strict you get this errors
            throw new ViewException('Config variable key is not allowed to be empty');
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
            return $this;
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
     * @throws ViewException
     */
    public function set(string $key, $value)
    {
        // we don't set empty fields
        if ($key === '' || $key === null) {
            // if you're not strict you get this errors
            throw new ViewException('Empty keys are not allowed!');
        }

        $this->engineVarList[$key] = $value;

        return $this;
    }

    /**
     * !!! important !!!
     *
     * add merges nested arrays together
     * please look in the tests
     *
     * @param string $key
     * @param mixed $value
     *
     * @return $this|bool
     * @throws ViewException
     */
    public function add(string $key, $value)
    {
        if ($key === '' || $key === null) {
            // if you're not strict you get this errors
            throw new ViewException('Empty keys are not allowed!');
        }

        if (!isset($this->engineVarList[$key])) {
            $this->engineVarList[$key] = $value;

            return $this;
        }

        if (is_array($this->engineVarList[$key])) {
            $this->engineVarList[$key] = array_merge_recursive($this->engineVarList[$key], $value);
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
    public function get(string $key = '')
    {

        if ($key === '' || $key === null || !isset($this->engineVarList[$key])) {
            return null;
        }

        return $this->engineVarList[$key];
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->engineVarList;
    }


    /**
     * @param string $key
     *
     * @return bool
     */
    public function getConfigVariable(string $key)
    {
        if ($key === '' || $key === null) {
            return null;
        }

        if (!isset($this->setting[$key])) {
            return null;
        }

        return $this->setting[$key];
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
        if (in_array($key, self::$restrictedPropertyList, false)) {
            return;
        };

        $this->set($key, $val);
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     * @throws ViewException
     */
    public function __get(string $key)
    {
        if (in_array($key, self::$restrictedPropertyList, false)) {
            throw new ViewException('Trying to access restricted Variables');
        };


        return $this->get($key);
    }

}
