<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Standings;

use BallGame\Domain\Match\Match;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class StandingsTest extends TestCase
{
    public function testGetSortedStandings()
    {
        $elephants = Team::create('Elephants');
        $tigers = Team::create('Tigers');

        $match = Match::create($elephants, $tigers, 3, 2);

        $standings = new Standings();

        $standings->record($match);

        $actualSortedStandings = $standings->getSortedStandings();

        $expectedStandings = [
            ['Elephants', 3, 2, 3],
            ['Tigers', 2, 3, 0],
        ];

        $this->assertSame($expectedStandings, $actualSortedStandings);
    }

    public function testGetSortedStandingsWhenSecondTeamEndsUpFirst()
    {
        $elephants = Team::create('Elephants');
        $tigers = Team::create('Tigers');

        $match = Match::create($elephants, $tigers, 0, 1);

        $standings = new Standings();

        $standings->record($match);

        $actualSortedStandings = $standings->getSortedStandings();

        $expectedStandings = [
            ['Tigers', 1, 0, 3],
            ['Elephants', 0, 1, 0],
        ];

        $this->assertSame($expectedStandings, $actualSortedStandings);
    }
}
