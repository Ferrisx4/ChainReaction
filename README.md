# Chain Reaction
Based on the Game Show Network show of the same name.
It is designed to take two words and a number of empty spaces and fill in the blanks, as is the challenge on the game.

## Design
This program consists of several parts:
 - Word Pair ingestion from CSV or something. Currently, input is manual (add.php).
 - Data structure to store this data for quick searching.
 - Alrgorithm to cycle through the data to find an appropriate chain.

### Word Pair Ingestion
 - take a list of pairs of words that work as chains and feed them into the data structure, outlined below.

### Data Structure
The data structure that makes the most sense for this project and its design goals is an associate array. In PHP, these are
implemented with hash tables which should be fast enough. Each
"parent" word is the key in the main words array, and each value is an array itself of "child" words. For the most part, there will not be many children per word.
The downside of this approach is that the memory required to store the word list may expand greatly as each "child" word will be stored as a string, and many words will be repeated throughout the words list. For instance:
```
remote,worker
diligent,worker
case,worker
hard,worker
```

### Solving algorithm.
The algorithm will be supplied with a starting word, the ending word, the main words array, and the chain length. It will iterate through the words array in a depth-first fashion. It will end either when it has found a word chain that satisfies the starting and ending word within the specified chain length, or it will report that it could not find a valid chain.

## To Use

### Word Ingestion
Run add.php with no arguments. You will be prompted to supply word pairs. You will repeat the parent word for each entry, for example:
```
water,cooler
water,fountain
water,feature
water,fall
water,pill
water,gun
```
Typing `suggest` will find a child word that has no children of its own and suggest it for you. This makes the word list more robust with fewer "dead-ends" for the algorithm to stop processing through.

Typing a single word followed by a question mark will return a list of children words that already exist.
For example:
```
string?
Other string words: instrument, cheese, quartet, theory
```

Typing `end` will end input mode and save the new words into the file.

The add functionality is robust in that it will not allow for repeated parent,child pairs.
If a word list is manually input, a utility function is available to remove duplicates. More housekeeping functionality may be added in the future.

### Puzzle Solving (Work-in-progress)
This is still being worked on. For now, please add to the word list.