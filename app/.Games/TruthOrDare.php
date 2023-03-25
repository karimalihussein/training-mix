<?php

$truthQuestions = [
    "Have you ever lied to your best friend?",
    "What's the worst gift you've ever received?",
    "Have you ever stolen something?",
    "What's your biggest fear?",
    "What's the most embarrassing thing you've ever done?",
];

$dareTasks = [
    "Do an impression of your favorite celebrity.",
    "Sing a song in front of everyone.",
    "Make a prank call to a friend.",
    "Do 10 pushups right now.",
    "Tell a joke.",
];

$playAgain = 'y';

while ($playAgain === 'y') {
    echo "Welcome to Truth or Dare! Please choose 't' for truth or 'd' for dare.\n";
    $choice = strtolower(trim(fgets(STDIN)));

    if ($choice === 't') {
        $randomQuestion = $truthQuestions[array_rand($truthQuestions)];
        echo "Truth question: {$randomQuestion}\n";
    } elseif ($choice === 'd') {
        $randomTask = $dareTasks[array_rand($dareTasks)];
        echo "Dare task: {$randomTask}\n";
    } else {
        echo "Invalid choice. Please try again.\n";
        continue;
    }

    echo "Do you want to play again? (y/n)\n";
    $playAgain = strtolower(trim(fgets(STDIN)));
}

echo "Thanks for playing!\n";
