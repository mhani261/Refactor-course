<?php

declare(strict_types=1);

namespace TennisGame;

class TennisGame1 implements TennisGame
{
    private int $m_score1 = 0;

    private int $m_score2 = 0;

    public function __construct(
        private string $player1Name,
        private string $player2Name
    ) {
    }

    public function wonPoint(string $playerName): void
    {
        match ($playerName) {
            'player1' => $this->m_score1++,
            'player2' => $this->m_score2++,
        };
    }

    public function getScore(): string
    {
        if ($this->m_score1 === $this->m_score2) {
            return $this->calculateDeuce();
        }

        if ($this->m_score1 < 4 && $this->m_score2 < 4) {
            return $this->roundsScore($score = '');
        }

        return $this->getWinnersAccordingToMinusResult($this->calculateMinusResult());
    }

    /**
     * @return string
     */
    private function calculateDeuce(): string
    {
        return match ($this->m_score1) {
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
            return [$this->m_score2, $score];
        }

        return [$this->m_score1, $score];
    }

    /**
     * @return int
     */
    private function calculateMinusResult(): int
    {
        return $this->m_score1 - $this->m_score2;
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
