<?php

/**
 * Generates a puzzle of given length, and possibly starting
 * at a given word (optional).
 */
include 'util.php';

// Get the words database.
$words = load();

$length = $argv[1];

// Get the start, either from the argument or randomly from
// word list.
$keys = array_keys($words);
if (count($argv) == 3) {
    if (in_array($argv[2], $keys)) {
        $start = $argv[2];
    }
    else {
        echo "No such word, silly goose!\n";
    }
}
else {
    //echo "Random: " . count($words) . "\n";
    echo "No starting word specified, using random word instead: ";
    $start = $keys[rand(0, count($words))];
    echo $start . "\n";
}
$chain = [$start];
print_r($chain);
$index = 0;
if (isset($start)) {
    while ($length > 0) {
        // Get the next set of words.
        $next_parent = $words[$chain[$index]];

        // Shuffle the array so that it's "random" at this scope.
        shuffle($next_parent);
        print_r($next_parent);

        // Run through it.
        foreach($next_parent as $child) {

        }
        
        $length -= 1;
        $index += 1;
    }
}
else {
    echo "Couldn't $start for some reason. Dying...\n";
}

/**
 * @param string $word
 *  thingy
 */
function test_word($word) {

}

?>