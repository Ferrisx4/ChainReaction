<?php

include 'util.php';

// Load the words
$words = load();
// Loop through user inputs, appending new words.
$line ='';

// Get the list of childless words for suggestions.
$childless = find_childless($words);

while($line != 'end') {
    $line = readline('Word pair (space): ');
    $wordsToAdd = explode(' ', $line);
    
    // Suggest a word
    if($line == 'suggest') {
        if (count($childless) == 0) { echo "No childless words to suggest!\n"; } else {
            $rand_word = rand(0,count($childless)-1);
            echo "Suggestion: " . $childless[$rand_word] . "\n";
        }
    }
    if (count($wordsToAdd) > 1) {
        add($wordsToAdd[0],$wordsToAdd[1],$words);
    }
}


// Save the words.
save($words);