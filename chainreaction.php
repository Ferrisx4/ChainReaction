<?php

include 'util.php';

if (count($argv) != 2) {
    die();
}

// Get the words.
$words = load();
$ws = [];

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

while ()


