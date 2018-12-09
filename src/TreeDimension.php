<?php 

/**
 *  Creates a dimension to a structure
 */

namespace IuDev\ArrayMerge;

abstract class TreeDimension
{
    private $level;

    function __construct(int $level = 0)
    {
        $this->level = $level;
    }

    public function setLevel(int $newLevel) 
    {
        $this->level = $newLevel;
        return $this;
    }

    public function incLevel() 
    {
        ++$this->level;
        return $this;
    }

    public function decLevel() 
    {
        --$this->level;
        return $this;
    }

    public function level() 
    {
        return $this->level;
    }
}