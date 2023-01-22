<?php

include 'util.php';

// Load the words
$words = load();
// Loop through user inputs, appending new words.
$line ='';

// Get the list of childless words for suggestions.
$childless = find_childless($words);

while($line != 'end') {
    $line = readline('Enter a new word pair, space separated: ');
    $wordsToAdd = explode(' ', $line);
    
    // Suggest a word
    if($line == 'suggest') {
        if (count($childless) == 0) { echo "No childless words to suggest!\n"; } else {
            $rand_word = array_rand($childless);
            echo "Suggestion: " . $childless[$rand_word] . "\n";
        }
    }
    if (count($wordsToAdd) > 1) {
        add($wordsToAdd[0],$wordsToAdd[1],$words);
    }
}


// Save the words.
save($words);