<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Match;

use BallGame\Domain\Match\Match;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class MatchTest extends TestCase
{

    /**
     * @expectedException \BallGame\Domain\Exception\MatchBetweenSameTeamException
     */
    public function testCreateThrowsAnExceptionWhenMatchHappensBetweenSameTeams()
    {
        Match::create(
            Team::create('same name here'),
            Team::create('same name here'),
            42,
            13
        );
    }
}
