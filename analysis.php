<?php

include 'util.php';

$words = load();

// Begin Analysis Output

echo "\nAnalysis Begin\n------------\n";

echo "Parsed file: " . FILE . "\n";

echo "Total number of words: \t\t\t" . count($words) . "\n";

echo "Number of words without children:\t" . count(find_childless($words, FALSE)) . "\n";

echo "Total word pairs:\t\t\t" . count_word_pairs($words) . "\n";

echo "Total number of unique words:\t\t" . count_words($words) . "\n";

$most_children = get_most_children($words);
echo "Word(s) with the most children:\t\t" . print_children_nicely($most_children['words']) . " (" . $most_children['size'] . ")\n";

echo "------------\nAnalysis End\n\n";