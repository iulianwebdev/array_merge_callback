<?php 
namespace IuDev;

use IuDev\ArrayMerge\ArrayMergeCallback;

require_once('vendor/autoload.php');

$left = [
    'k_1_1' => 'value',
    'k_2_1' => [
        'k_1_2' => 'value',
        'k_2_2' => [
            'k_1_3' => 'value',
            'k_2_3' => 'value',
            'k_2_3' => 'value',
        ]
    ]
];
$right = [
    'k_1_1' => 'value2',
    'k_2_1' => [
        'k_1_2' => 'value2',
        'k_2_2' => [
            'k_1_3' => 'value2',
            'k_2_3' => 'value2',
            'k_2_3' => 'value2',
        ]
    ]
];

function concat(string $l, string $r): string {
    return $l.$r;
}

ArrayMergeCallback::merge($left, $right, [
    'k_1_1' => function($l, $r){
        return concat($l, $r);
    }
]);


var_dump($left);

