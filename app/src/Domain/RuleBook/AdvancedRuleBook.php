<?php
declare(strict_types=1);


namespace BallGame\Domain\RuleBook;


use BallGame\Domain\Team\Position;

class AdvancedRuleBook implements RuleBookInterface
{
    public function decide(Position $teamA, Position $teamB): int
    {
        if ($teamA->getPoints() > $teamB->getPoints()) {
            return -1;
        }

        if ($teamB->getPoints() > $teamA->getPoints()) {
            return 1;
        }

        if ($teamA->getPoints() === $teamA->getPoints()) {
            if ($teamA->getGoalsScored() > $teamB->getGoalsScored()) {
                return -1;
            }

            if ($teamB->getGoalsScored() > $teamA->getGoalsScored()) {
                return 1;
            }
        }

        return 0;
    }
}
