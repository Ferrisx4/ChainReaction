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

$dives = 0;

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
    global $dives;

    $dives += 1;

    $debug = FALSE;

    if ($debug) {
        echo "Chain at entrance to dive: \n";
        print_r($chain);
        echo "at depth: " . $depth . "\n";
        echo "\n";

        // Debug condition only
        if (count($chain) != $depth) {
            echo "\nDEPTH MISMATCH\n\n";
        }
    }

    if ($chain_found) {
        //return 'chain_found';
    }
    // Case: Valid chain found!
    if ($depth == $chain_length_target && $chain[count($chain)-1] == $end) {
        if ($debug) {echo "breaking\n";}
        $chain_found = TRUE;
        //$final_chain = $chain;
        array_push($final_chain, $chain);
        return 'chain_found';
    }
    // Case word was added that was already in the chain
    elseif(repeatCheck($chain)) {
        return 'already_in_chain';
    }
    // Case: Chain is not at max depth yet
    // Action: Recurse into $next's children
    elseif ($depth < $chain_length_target) {
        if ($debug) {echo "not at chain_length_target yet! (depth = " . $depth . ")\n";}
        //sleep(1);
        if (array_key_exists($next,$words)) {
            foreach ($words[$next] as $next_child) {
                $depth += 1;
                    if (TRUE) { 
                    if ($debug) {
                        echo "testing " . $next . " > " . $next_child . "\n";
                        print_r($chain) . "\n";
                    } 
                    // if $next is already in chain, do nothing
                    /*if (in_array($next_child, $chain) && $depth != 1) {
                        if ($debug) {echo $next_child . " is already in the chain:\n";}
                        //print_r($chain);
                        $depth -= 1;
                        return 'already_in_chain';
                    }*/
                    // if $next is childless, do nothing
        
        
                    array_push($chain, $next_child);
                        // MAIN RECURSIVE CALL
                        $action = chain_dive($next_child);
                        // MAIN RECURSIVE CALL
                        if ($action == 'reached_chain_length_target') {
                            if ($debug) {echo "reached_chain_length_target\n";}
                            $depth -= 1;
                            array_pop($chain);
                        }
                        elseif ($action == 'no_child') {
                            if ($debug) {echo $next_child . " has no child, ending traversal\n";}
                            $depth -= 1;
                            $popped = array_pop($chain);
                            if ($debug) {echo "popped " . $popped . " off\n";}
                        }
                        elseif ($action == 'chain_found')
                        {
                            if ($debug) {echo "Action = success\n";}
                            array_pop($chain);
                            $depth -= 1;
                            //return 'chain_found';
                        }
                        elseif ($action == 'aleady_in_chain') {
                            echo "action = already_in_chain\n";
                            array_pop($chain);
                            $depth -= 1;
                        }
                        else {
                            // At this point lets assume this word didn't pan out and pop it, but don't decrement depth.
                            if ($debug) {
                                echo "Unhandled action";
                                echo "\tCurrent chain: \n";
                                print_r($chain);
                                echo "\tNext word: " . $next_child . "\n";
                                echo "\tChain length target: " . $chain_length_target . "\n";
                                echo "\tDepth: " . $depth . "\n\n";
                                echo "\t Action: " . $action . "\n\n";
                            }
                            array_pop($chain);
                            $depth -= 1;
                        }
                    }
            }
        }
        else {
            if ($debug) {echo $next . " was not in the words list! (depth: " . $depth . ")\n";}
            return 'no_child';
        }
    }
    // Case: Reached designated chain length but the chain is not solved
    // Action: decrement depth
    //         pop the end off the array
    elseif ($depth == $chain_length_target) {
        if ($debug) {
            echo "\nChain is at depth, but not solved\n";
            print_r($chain);
            echo "Depth: " . $depth . "\n";
            echo "\n";
        }
        return 'reached_chain_length_target';
    }
    // Case: Reached end of depth-first traversal while less depth < chain_length_target
    /*elseif ($depth < $chain_length_target && !in_array($next, $words)) {
        //echo "Found word with no children, depth less than desired length\n";
        return 'no_child';
    }*/
    // Catch-all for other conditions
    else {
        if ($debug) {
            echo "\nUnhandled condition, printing...\n";
            echo "\tCurrent chain: \n";
            print_r($chain);
            echo "\tNext word: " . $next . "\n";
            echo "\tChain length: " . $chain_length_target . "\n";
            echo "\tDepth: " . $depth . "\n";
            echo "END OF UNHANDLED CONDITION\n\n";
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
    if ($count[$last] > 1) {
        return TRUE;
    }
    else {
        return FALSE;
    }
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

echo "Dives: " . $dives . "\n";