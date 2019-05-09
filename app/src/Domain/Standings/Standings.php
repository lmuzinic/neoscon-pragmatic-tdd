<?php
declare(strict_types=1);


namespace BallGame\Domain\Standings;


use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\RuleBookInterface;
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

    /**
     * @var RuleBookInterface
     */
    private $ruleBook;

    public function __construct(RuleBookInterface $ruleBook)
    {
        $this->ruleBook = $ruleBook;
    }

    public function record(Match $match)
    {
        $this->matches[] = $match;
    }

    public function getSortedStandings()
    {
        foreach ($this->matches as $match) {
            $homeTeamPosition = $this->getHomeTeamPosition($match);
            $awayTeamPosition = $this->getAwayTeamPosition($match);

            // Home team won
            if ($match->getHomeTeamPoints() > $match->getAwayTeamPoints()) {
                $homeTeamPosition->recordWin();
            }

            // Away team won
            if ($match->getAwayTeamPoints() > $match->getHomeTeamPoints()) {
                $awayTeamPosition->recordWin();
            }

            $homeTeamPosition->recordGoalsScored($match->getHomeTeamPoints());
            $homeTeamPosition->recordGoalsReceived($match->getAwayTeamPoints());
            $awayTeamPosition->recordGoalsScored($match->getAwayTeamPoints());
            $awayTeamPosition->recordGoalsReceived($match->getHomeTeamPoints());
        }

        uasort($this->positions, [$this->ruleBook, 'decide']);

        $finalStandings = [];
        foreach ($this->positions as $position) {
            $finalStandings[] = [
                $position->getTeam()->getName(),
                $position->getGoalsScored(),
                $position->getGoalsReceived(),
                $position->getPoints()
            ];
        }

        return $finalStandings;
    }

    /**
     * @param Match $match
     * @return Position
     */
    private function getHomeTeamPosition(Match $match): Position
    {
        if (!isset($this->positions[sha1($match->getHomeTeam()->getName())])) {
            $this->positions[sha1($match->getHomeTeam()->getName())] = new Position($match->getHomeTeam());
        }

        return $this->positions[sha1($match->getHomeTeam()->getName())];
    }

    /**
     * @param Match $match
     * @return Position
     */
    private function getAwayTeamPosition(Match $match): Position
    {
        if (!isset($this->positions[sha1($match->getAwayTeam()->getName())])) {
            $this->positions[sha1($match->getAwayTeam()->getName())] = new Position($match->getAwayTeam());
        }

        return $this->positions[sha1($match->getAwayTeam()->getName())];
    }
}
