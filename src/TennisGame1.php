<?php

declare(strict_types=1);

namespace TennisGame;

class TennisGame1 implements TennisGame
{
    private int $firstPlayerScore = 0;

    private int $secondPlayerScore = 0;

    public function __construct(
        private string $player1Name,
        private string $player2Name
    ) {
    }

    public function wonPoint(string $playerName): void
    {
        match ($playerName) {
            'player1' => $this->firstPlayerScore++,
            'player2' => $this->secondPlayerScore++,
        };
    }

    public function getScore(): string
    {
        if ($this->firstPlayerScore === $this->secondPlayerScore) {
            return $this->calculateDeuce();
        }

        if ($this->firstPlayerScore < 4 && $this->secondPlayerScore < 4) {
            return $this->roundsScore($score = '');
        }

        return $this->getWinnersAccordingToMinusResult($this->calculateMinusResult());
    }

    /**
     * @return string
     */
    private function calculateDeuce(): string
    {
        return match ($this->firstPlayerScore) {
            0 => 'Love-All',
            1 => 'Fifteen-All',
            2 => 'Thirty-All',
            default => 'Deuce',
        };
    }

    /**
     * @param string $score
     * @return string
     */
    private function roundsScore(string $score): string
    {
        for ($iteration = 1; $iteration < 3; $iteration++) {
            list($tempScore, $score) = $this->getTempScore($iteration, $score);

            $score = $this->getTempScoreName($tempScore, $score);
        }

        return $score;
    }

    /**
     * @param int $tempScore
     * @param string $score
     * @return string
     */
    private function getTempScoreName(int $tempScore, string $score): string
    {
        return match ($tempScore) {
            0 => $score .="Love",
            1 => $score .="Fifteen",
            2 => $score .="Thirty",
            3 => $score .="Forty",
        };
    }

    /**
     * @param mixed $i
     * @param string $score
     * @return array
     */
    private function getTempScore(mixed $i, string $score): array
    {
        if ($i !== 1) {
            $score .= '-';
            return [$this->secondPlayerScore, $score];
        }

        return [$this->firstPlayerScore, $score];
    }

    /**
     * @return int
     */
    private function calculateMinusResult(): int
    {
        return $this->firstPlayerScore - $this->secondPlayerScore;
    }

    /**
     * @param int $minusResult
     * @return string
     */
    private function getWinnersAccordingToMinusResult(int $minusResult): string
    {
        return match (true) {
            $minusResult === 1 => 'Advantage player1',
            $minusResult === -1 => 'Advantage player2',
            $minusResult >= 2 => 'Win for player1',
            default => 'Win for player2',
        };
    }
}
