<?php

include 'util.php';

$words = load();

echo "\nRemoving duplicates...";
dedup_children($words);