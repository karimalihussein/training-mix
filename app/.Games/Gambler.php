<?php

interface IBankroll {
    public function getBankroll(): int;
}

class Player implements IBankroll {
    private int $pennies;

    public function __construct(private string $name, int $pennies)
    {
        $this->pennies = $pennies;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function givePenny(Player $player2): void
    {
        $player2->addPenny();
        $this->subtractPenny();
    }

    public function addPenny(): void
    {
        $this->pennies++;
    }

    public function subtractPenny(): void
    {
        $this->pennies--;
    }

    public function bankrupt(): bool
    {
        return $this->pennies === 0;
    }

    public function getBankroll(): int
    {
        return $this->pennies;
    }

    public function calculateOdds(Player $player2): float
    {
        return round(1 - ($player2->getBankroll() / ($this->getBankroll() + $player2->getBankroll())), 3) * 100;
    }
}

class Game {
    private int $flips = 1;
    private Player $player1;
    private Player $player2;

    public function __construct(Player $player1, Player $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    public function start(): void
    {
        echo "Game Start!\n\n";
        echo "{$this->player1->getName()} Odds: {$this->player1->calculateOdds($this->player2)}%\n";
        echo "{$this->player2->getName()} Odds: {$this->player2->calculateOdds($this->player1)}%\n\n";
        $this->play();
    }

    public function play(): void
    {
        while (true) {
            if ($this->flip() === 'heads') {
                $this->player2->givePenny($this->player1);
            } else {
                $this->player1->givePenny($this->player2);
            }

            if ($this->player1->bankrupt() || $this->player2->bankrupt()) {
                $this->end();
                return;
            }

            $this->flips++;
        }
    }

    public function flip(): string
    {
        return rand(0, 1) ? 'heads' : 'tails';
    }

    public function winner(): Player
    {
        return $this->player1->getBankroll() > $this->player2->getBankroll() ? $this->player1 : $this->player2;
    }

    public function end(): void
    {
        echo "Game Over.\n\n";
        echo "Winner is: {$this->winner()->getName()}\n\n";
        echo "{$this->player1->getName()} Pennies: {$this->player1->getBankroll()}\n";
        echo "{$this->player2->getName()} Pennies: {$this->player2->getBankroll()}\n\n";
        echo "Total Flips: {$this->flips}\n\n";
    }
}

$game = new Game(
    new Player('Joe', 200),
    new Player('Jane', 100),
);

$game->start();

