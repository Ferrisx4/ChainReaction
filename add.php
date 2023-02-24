<?php

include 'util.php';

// Load the words
$words = load();
// Loop through user inputs, appending new words.
$line ='';

// Get the list of childless words for suggestions.
$childless = find_childless($words);

$word_pairs = count_word_pairs($words);
$line = readline('Enter a new word pair, space separated: ');

while($line != 'end') {
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
    elseif (substr_count($wordsToAdd[0],'?')) {
        $wordsToAdd[0] = rtrim($wordsToAdd[0],"?");
        $children = get_children($words,$wordsToAdd[0]);
        if ($children) {
            echo "Existing " . $wordsToAdd[0] . " words: " . print_children_nicely($children) . "\n";
        }
        else {
            echo "No \"" . $wordsToAdd[0] . "\" words yet, try adding some!\n";
        }
    }

    $line = readline('Enter a new word pair, space separated: ');
}


// Save the words.
save($words);

$new_pairs = count_word_pairs($words) - $word_pairs;

echo $new_pairs . " new pairs added.\n";