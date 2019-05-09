<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Standings;

use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\AdvancedRuleBook;
use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use BallGame\Infrastructure\MatchRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AdvancedRuleBookStandingsTest extends TestCase
{
    /**
     * @var Standings
     */
    protected $standings;

    /**
     * @var MatchRepository|MockObject
     */
    protected $matchRepository;

    public function setUp()
    {
        $this->matchRepository = $this->getMockBuilder(MatchRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->standings = new Standings(
            new AdvancedRuleBook(),
            $this->matchRepository
        );
    }

    public function testGetSortedStandings()
    {
        $elephants = Team::create('Elephants');
        $tigers = Team::create('Tigers');

        $this->matchRepository->method('findAll')->willReturn([
            Match::create($elephants, $tigers, 3, 1),
            Match::create($elephants, $tigers, 0, 1)
        ]);

        $actualSortedStandings = $this->standings->getSortedStandings();

        $expectedStandings = [
            ['Elephants', 3, 2, 3],
            ['Tigers', 2, 3, 3],
        ];

        $this->assertSame($expectedStandings, $actualSortedStandings);
    }
}
