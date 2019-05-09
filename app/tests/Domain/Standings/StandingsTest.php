<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Standings;

use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\AdvancedRuleBook;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use BallGame\Infrastructure\MatchRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class StandingsTest extends TestCase
{
    /**
     * @var MatchRepository|MockObject
     */
    protected $matchRepository;

    /**
     * @var Standings
     */
    protected $standings;

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

    public function testRecordSavesMatchInRepository()
    {
        $this->matchRepository
            ->expects($this->once())
            ->method('save');

        $this->standings->record(
            Match::create(
                Team::create('1'),
                Team::create('2'),
                0,
                0
            )
        );

        $this->assertTrue(true);
    }
}
