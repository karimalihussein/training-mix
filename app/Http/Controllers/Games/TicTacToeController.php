<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TicTacToeController extends Controller
{
    public function index()
    {
        $board = Session::get('board', array_fill(0, 9, ''));
        $winner = $this->checkWinner($board);
        $gameOver = $winner || !in_array('', $board);

        return view('games.tic-tac-toe', compact('board', 'winner', 'gameOver'));
    }

    public function play(Request $request)
    {
        $board = Session::get('board', array_fill(0, 9, ''));
        $move = (int) $request->input('move');

        if ($board[$move] === '' && !$this->checkWinner($board)) {
            $board[$move] = 'X';

            if (!$this->checkWinner($board) && in_array('', $board)) {
                $aiMove = $this->getBestMove($board);
                $board[$aiMove] = 'O';
            }
        }

        Session::put('board', $board);
        return redirect()->route('tic-tac-toe.index');
    }

    public function reset()
    {
        Session::forget('board');
        return redirect()->route('tic-tac-toe.index');
    }

    private function getBestMove(array $board): int
    {
        $bestScore = -INF;
        $move = 0;

        foreach ($board as $i => $cell) {
            if ($cell === '') {
                $board[$i] = 'O';
                $score = $this->minimax($board, false);
                $board[$i] = '';

                if ($score > $bestScore) {
                    $bestScore = $score;
                    $move = $i;
                }
            }
        }

        return $move;
    }

    private function minimax(array $board, bool $isMaximizing): int
    {
        $winner = $this->checkWinner($board);
        if ($winner === 'O') return 1;
        if ($winner === 'X') return -1;
        if (!in_array('', $board)) return 0;

        $bestScore = $isMaximizing ? -INF : INF;

        foreach ($board as $i => $cell) {
            if ($cell === '') {
                $board[$i] = $isMaximizing ? 'O' : 'X';
                $score = $this->minimax($board, !$isMaximizing);
                $board[$i] = '';

                $bestScore = $isMaximizing ? max($score, $bestScore) : min($score, $bestScore);
            }
        }

        return $bestScore;
    }

    private function checkWinner(array $b): ?string
    {
        $wins = [
            [0, 1, 2],
            [3, 4, 5],
            [6, 7, 8],
            [0, 3, 6],
            [1, 4, 7],
            [2, 5, 8],
            [0, 4, 8],
            [2, 4, 6],
        ];

        foreach ($wins as [$a, $b1, $c]) {
            if ($b[$a] !== '' && $b[$a] === $b[$b1] && $b[$a] === $b[$c]) {
                return $b[$a];
            }
        }

        return null;
    }
}