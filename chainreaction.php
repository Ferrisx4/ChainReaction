<?php

include 'util.php';

if (count($argv) != 4) {
    echo "Please enter a starting word, an ending word, and the number of words total\n";
    die();
}

/**
 * Call this function with 3 arguments: first word, last word, and chain length (inclusive).
 */

// Get the words.
$words = load();
$chain = [];

$start = $argv[1];
$end = $argv[2];

// Initialize the stack with the Start word.
if (array_key_exists($start,$words)) {
    array_push($ws,$start);
}
else {
    echo "Word not in list\n";
    die();
}

// Main loop. Check each iteration that we don't use the same word twice.
// Traverse as deep as the chain length argument - 1
// 
function chain_dive(&$words, &$chain, $start, $end, $max_depth, $current_depth) {
    if ($max_depth == $current_depth && $chain[count($chain)-1] == $end) {
        echo "breaking\n";
        return true;
    }
    echo $current_depth . "\n";
    $current_depth += 1;
    foreach ($)
    chain_dive($start, $end, $max_depth, $current_depth);
}

array_push($chain,$start);
chain_dive($words,$chain,'one','last',15,1);