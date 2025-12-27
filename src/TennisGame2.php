<?php

declare(strict_types=1);

namespace TennisGame;

class TennisGame2 implements TennisGame
{
    private int $playerOnePoint = 0;

    private int $playerTwoPoint = 0;

    private string $playerOneResult = '';

    private string $playerTwoResult = '';

    public function __construct(
        private string $playerOneName,
        private string $playerTwoName
    ) {
    }

    public function getScore(): string
    {
        $score = '';
        $score = $this->isResultDraw($score);

        $score = $this->isResultDeuce($score);

        if ($this->playerOnePoint > 0 && $this->playerTwoPoint === 0) {
            if ($this->playerOnePoint === 1) {
                $this->playerOneResult = 'Fifteen';
            }
            if ($this->playerOnePoint === 2) {
                $this->playerOneResult = 'Thirty';
            }
            if ($this->playerOnePoint === 3) {
                $this->playerOneResult = 'Forty';
            }

            $this->playerTwoResult = 'Love';
            $score = "{$this->playerOneResult}-{$this->playerTwoResult}";
        }

        if ($this->playerTwoPoint > 0 && $this->playerOnePoint === 0) {
            if ($this->playerTwoPoint === 1) {
                $this->playerTwoResult = 'Fifteen';
            }
            if ($this->playerTwoPoint === 2) {
                $this->playerTwoResult = 'Thirty';
            }
            if ($this->playerTwoPoint === 3) {
                $this->playerTwoResult = 'Forty';
            }
            $this->playerOneResult = 'Love';
            $score = "{$this->playerOneResult}-{$this->playerTwoResult}";
        }

        if ($this->playerOnePoint > $this->playerTwoPoint && $this->playerOnePoint < 4) {
            if ($this->playerOnePoint === 2) {
                $this->playerOneResult = 'Thirty';
            }
            if ($this->playerOnePoint === 3) {
                $this->playerOneResult = 'Forty';
            }
            if ($this->playerTwoPoint === 1) {
                $this->playerTwoResult = 'Fifteen';
            }
            if ($this->playerTwoPoint === 2) {
                $this->playerTwoResult = 'Thirty';
            }
            $score = "{$this->playerOneResult}-{$this->playerTwoResult}";
        }

        if ($this->playerTwoPoint > $this->playerOnePoint && $this->playerTwoPoint < 4) {
            if ($this->playerTwoPoint === 2) {
                $this->playerTwoResult = 'Thirty';
            }
            if ($this->playerTwoPoint === 3) {
                $this->playerTwoResult = 'Forty';
            }
            if ($this->playerOnePoint === 1) {
                $this->playerOneResult = 'Fifteen';
            }
            if ($this->playerOnePoint === 2) {
                $this->playerOneResult = 'Thirty';
            }
            $score = "{$this->playerOneResult}-{$this->playerTwoResult}";
        }

        if ($this->playerOnePoint > $this->playerTwoPoint && $this->playerTwoPoint >= 3) {
            $score = 'Advantage player1';
        }

        if ($this->playerTwoPoint > $this->playerOnePoint && $this->playerOnePoint >= 3) {
            $score = 'Advantage player2';
        }

        if ($this->playerOnePoint >= 4 && $this->playerTwoPoint >= 0 && ($this->playerOnePoint - $this->playerTwoPoint) >= 2) {
            $score = 'Win for player1';
        }

        if ($this->playerTwoPoint >= 4 && $this->playerOnePoint >= 0 && ($this->playerTwoPoint - $this->playerOnePoint) >= 2) {
            $score = 'Win for player2';
        }

        return $score;
    }

    public function wonPoint(string $player): void
    {
        if ($player === 'player1') {
            $this->P1Score();
        } else {
            $this->P2Score();
        }
    }

    private function SetP1Score(int $number): void
    {
        for ($i = 0; $i < $number; $i++) {
            $this->P1Score();
        }
    }

    private function SetP2Score(int $number): void
    {
        for ($i = 0; $i < $number; $i++) {
            $this->P2Score();
        }
    }

    private function P1Score(): void
    {
        $this->playerOnePoint++;
    }

    private function P2Score(): void
    {
        $this->playerTwoPoint++;
    }

    /**
     * @param string $score
     * @return string
     */
    private function isResultDraw(string $score): string
    {
        if ($this->playerOnePoint !== $this->playerTwoPoint || $this->playerOnePoint >= 4) {
            return $score;
        }

        return $score .= match ($this->playerOnePoint) {
            0 => 'Love-All',
            1 => 'Fifteen-All',
            2 => 'Thirty-All',
            default => '',
        };
    }

    /**
     * @param string $score
     * @return string
     */
    private function isResultDeuce(string $score): string
    {
        if ($this->playerOnePoint === $this->playerTwoPoint && $this->playerOnePoint >= 3) {
            $score = 'Deuce';
        }
        return $score;
    }
}
