<?php

include 'util.php';

if (count($argv) != 4) {
    echo "Please enter a starting word, an ending word, and the number of words total\n";
    die();
}

/**
 * Call this function with 3 arguments: first word, last word, and chain length (inclusive).
 */

// Get the words 'database'.
$words = load();

// Prep the variables to be used globally within the chain_dive() function.
$chain = [];
$chain_found = FALSE;
$final_chain = [];
$depth = 1;

// Get the arguments (start of chain, end of chain, chain length).
$start = $argv[1];
$end = $argv[2];
$chain_length_target = $argv[3];

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
function chain_dive($next) {
    global $chain;
    global $chain_found;
    global $final_chain;
    global $depth;
    global $chain_length_target;
    global $end;
    global $words;

    // Case word was added that was already in the chain
    if(repeatCheck($chain)) {
        return;
    }
    // Check if the "end" word, as given by the user, exists in the chain before the end of the chain. Issue #1
    elseif ($depth < $chain_length_target && $chain[count($chain)-1] == $end) {
        return;
    }
    // Case: Valid chain found!
    elseif ($depth == $chain_length_target && $chain[count($chain)-1] == $end) {
        $chain_found = TRUE;
        array_push($final_chain, $chain);
        //return 'chain_found';
    }    
    // Case: Chain is not at max depth yet
    // Action: Recurse into $next's children
    elseif ($depth < $chain_length_target) {
        //sleep(1);
        if (array_key_exists($next,$words)) {
            foreach ($words[$next] as $next_child) {
                $depth += 1;      
    
                array_push($chain, $next_child);
                // MAIN RECURSIVE CALL
                chain_dive($next_child);
                $depth -= 1;
                array_pop($chain);                    
            }
        }
        else {
            return;
        }
    }
}

/**
 * Checks current chain for repeats. Returns TRUE if there are repeats,
 * FALSE if not.
 */
function repeatCheck($chain) {
    $count = array_count_values($chain);
    $last = array_pop($chain);
    return $count[$last] > 1;
}

$depth = 1;
$chain_found = chain_dive($start);

if (count($final_chain) > 0) {
    $chain_no = 1;
    foreach ($final_chain as $found_chain) {
        echo "\nChain #" . $chain_no . ":\n";
        foreach ($found_chain as $chainword) {
            echo "\t$chainword\n";
        }
        echo "\n";
        $chain_no += 1;
    }
    echo "\n";
}
else {
    echo "No chains found!\n";
}