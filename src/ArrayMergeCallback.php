<?php


namespace IuDev\ArrayMerge;

class ArrayMergeCallback
{
    
    /**
    *  recursively merges two tree like structures (arrays) 
    *  keeping the right side values if the keys overlap, 
    *  applying a callback by key, if present in the first array
    *
    *  @callbackArr ['key1'=>'nameOfFunctionToApply', 'key2'=>'nameOfFunctionToApply2']
    * 
    *  @param array &$left
    *  @param array &$right
    *  @param array $callbackArr
    *  @return: array
    */            
    public static function merge(array &$left, array &$right, array $callbackArr = [])
   {
       foreach ($right as $key => &$value) {
           
           if (is_array($value) && isset($left[$key]) && is_array($left[$key])) {
               $left[$key] = self::merge($left[$key], $value, $callbackArr);
           } else {
               if (isset($callbackArr[$key])) {
                   $left[$key] = call_user_func($callbackArr[$key], $left[$key], $value);
               } else {
                   $left[$key] = $value;
               }
           }
       }
       return $left;
   }
}