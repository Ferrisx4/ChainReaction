<?php

if (count($argv) == 3) {
    echo "Good\n";
}
else {
    echo "You didn't enter the right number of arguments\n";
    echo "You need to enter two words.\n";
    die();
}

// Load the big ol' word list.
// todo: load in from a csv, first column is key
$words = [];
$handle = fopen("words.txt", "r") or die("Unable to open file for reading.\n");
if ($handle) {
    while (($line = fgetcsv($handle)) !== false) {
        // process the line read.
        $key = array_shift($line);
        $words[$key] = $line;
    }

    fclose($handle);
}


// Add the new word and save the file.
if (array_key_exists($argv[1], $words)) {
    echo "Existing word!\n";
    array_push( $words[$argv[1]] , $argv[2] );
}
else {
    echo "New word!\n";
    $words[$argv[1]] = [$argv[2]];
}
$words[$argv[1]] = array_unique($words[$argv[1]]);

$handle = fopen("words.txt", "w") or die("Unable to open file for writing.\n");
foreach($words as $primary => $secondary) {
    array_unshift($secondary,$primary);
    fputcsv($handle, $secondary);
}
fclose($handle);