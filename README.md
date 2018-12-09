# Array Merge with applying a calback
Recursive merge function that applies a callback on the leafs, non-array types, based on an array with keys=>funcName
```
$callbackMap = ['key1' => 'functionName1', 'key2'=>'functionName2'];
```

## Cases to use
When you have structures that you want to transform diferently based on keys, (no level tracking, all occurences).

### Example1
```
require_once('ArrayMergeCallback.php');
$left = [
    'key1' => [
        'key1_1' => 'leaf1'
        ],
    'key2' => 'leaf2'
];

$right = [
    'key1' => [
        'key1_1' => 'leaf1'
        ],
    'key2' => 'leaf2'
];

function concat($str1, $str2){
    return "{$str1}_{$str2}";
}

ArrayMergeCallback::merge($arr1, $arr2, [
    'key1'=> 'concat',
]);


```

### Example2
```
TODO: finish the README
```
