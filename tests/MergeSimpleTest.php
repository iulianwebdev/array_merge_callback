<?php
namespace IuDev\Tests;

use IuDev\ArrayMerge\ArrayMergeCallback;
use IuDev\Sampler\SampleFactory;
use PHPUnit\Framework\TestCase;

// require IuDev\ArrayMerge\ArrayMergeCallback;

class MergeSimpleTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_that_simple_merge_does_not_mutate_original()
    {
        $left = SampleFactory::getArrayOfStrings();
        $structure = SampleFactory::getStructre($left);
        $right = $left;

        ArrayMergeCallback::merge($left, $right);

        $this->assertEquals($left, $right);
    }

    public function test_simple_merge_different_keys_but_same_structure()
    {
        $left = SampleFactory::getArrayOfStrings();
        $originalLeft = array_slice($left, 0);
        
        $keyPrefix = 'r_';
        $right = SampleFactory::getArrayOfStrings($keyPrefix);

        $structure = SampleFactory::getStructre($left);

        ArrayMergeCallback::merge($left, $right);

        $this->assertNotEquals($left, $right);
        $this->assertNotEquals($left, $originalLeft);
    }

    /** @test */
    public function test_that_2_simple_arrays_merge_keys()
    {
        $left = [
            'key1' => 1, 
            'key2' => 2,
        ];
        $right = [
            'key1' => 2,
            'key3' => 3,
        ];


        ArrayMergeCallback::merge($left, $right);

        $result = [
            'key1' => 2,
            'key2' => 2, 
            'key3' => 3
        ];

        $this->assertEquals($result, $left);
    }

    /** @test */
    public function test_that_values_are_summed() 
    {
        $arr1 = [
            'key1'=> 1,
            'key2'=> [
                'key3'=>3
            ],
        ];
        $arr2 = [
            'key1'=> 1,
            'key2'=> [
                'key3'=>-1,
                'key4'=>2,
            ],
        ];
        $result = [
            'key1' => 2,
            'key2' => [
                'key3' =>2,
                'key4' =>2,
            ]
        ];

        $callbackArr = [
            'key1'=>[$this, 'sum'],
            'key3'=>[$this, 'sum'],
        ];
        ArrayMergeCallback::merge($arr1, $arr2, $callbackArr);

        $this->assertEquals($result, $arr1);
    }

    public function sum($left, $right) 
    {
        return $left+$right;
    }
}
