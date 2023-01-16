<?php

/**
 * Adds a new key if it does not exist, and a new word
 * that belongs in a chain to that key, again, if it does
 * not exist. If the key already exists, just add the new
 * word
 * 
 * @input $primary the key
 * @input $secondary the word to add to the key
 * @input &$words the word list
 */
function add($primary, $secondary, &$words) {
    if (array_key_exists($primary, $words)) {
        array_push( $words[$primary] , $secondary );
    }
    else {
        $words[$primary] = [$secondary];
    }
    $words[$primary] = array_unique($words[$primary]);
}


/**
 * Load the word list from the file.
 */
function load() {
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

    return $words;
}


/**
 * Save the word list to the file.
 */
function save(&$words) {
    $handle = fopen("words.txt", "w") or die("Unable to open file for writing.\n");
    foreach($words as $primary => $secondary) {
        array_unshift($secondary,$primary);
        fputcsv($handle, $secondary);
    }
    fclose($handle);
}