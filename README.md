# Array Merge with applying a calback Simple Merge
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
TODO: show a second example
```

# Array Merge Merge with Actions

Recursive merge, same principle as the simple merge, but with more extensive conditions for applying the callback <Action>

## How it works
It will try and merge 2 similar structured arrays, structure should be the same, if any key from the second array doesn't exist in the first array it will be added. 

For existing keys it will apply the **Action** provided.

An **Action** has the following properties 
'keys'  - that the Action should be applied to
'level' - depth on which the Action is valid (other levels won't be touched) 

Level starts from 1;
Level = 0 - Action will be applied on all the nodes or the keys specified on all levels.

### Example
```
$left = $your_structure;
$right = $another_structure;

$action = new Action(function($leftValue, $rightValue){
    return $leftValue + rightValue;
}, $level = 1, $keys = ['key1', 'key2']);

$instance = new ArrayMerge($action);
$instance->merge($left, $right);

// alternative instantiation
ArrayMerge::init($action)->merge($left, $right);

// $left values on level 1 (first depth level) are going to be the sum of the left and right values of the same keys;

```

## API 
### ArrayMerge
**static init(Action $action)** - creates an instance, expects an Action
**withAction(Action $action)** - adds an action to the instance

### Action
**default level = 0 and all keys**
**onLevel(int $level)** - sets the depth of the array to which the Action will be applied
**onKeys(array $keys)** - sets the keys for the Action to run on
**setKey($key)** - adds a key to the actions keys array


**inScope($key, int $level)** - checks if Action needs to be applied (if in scope)
**setMethod(callable $func)** - sets the callback to run if in scope (onnly one at a time)
**runMethod($left, $right)** - runs the set callback against 2 values







