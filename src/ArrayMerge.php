<?php 
declare(strict_types=1);
namespace IuDev\ArrayMerge;

class ArrayMerge extends TreeDimension
{
    private $actions;

    public function __construct($action)
    {
        parent::__construct($level = 1);
        $this->actions[] = $action;
    }

    /**
     * given 2 arrays
     * applies an Action to the array 
     * by keys and/or traversal level 
     *     
     * @param  array  &$left  [description]
     * @param  array  &$right [description]
     * @return [type]         [description]
     */
    public function merge(array &$left, array &$right) 
    {
        foreach ($right as $key => &$value) {
            
            if (is_array($value) && isset($left[$key]) && is_array($left[$key])) {
                $this->incLevel();
                $left[$key] = $this->merge($left[$key], $value);
                $this->decLevel();
            } else {
                $left[$key] = $this->runActions($key, $left[$key], $value);
            }
        }
        return $left;
    }

    /**
     * creates an instance and sets a default action
     * 
     * @param  Action $action
     * @return ArrayMerge        
     */
    public static function init(Action $action) 
    {
        return new static($action);

    }

    /**
     * adds an action to the action arrays
     * 
     * @param  Action $action
     * @return ArrayMerge        
     */
    public function withAction(Action $action) 
    {
        $this->actions[] = $action;
        return $this;
    }

    /**
     * Check if actions needs to be applied and apply if necessary
     * 
     * @param  mixed $key  
     * @param  mixed $left 
     * @param  mixed $right
     * @return mixed       
     */
    private function runActions($key, $left, $right) 
    {
        foreach($this->actions as $action){
            if($action->inScope($key, $this->level())){
                return $action->runMethod($left, $right);
            }
        }
        return $left;
    }

}
