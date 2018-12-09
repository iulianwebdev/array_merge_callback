<?php 

namespace IuDev\Sampler;

/**
 *  Sample factory for tests
 */


class SampleFactory
{
    public static function getArrayOfStrings(string $prefix = 'k_'): array
    {
        return [
            $prefix.'1_1' => 'value',
            $prefix.'1_2' => [
                $prefix.'2_1' => 'value',
                $prefix.'2_2' => [
                    $prefix.'3_1' => 'value',
                    $prefix.'3_2' => 'value',
                    $prefix.'3_3' => 'value',
                ],
            ],
        ];
    }

    public static function getArrayOfInts(string $prefix = 'k_'):array
    {
        return [
            $prefix.'1_1' => 11,
            $prefix.'1_2' => [
                $prefix.'2_1' => 21,
                $prefix.'2_2' => [
                    $prefix.'3_1' => 31,
                    $prefix.'3_2' => 32,
                    $prefix.'3_3' => 33,
                ],
                $prefix.'2_3' => 21,
            ],
            $prefix.'1_3' => 12,
            $prefix.'1_4' => [
                $prefix.'2_1' => 2,
                $prefix.'2_2' => 3,
            ]
        ];
    }

    public static function getArrayOfIntsWithDoubledValues(string $prefix = 'k_'): array
    {
        return [
            $prefix.'1_1' => 22,
            $prefix.'1_2' => [
                $prefix.'2_1' => 42,
                $prefix.'2_2' => [
                    $prefix.'3_1' => 62,
                    $prefix.'3_2' => 64,
                    $prefix.'3_3' => 66,
                ],
                $prefix.'2_3' => 42,
            ],
            $prefix.'1_3' => 24,
            $prefix.'1_4' => [
                $prefix.'2_1' => 4,
                $prefix.'2_2' => 6,
            ]
        ];
    }

    public static function getStructre(array $array): array 
    {
        array_walk_recursive($array, function(&$val, $key){
            if(is_array($val)){
                $val = array_keys($val);
            } else {
                $val = $key;
            }
        });
        return $array;
    }

    public static function getArrayOfMixed(string $prefix = 'k_', $base = 10):array
    {
        return [
           $prefix.'1_1' => $base + 1,
           $prefix.'1_2' => [
               $prefix.'2_1' => $base + 2,
               $prefix.'2_2' => 'value',
               $prefix.'2_3' => [
                   $prefix.'3_1' => $base + 3,
                   $prefix.'3_2' => 'value',
                   $prefix.'3_3' => $base + 4,
               ],
           ],
           $prefix.'1_3' => 'value',
        ];
    }
}
