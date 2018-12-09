<?php
declare(strict_types=1);
namespace IuDev\ArrayMerge;

class Action extends TreeDimension
{
    /**
     * level = 0, action is applicable to all levels
     */
    const ALL_LEVELS = 0;
    /**
     * keys by which the Action call method should be applied
     * @var array
     */
    private $keys;

    /**
     * callable to be run by the instance
     * @var callable
     */
    private $method;

    /**
     * depth on which it should be applied only, 
     * 0 - throughout the entire structure
     * @var [type]
     */
    private $level;

    /**
     * class instantiation
     * @param callable    $method function that will be applied
     * @param int|integer $level  level or depth that it is valid
     * @param array       $keys   appliable only on certain keys
     */
    public function __construct(callable $method, int $level = 0, array $keys = [])
    {
        $this->method = $method;
        $this->keys = $keys;
        parent::__construct($level);
    }


    /**
     * set an array of keys to run the function on
     * @param  array  $keys
     * @return [type]
     */
    public function onKeys(array $keys): Action
    {
        $this->keys = $keys;
        return $this;
    }

    /**
     * set the level to set the action on
     *  0 - means apply to all nodes
     *
     * @param  int    $level
     */
    public function onLevel(int $level): Action
    {
        $this->setLevel($level);
        return $this;
    }

    /**
     * checks if action should be applied
     * by checking the level  and keys
     *
     * @param  string/int $key
     * @param  int    $level
     */
    public function inScope($key, int $level)
    {
        return $this->level() === self::ALL_LEVELS && $this->inKeys($key) || $this->inKeys($key) && $level === $this->level();
    }

    /**
     * add a key to the keys array
     * @param mixed $key
     */
    public function setKey($key): Action
    {
        $this->keys[] = $key;
        return $this;
    }

    /**
     * set the funtion to be applied by the Action instance
     * @param callable $method
     */
    public function setMethod(callable $method): Action
    {
        $this->method = $method;
        return $this;
    }

    /**
     * apply the function, has access to both arrays values
     * @param  mixed $left
     * @param  mixed $right
     */
    public function runMethod($left, $right)
    {
        return ($this->method)($left, $right);
    }

    /**
     * check key is present in the keys array
     *
     * @param  mixed $key
     */
    private function inKeys($key): bool
    {
        return empty($this->keys) || in_array($key, $this->keys);
    }
}
