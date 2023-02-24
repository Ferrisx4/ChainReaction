<?php

// Set the file location
define('FILE', 'words.txt');

/**
 * Adds a new key if it does not exist, and a new word
 * that belongs in a chain to that key, again, if it does
 * not exist. If the key already exists, just add the new
 * word
 * 
 * @param string $parent
 *  the key, the "parent" word to be added or added to
 * @param string $child
 *  the "child" word to be added to the "parent"'s list.
 * @param array &$words
 *  the word list
 */
function add($parent, $child, &$words) {
    if ($parent == $child) {
        echo "No infinite loops! Nice try!\n";
    }
    // If the parent already exists
    else if (array_key_exists($parent, $words)) {
        // Check if the child exists
        if(array_search($child,$words[$parent]) === FALSE) {
            
            // Add the new word after suggesting other words.
            array_push( $words[$parent] , $child );
        }
        // Suggest other words
        $suggest_string = "Existing " . $parent . " words: ";
        $suggest_string .= print_children_nicely($words[$parent]);
        echo $suggest_string . "\n";
    }
    else {
        echo "New root word!\n";
        $words[$parent] = [$child];
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
    foreach($words as $parent => $child) {
        array_unshift($child,$parent);
        fputcsv($handle, $child);
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

/**
 * Get all words in list.
 * 
 * @param array &$words
 *  The regular list of words and their children.
 * @return array
 *  The entire list of words, including children. The words are the key,
 *  as an added bonus, the number of times they appear is the value.
 */
function get_all_words(&$words) {
    $all_words = [];
    foreach ($words as $parent => $children) {
        if (array_key_exists($parent, $all_words)) {
            $all_words[$parent] += 1;
        }
        else {
            $all_words[$parent] = 1;
        }
        foreach ($children as $child) {
            if (array_key_exists($child, $all_words)) {
                $all_words[$child] += 1;
            }
            else {
                $all_words[$child] = 1;
            }
        }
    }
    array_multisort($all_words);
    return $all_words;
}

/**
 * Remove duplicate children, just in case.
 *
 * @param array &$words
 *  The regular list of words and their children.
 * 
 * @return string
 *  The number of duplicates removed.
 */
function dedup_children(&$words) {
    $removed = 0;
    foreach ($words as $key => $parent) {
        $before = count($parent);
        $words[$key] = array_unique($parent, SORT_STRING);
        $removed += $before - count($words[$key]);
    }
    save($words);
    
    return $removed;
}

/**
 * Count all word pairs.
 * 
 * @param array &$words
 *  The regular list of words and their children.
 * 
 * @return int
 *  The number of word pairs.
 */
function count_word_pairs(&$words) {
    $count = 0;

    foreach ($words as $word) {
        $count += (count($word));
    }

    return $count;
}

/**
 * Count distinct words
 * 
 * @param array &$words
 *  The regular list of words and their children.
 * 
 * @return int
 *  The number of unique words.
 */
function count_words(&$words) {
    $all = get_all_words($words);

    return count($all);
}

/**
 * Get children of a single parent.
 * 
 * @param array &$words
 *  The regular list of words and their children.
 * @param string $parent
 *  The parent word for whose kids we are searching.
 * 
 * @return array
 *  An array of strings representing the children of that word, or FALSE
 *  if there are no children.
 */
function get_children(&$words,$parent) {
    if (array_key_exists($parent, $words)) {
        return $words[$parent];
    }
    else
        return FALSE;
}

/**
 * Print children nicely.
 * 
 * @param array $children
 *  An array of strings.
 * 
 * @return string
 *  A nice string of children, separated by a comma and a space.
 *  FALSE on error.
 */
function print_children_nicely($children) {
    $results = '';

    if (count($children) == 0) {
        echo "Error: No children\n";
        return FALSE;
    }
    foreach ($children as $child) {
        $results .= $child . ", ";
    }
    $results = rtrim($results,', ');
    
    return $results;
}