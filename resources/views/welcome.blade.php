<?php
function create($elements, $config) {
    $result = [];
    $position = 0;
    $elementCount = count($elements);

    // Step 1: Process elements based on config
    foreach ($config as $item) {
        if ($item === 'block' && $position < $elementCount) {
            $result[] = $elements[$position]; // Insert element at position
            $position++;
        } elseif ($item === 'add') {
            $result[] = 'add'; // Insert 'add' where needed
        }
    }

    // Step 2: Handle remaining elements properly
    $remaining = array_slice($elements, $position);
    if (!empty($remaining)) {
        $inserted = 0;
        foreach ($remaining as $elem) {
            if ($inserted % 3 === 0 && $inserted !== 0) {
                $result[] = 'add'; // Add "add" after every 3 remaining elements
            }
            $result[] = $elem;
            $inserted++;
        }
    }

    // Step 3: Ensure the last element is "add" when config is greater than elements
    if (empty($result) || end($result) !== 'add') {
        $result[] = 'add';
    }

    return $result;
}

// Example usage
$elements = ['p', 'div', 'img',];
$config = ['add', 'block', 'add', 'block', 'block', 'add', 'block', 'add', 'block',];

$output = create($elements, $config);
print_r($output);
?>
