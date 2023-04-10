<?php

namespace App\Models;

use App\Enums\GameStatuses;

class Game extends BaseModel
{
    protected string $homeTeam = '';
    protected string $awayTeam = '';
    protected int $homeScore = 0;
    protected int $awayScore = 0;
    protected string $status = GameStatuses::STATUS_NOT_STARTED;
    protected int $createdAt = 0;


    public function getHomeTeam(): string
    {
        return $this->homeTeam;
    }

    public function setHomeTeam(string $homeTeam): void
    {
        $this->homeTeam = $homeTeam;
    }

    public function getAwayTeam(): string
    {
        return $this->awayTeam;
    }

    public function setAwayTeam(string $awayTeam): void
    {
        $this->awayTeam = $awayTeam;
    }

    public function getHomeScore(): int
    {
        return $this->homeScore;
    }

    public function setHomeScore(int $homeScore): void
    {
        $this->homeScore = $homeScore;
    }

    public function getAwayScore(): int
    {
        return $this->awayScore;
    }

    public function setAwayScore(int $awayScore): void
    {
        $this->awayScore = $awayScore;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getTotalScore(): int
    {
        return $this->homeScore + $this->awayScore;
    }
}
