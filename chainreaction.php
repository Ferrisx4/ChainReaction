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
    array_push($chain,$start);
}
else {
    echo "Word not in list\n";
    die();
}

// Main loop. Check each iteration that we don't use the same word twice.
// Traverse as deep as the chain length argument - 1
// 
function chain_dive(&$words, &$chain, $start, $end, $max_depth) {
    echo "Testing " . $start . "\n";
    array_push($chain, $start);

    
    // Case: Valid chain
    if ($max_depth == count($chain) && $chain[count($chain)-1] == $end) {
      echo "breaking\n";
      return true;
    }
    // Case: Reached max depth (chain length) without finding $end
    if ($max_depth == count($chain) && $chain[count($chain)-1] != $end) {
        // The most recently added word does not contribute, pop it off.
        echo $start . " aint it\n";
        array_pop($chain);
        return false;
    }
    // Case: Not at max depth, current test doesn't have children (so not valid chain)
    if (!array_key_exists($start, $words)) {
        echo $start . " has no children, rejecting\n";
        array_pop($chain);
        return false;
    }
    // Case: we haven't reached the max depth yet, continue
    echo "Depth: " . count($chain) . "\n";
    foreach ($words[$start] as $child) {
        chain_dive($words, $chain, $child, $end, $max_depth);
    }
}

chain_dive($words,$chain,$argv[1],$argv[2],$argv[3]);

print_r($chain);