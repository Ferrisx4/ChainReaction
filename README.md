# Chain Reaction
Based on the [Game Show Network show](https://www.gameshownetwork.com/chain-reaction "Link to Game Show Network page for Chain Reaction") of the same name.
It is designed to take two words and a number of empty spaces and fill in the blanks, as is the challenge on the game.

## Design
This program consists of several parts:
 - Word Pair ingestion script which stores the data in a CSV file. Currently, input is manual (add.php).
 - Data structure to store this data for quick searching.
 - Alrgorithm to cycle through the data to find an appropriate chain.

### Word Pair Ingestion
 - take a list of pairs of words that work as chains and feed them into the data structure, outlined below.

### Data Structure
The data structure that makes the most sense for this project and its design goals is an associative array. In PHP, these are
implemented with hash tables which should be fast enough. Each
"parent" word is the key in the main words array, and each value is an array itself of "child" words. For the most part, there will not be many children per parent, but children can be their own parents.
The downside of this approach is that the memory required to store the word list may expand greatly as each "child" word will be stored as a string, and many words will be repeated throughout the words list. For instance:
```
remote,worker
diligent,worker
case,worker
hard,worker
```

### Solving algorithm.
The algorithm will be supplied with a starting word, the ending word, the main words array, and the chain length. It will iterate through the words array in a depth-first fashion. It will end either when it has found all word chains that satisfy the starting and ending word within the specified chain length, or it will report that it could not find a valid chain.

## To Use
The scripts have 3 main functions:
 1. Word Ingestion (`add.php`)
    - Add new word pairs to the set of word pairs.
 2. Chain Solving (`chainreaction.php`)
    - Solves a chain, if possible, when given a starting word, an ending word, and a target chain length.
    - By default, will return all valid chains.
 3. Chain Creation (`chaincreate.php`)
    - **Work in progress**
    - Can be used to generate puzzles randomly when given a target chain length.

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

The *add* functionality is robust in that it will not allow for repeated parent,child pairs.
If a word list is manually input, a utility function is available to remove duplicates. More housekeeping functionality may be added in the future.

### Puzzle Solving
The `chainreaction.php` script will use a depth-first recursive technique to search through the word set to find suitable word chains.

#### Arguments
The `chainreaction.php` script takes three arguments:
 1. starting word
 2. ending word
 3. length of word (inclusive)

#### Example

Example 1
```shell
$ php chainreaction.php tipping goat 6
Chain #1:
        tipping
        point
        taken
        back
        yard
        goat


Chain #2:
        tipping
        point
        blank
        space
        mountain
        goat
```

Example 2
```shell
Chain #1:
	dog
	leash
	law
	school
	night
	club
	house


Chain #2:
	dog
	leash
	law
	school
	night
	light
	house

...

Chain #187:
        dog
        paddle
        boat
        ride
        high
        school
        house
```

#### Planned functionality - Solving
 - [x] Multiple Chain Finding.
 - [ ] Toggleable chain finding (for large chain lengths, it can be quite slow to find all chains).

### Puzzle Creation (work-in-progress)
The program will be able generate a puzzle of a specified length with either a specified starting word or a word chosen at random from the database.

---

Special thanks to the Game Show Network for creating the game and also for many of the word pairs that exist in the database. Also thanks to my aunt who will write down chains for me to add when I miss part of an episode.

