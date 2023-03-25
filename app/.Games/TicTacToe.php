<?php

class TicTacToe {
    private array $board;
    private string $player;
    private string $winner;

    public function __construct() {
        $this->board = array_fill(0, 3, array_fill(0, 3, '-'));
        $this->player = 'X';
        $this->winner = '';
    }

    public function play(int $row, int $col): bool {
        if ($this->winner !== '' || $this->board[$row][$col] !== '-') {
            return false;
        }

        $this->board[$row][$col] = $this->player;

        if ($this->checkWinner()) {
            $this->winner = $this->player;
        } else {
            $this->player = $this->player === 'X' ? 'O' : 'X';
        }

        return true;
    }

    public function checkWinner(): bool {
        // check rows
        for ($i = 0; $i < 3; $i++) {
            if ($this->board[$i][0] === $this->player &&
                $this->board[$i][1] === $this->player &&
                $this->board[$i][2] === $this->player) {
                return true;
            }
        }

        // check columns
        for ($j = 0; $j < 3; $j++) {
            if ($this->board[0][$j] === $this->player &&
                $this->board[1][$j] === $this->player &&
                $this->board[2][$j] === $this->player) {
                return true;
            }
        }

        // check diagonals
        if ($this->board[0][0] === $this->player &&
            $this->board[1][1] === $this->player &&
            $this->board[2][2] === $this->player) {
            return true;
        }

        if ($this->board[2][0] === $this->player &&
            $this->board[1][1] === $this->player &&
            $this->board[0][2] === $this->player) {
            return true;
        }

        return false;
    }

    public function isDraw(): bool {
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($this->board[$i][$j] === '-') {
                    return false;
                }
            }
        }

        return true;
    }

    public function display(): void {
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                echo $this->board[$i][$j] . ' ';
            }

            echo "\n";
        }
    }

    public function getWinner(): string {
        return $this->winner;
    }

    public function play2()
    {
        $this->display();

        while (true) {
            echo "Player {$this->player} turn: ";
            $input = explode(' ', trim(fgets(STDIN)));
            $row = (int) $input[0];
            $col = (int) $input[1];

            if (!$this->play($row, $col)) {
                echo "Invalid move!\n";
                continue;
            }

            $this->display();

            if ($this->winner !== '') {
                echo "Player {$this->winner} wins!\n";
                return;
            }

            if ($this->isDraw()) {
                echo "It's a draw!\n";
                return;
            }
        }


    }
}

$game = new TicTacToe();
$game->play2();





