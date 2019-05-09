<?php
declare(strict_types=1);


namespace BallGame\Domain\Standings;


use BallGame\Domain\Match\Match;
use BallGame\Domain\Team\Position;

class Standings
{
    /**
     * @var Position[]
     */
    protected $positions;

    /**
     * @var Match[]
     */
    private $matches;

    public function record(Match $match)
    {
        $this->matches[] = $match;
    }

    public function getSortedStandings()
    {
        foreach ($this->matches as $match) {
            if (!isset($this->positions[spl_object_hash($match->getHomeTeam())])) {
                $this->positions[spl_object_hash($match->getHomeTeam())] = new Position($match->getHomeTeam());
            }
            $homeTeamPosition = $this->positions[spl_object_hash($match->getHomeTeam())];
            if (!isset($this->positions[spl_object_hash($match->getAwayTeam())])) {
                $this->positions[spl_object_hash($match->getAwayTeam())] = new Position($match->getAwayTeam());
            }
            $awayTeamStanding =  $this->positions[spl_object_hash($match->getAwayTeam())];

            // Home team won
            if ($match->getHomeTeamPoints() > $match->getAwayTeamPoints()) {
                $homeTeamPosition->recordWin();
            }

            // Away team won
            if ($match->getAwayTeamPoints() > $match->getHomeTeamPoints()) {
                $awayTeamStanding->recordWin();
            }
            $homeTeamPosition->recordGoalsScored($match->getHomeTeamPoints());
            $homeTeamPosition->recordGoalsReceived($match->getAwayTeamPoints());
            $awayTeamStanding->recordGoalsScored($match->getAwayTeamPoints());
            $awayTeamStanding->recordGoalsReceived($match->getHomeTeamPoints());
        }

        uasort($this->positions, function (Position $teamA, Position $teamB)
        {
            if ($teamA->getPoints() > $teamB->getPoints()) {
                return -1;
            }
            if ($teamB->getPoints() > $teamA->getPoints()) {
                return 1;
            }
            return 0;
        });

        $finalStandings = [];
        foreach ($this->positions as $teamStanding) {
            $finalStandings[] = [
                $teamStanding->getTeam()->getName(),
                $teamStanding->getGoalsScored(),
                $teamStanding->getGoalsReceived(),
                $teamStanding->getPoints()
            ];
        }

        return $finalStandings;
    }
}
