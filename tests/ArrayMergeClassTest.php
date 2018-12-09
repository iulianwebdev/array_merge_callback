<?php
namespace IuDev\Tests;

// use IuDev\ArrayMerge\ArrayMergeCallback;
use IuDev\Sampler\SampleFactory;
use IuDev\ArrayMerge\Action;
use IuDev\ArrayMerge\ArrayMerge;
use PHPUnit\Framework\TestCase;

class ArrayMergeClassTest extends TestCase
{
    const ALL_LEVELS = 0;
    protected static $doubleAction;
    protected static $sumAction;

    public static function setUpBeforeClass() 
    {
        // var_dump('pizza');
        self::$doubleAction = new Action(function($left,$right){
            return $right * 2;
        });

        self::$sumAction = new Action(function($left,$right){
            return $left + $right;
        });
    }

    /** @test */
    public function test_that_merge_works_with_sum_action_on_level_1_only() 
    {
        $arr1 = ['key1' => 2];
        $arr2 = ['key1' => 2];

        $action = self::$doubleAction;
        $action->onLevel(self::ALL_LEVELS)->onKeys(['key1']);

        ArrayMerge::init($action)->merge($arr1,$arr2);

        $result = ['key1' => 4];
        $this->assertEquals($result, $arr1);
        
    }

    public function test_merge_with_multidimensional_array_all_levels() 
    {
        $arr1 = SampleFactory::getArrayOfInts();
        $arr2 = SampleFactory::getArrayOfInts();

        $action = self::$doubleAction;
        $action->onLevel(self::ALL_LEVELS)->onKeys([]);

        ArrayMerge::init($action)->merge($arr1, $arr2);

        $result = SampleFactory::getArrayOfIntsWithDoubledValues();

        $this->assertEquals($result, $arr1);  
    }

    public function test_merge_with_multidimensional_array_only_1_and_3_level() 
    {
        $arr1 = SampleFactory::getArrayOfInts();
        $arr2 = SampleFactory::getArrayOfInts();

        $double = self::$doubleAction;
        $double->onLevel($level = 1);

        $substractTwo = new Action(function($left, $right){
            return $right - 2;
        }, $level = 3);

        ArrayMerge::init($double)->withAction($substractTwo)->merge($arr1, $arr2);

        
        $result = SampleFactory::getArrayOfInts();

        $result['k_1_1'] = $result['k_1_1'] * 2; 
         
        $result['k_1_2']['k_2_2']['k_3_1'] = $result['k_1_2']['k_2_2']['k_3_1'] - 2; 
        $result['k_1_2']['k_2_2']['k_3_2'] = $result['k_1_2']['k_2_2']['k_3_2'] - 2; 
        $result['k_1_2']['k_2_2']['k_3_3'] = $result['k_1_2']['k_2_2']['k_3_3'] - 2; 

        $result['k_1_3'] = $result['k_1_3'] * 2;
        // eval(\Psy\sh());

        $this->assertEquals($result, $arr1);  
    }

    public function test_merge_works_on_int_keys() 
    {
        $arr1 = [
            0=>1,
            1=> [
                0 => 'a',
                1 => 'b',
            ]
        ];

        $arr2 = $arr1;


        ArrayMerge::init(self::$sumAction->onLevel(1))->merge($arr1,$arr2);

        $expected = [
            0 => 2,
            1 => [
                0 => 'a',
                1 => 'b',
            ] 
        ];
        $this->assertEquals($expected, $arr1);
    }

    public function test_mixed_values_merge_with_actions() 
    {
        $initialValue = 20;
        $arr1 = SampleFactory::getArrayOfMixed();
        $arr2 = SampleFactory::getArrayOfMixed('k_', $initialValue);


        $action = new Action(function($left, $right){
            $is_string = is_string($left) && is_string($right);
            return $is_string ? $left.$right : $right;
        });

        $base = $initialValue;
        /** @var array is exactly like $arr2 only with merged values for string leaves */
        $result = [
            'k_1_1' => $base + 1,
            'k_1_2' => [
                'k_2_1' => $base + 2,
                'k_2_2' => 'valuevalue',
                'k_2_3' => [
                    'k_3_1' => $base + 3,
                    'k_3_2' => 'valuevalue',
                    'k_3_3' => $base + 4,
                ],
            ],
            'k_1_3' => 'valuevalue',
        ];

        ArrayMerge::init($action)->merge($arr1, $arr2);

        $this->assertEquals($result, $arr1);
    }
}