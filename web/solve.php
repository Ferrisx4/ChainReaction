<?php

/**
 * The main API function for use on the web page.
 * Just the solver, no adding.
 */

//include 'util.php';

/**
 * A function to test a given chain. Can contain blanks in
 * the form of NULLs.
 * The blanks can come at any spot, the entire array is checked
 * against candidate chains. 
 * 
 * @paray array $chain
 *   An array containing words or NULLS of a valid chain.
 *   Blanks are handled by nulls.
 */
function solve($chain) {

    $words = load();

    
}

/**
 * Compares two arrays. The first array is the candidate chain
 * from the solve() function. The second array is the given chain
 * from the user. This may include blanks in the form of NULLs.
 * The two arrays are compared, ignoring any NULLs in the second
 * array.
 */
function compare_to_results($candidate, $given) {
    foreach ($candidate as $index => $word) {
        // If given has null at this index, just skip.
        if ($given[$index] !== NULL) {
            echo "testing if " . $word . " is equal to " . $given[$index] . "\n";
            if ($word != $given[$index]) {
                return FALSE;
            }
        }
    }
    return TRUE;
}

function testl() {
    return "it works";
}