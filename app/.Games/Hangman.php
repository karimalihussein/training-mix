<?php

class Hangman
{
    private const MAX_GUESSES = 6; // Maximum number of incorrect guesses allowed
    private const WORD_LIST = [
        'apple', 'banana', 'cherry', 'date', 'elderberry', 'fig', 'grape', 'honeydew', 'kiwi', 'lemon'
    ];

    private string $word; // The word to guess
    private array $guesses = []; // List of guessed letters
    private int $incorrectGuesses = 0; // Number of incorrect guesses

    public function __construct()
    {
        // Select a random word from the list
        $this->word = self::WORD_LIST[rand(0, count(self::WORD_LIST) - 1)];
    }

    public function play(string $letter): void
    {
        // Ignore invalid guesses (non-letters or duplicates)
        if (!ctype_alpha($letter) || in_array($letter, $this->guesses)) {
            return;
        }

        // Add the guess to the list
        $this->guesses[] = $letter;

        // Check if the guess is correct
        if (!strpos($this->word, $letter)) {
            $this->incorrectGuesses++;
        }
    }

    public function isGameOver(): bool
    {
        // Game over if all letters have been guessed or maximum number of incorrect guesses have been made
        return $this->isWordGuessed() || $this->incorrectGuesses >= self::MAX_GUESSES;
    }

    public function isWordGuessed(): bool
    {
        // Word is guessed if all its letters have been guessed
        foreach (str_split($this->word) as $letter) {
            if (!in_array($letter, $this->guesses)) {
                return false;
            }
        }
        return true;
    }

    public function displayWord(): string
    {
        // Hide unguessed letters with underscores
        $display = '';
        foreach (str_split($this->word) as $letter) {
            $display .= in_array($letter, $this->guesses) ? $letter : '_';
            $display .= ' ';
        }
        return $display;
    }

    public function displayMan(): string
    {
        // Draw a part of the man for each incorrect guess
        $parts = [
            ($this->incorrectGuesses >= 1) ? 'O' : '',
            ($this->incorrectGuesses >= 2) ? '|' : '',
            ($this->incorrectGuesses >= 3) ? '/' : '',
            ($this->incorrectGuesses >= 4) ? '\\' : '',
            ($this->incorrectGuesses >= 5) ? '/' : '',
            ($this->incorrectGuesses >= 6) ? '\\' : '',
        ];
        return implode('', $parts);
    }
}

// Start a new game
$game = new Hangman();

// Game loop
while (!$game->isGameOver()) {
    // Display the current state of the game
    echo $game->displayMan() . "\n";
    echo $game->displayWord() . "\n\n";

    // Ask the player for a guess
    echo 'Guess a letter: ';
    $guess = trim(fgets(STDIN));

    // Make the guess
    $game->play($guess);
}

// Display the final state of the game
echo $game->displayMan() . "\n";
echo $game->displayWord() . "\n\n";

