<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Team;

use BallGame\Domain\Team\Position;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{
    /**
     * @var Position
     */
    protected $position;

    public function setUp()
    {
        $this->position = new Position(Team::create('My team'));
    }

    public function testGetPointsWhenNoRecordedMatches()
    {
        $this->assertSame(0, $this->position->getPoints());
    }

    public function testGetPointsWhenTwoRecordedWins()
    {
        $this->position->recordWin();
        $this->position->recordWin();

        $this->assertSame(6, $this->position->getPoints());
    }

    public function testGetPointsWhenRecordedLoss()
    {
        $this->position->recordLoss();

        $this->assertSame(0, $this->position->getPoints());
    }

    public function testGetGoalsScoredWhenNoMatchesHaveBeenPlayed()
    {
        $this->assertSame(0, $this->position->getGoalsScored());
    }

    public function testGoalsScoredWhenFewMatchesHaveBeenPlayed()
    {
        $this->position->recordGoalsScored(1);
        $this->position->recordGoalsScored(2);
        $this->position->recordGoalsScored(3);

        $this->assertSame(6, $this->position->getGoalsScored());
    }

    public function testGetGoalsReceivedWhenNoMatchesHaveBeenPlayed()
    {
        $this->assertSame(0, $this->position->getGoalsReceived());
    }

    public function testGoalsReceivedWhenFewMatchesHaveBeenPlayed()
    {
        $this->position->recordGoalsReceived(10);
        $this->position->recordGoalsReceived(20);
        $this->position->recordGoalsReceived(30);

        $this->assertSame(60, $this->position->getGoalsReceived());
    }

    public function tearDown()
    {
        unset($this->position);
    }
}
