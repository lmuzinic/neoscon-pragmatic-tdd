<?php
declare(strict_types=1);


namespace BallGame\Domain\Team;


class Position
{
    private $wins = 0;

    private $losses = 0;

    private $goalsScored = 0;

    private $goalsReceived = 0;

    /**
     * @var Team
     */
    private $team;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function recordWin()
    {
        $this->wins += 1;
    }

    public function recordLoss()
    {
        $this->losses += 1;
    }

    public function recordGoalsScored(int $goals)
    {
        $this->goalsScored += $goals;
    }

    public function recordGoalsReceived(int $goals)
    {
        $this->goalsReceived += $goals;
    }

    public function getPoints()
    {
        return $this->wins * 3;
    }

    public function getGoalsScored()
    {
        return $this->goalsScored;
    }

    public function getGoalsReceived()
    {
        return $this->goalsReceived;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }
}
