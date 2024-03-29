<?php

include 'util.php';

// Load the words
$words = load();
// Loop through user inputs, appending new words.
$line ='';

$childless = NULL;

$word_pairs = count_word_pairs($words);
$line = readline('Enter a new word pair, space separated: ');

while($line != 'end') {
    $wordsToAdd = explode(' ', $line);
    
    // Suggest a word
    if($line == 'suggest') {
        if (!$childless) {
            $childless = find_childless($words);
        }
        if (count($childless) == 0) { echo "No childless words to suggest!\n"; } else {
            $rand_word = array_rand($childless);
            echo "Suggestion: " . $childless[$rand_word] . "\n";
        }
    }
    elseif (count($wordsToAdd) > 1) {
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
    elseif (count($wordsToAdd) == 1) {
        echo "You forgot your second word! Try it again...\n";
    }

    $line = readline('Enter a new word pair, space separated: ');
}


// Save the words.
save($words);

$new_pairs = count_word_pairs($words) - $word_pairs;

echo $new_pairs . " new pair" . (($new_pairs == 1) ? "" : "s" ) . " added.\n";

echo count($words) . " parent words.\n";