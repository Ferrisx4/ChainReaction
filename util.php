<?php

// Set the file location
define('FILE', 'words.txt');

/**
 * Adds a new key if it does not exist, and a new word
 * that belongs in a chain to that key, again, if it does
 * not exist. If the key already exists, just add the new
 * word
 * 
 * @param string $primary
 *  the key, the "parent" word to be added or added to
 * @param string $secondary
 *  the "child" word to be added to the "parent"'s list.
 * @param array &$words
 *  the word list
 */
function add($primary, $secondary, &$words) {
    if ($primary == $secondary) {
        echo "No infinite loops! Nice try!\n";
    }
    else if (array_key_exists($primary, $words)) {
        array_push( $words[$primary] , $secondary );
    }
    else {
        $words[$primary] = [$secondary];
    }
}


/**
 * Load the word list from the file.
 */
function load() {
    $words = [];
    $handle = fopen(FILE, "r") or die("Unable to open file for reading.\n");
    if ($handle) {
        while (($line = fgetcsv($handle)) !== false) {
            // process the line read.
            $key = array_shift($line);
            $words[$key] = $line;
        }

        fclose($handle);
    }
    echo "Loaded word list.\n";

    return $words;
}


/**
 * Save the word list to the file.
 * 
 * @param array $words
 *  The word list to save.
 */
function save(&$words) {
    $handle = fopen(FILE, "w") or die("Unable to open file for writing.\n");
    foreach($words as $primary => $secondary) {
        array_unshift($secondary,$primary);
        fputcsv($handle, $secondary);
    }
    fclose($handle);
}

/**
 * Find words that don't have children.
 * @param array $words
 *  word list
 * @param boolean $print
 *  do I print the words as well as return them?
 */
function find_childless(&$words,$print = FALSE) {
    $childless_words = [];
    foreach ($words as $parent) {
        foreach ($parent as $child) {
            if (!array_key_exists($child,$words)) {
                array_push($childless_words,$child);
            }
            
        }
    }
    if ($print) {
        foreach($childless_words as $nk) {
            echo $nk . "\n";
        }
    }

    return($childless_words);
}