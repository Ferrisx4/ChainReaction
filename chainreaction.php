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
$chain_length = $argv[3];

// Initialize the stack with the Start word.
if (array_key_exists($start,$words)) {
    array_push($chain,$start);
}
else {
    echo "Word not in list\n";
    die();
}

$chain_found = FALSE;
$final_chain = [];
// Main loop. Check each iteration that we don't use the same word twice.
// Traverse as deep as the chain length argument - 1
// 
function chain_dive(&$words, &$chain, $next, $end, $chain_length, &$depth) {
    global $chain_found;
    global $final_chain;

    echo "Chain at entrance to dive: \n";
    print_r($chain);
    echo "at depth: " . $depth . "\n";
    echo "\n";

    if ($chain_found) {
        return $chain;
    }
    // Case: Valid chain found!
    elseif ($depth == $chain_length && $chain[count($chain)-1] == $end) {
        echo "breaking\n";
        $chain_found = TRUE;
        $final_chain = $chain;
        return 'success';
    }
    // Case: Chain is not at max depth yet
    // Action: Recurse into $next's children
    elseif ($depth < $chain_length) {
        echo "not at chain_length yet! (depth = " . $depth . ")\n";
        //sleep(1);
        if (array_key_exists($next,$words)) {
            $depth += 1;
            foreach ($words[$next] as $next_child) {
                if (!$chain_found) {  
                echo "testing " . $next . " > " . $next_child . "\n";
                //print_r($chain);
                echo "\n";
                // if $next is already in chain, do nothing
                if (in_array($next_child, $chain) && $depth != 1) {
                    echo $next_child . " is already in the chain:\n";
                    //print_r($chain);
                    return 'already_in_chain';
                }
                // if $next is childless, do nothing
    
    
                array_push($chain, $next_child);
                    $action = chain_dive($words,$chain,$next_child,$end,$chain_length,$depth);
                    if ($action == 'reached_chain_length') {
                        echo "reached_chain_length\n";
                        $depth -= 1;
                        array_pop($chain);
                    }
                    elseif ($action == 'no_child') {
                        echo $next_child . " has no child, ending traversal\n";
                        $depth -= 1;
                        $popped = array_pop($chain);
                        echo "popped " . $popped . " off\n";
                    }
                    elseif ($action == 'success')
                    {
                        echo "Action = success\n";
                        return 'success';
                    }
                    else {
                        // At this point lets assume this word didn't pan out and pop it, but don't decrement depth.
                        echo "Unhandled action";
                        echo "\tCurrent chain: \n";
                        print_r($chain);
                        echo "\tNext word: " . $next_child . "\n";
                        echo "\tChain length: " . $chain_length . "\n";
                        echo "\tDepth: " . $depth . "\n\n";
                        array_pop($chain);
                    }
                }
            }
        }
        else {
            echo $next . " was not in the words list! (depth: " . $depth . ")\n";
            return 'no_child';
        }
    }
    // Case: Reached designated chain length but the chain is not solved
    // Action: decrement depth
    //         pop the end off the array
    elseif ($depth == $chain_length) {
        echo "\nChain is at depth, but not solved\n";
        print_r($chain);
        echo "Depth: " . $depth . "\n";
        echo "\n";
        return 'reached_chain_length';
    }
    // Case: Reached end of depth-first traversal while less depth < chain_length
    /*elseif ($depth < $chain_length && !in_array($next, $words)) {
        //echo "Found word with no children, depth less than desired length\n";
        return 'no_child';
    }*/
    // Catch-all for other conditions
    else {
        echo "\nUnhandled condition, printing...\n";
        echo "\tCurrent chain: \n";
        print_r($chain);
        echo "\tNext word: " . $next . "\n";
        echo "\tChain length: " . $chain_length . "\n";
        echo "\tDepth: " . $depth . "\n";
        echo "END OF UNHANDLED CONDITION\n\n";
    }
}

$depth = 1;
$chain_found = chain_dive($words,$chain,$start,$end,$chain_length,$depth);
echo "\nFinal: \n";
print_r($final_chain);