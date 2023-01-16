<?php

include 'util.php';

// Load the words
$words = load();
print_r($words);
// Loop through user inputs, appending new words.
$line ='';
while($line != 'end') {
    $line = readline('Word pair (space): ');
    $wordsToAdd = explode(' ', $line);
    if (count($wordsToAdd) > 1) {
        add($wordsToAdd[0],$wordsToAdd[1],$words);
    }
}


// Save the words.
save($words);