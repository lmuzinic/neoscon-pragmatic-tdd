<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\RuleBook;

use BallGame\Domain\RuleBook\AdvancedRuleBook;
use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Team\Position;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AdvancedRuleBookTest extends TestCase
{
    /**
     * @var SimpleRuleBook
     */
    protected $ruleBook;

    /**
     * @var Position
     */
    protected $teamPositionA;

    /**
     * @var Position
     */
    protected $teamPositionB;

    public function setUp()
    {
        $this->teamPositionA = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->teamPositionB = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->ruleBook = new AdvancedRuleBook();
    }

    public function testDecideReturnsNegativeOneWhenFirstTeamHasMorePoints()
    {
        $this->teamPositionA->method('getPoints')->willReturn(42);
        $this->teamPositionB->method('getPoints')->willReturn(41);

        $this->assertSame(-1, $this->ruleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

    public function testDecideReturnsPositiveOneWhenSecondTeamHasMorePoints()
    {
        $this->teamPositionA->method('getPoints')->willReturn(42);
        $this->teamPositionB->method('getPoints')->willReturn(43);

        $this->assertSame(1, $this->ruleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

    public function testDecideReturnsNegativeOneWhenTeamsAreEqualInPointsButFirstTeamHasMoreGoalsScored()
    {
        $this->teamPositionA->method('getPoints')->willReturn(42);
        $this->teamPositionB->method('getPoints')->willReturn(42);

        $this->teamPositionA->method('getGoalsScored')->willReturn(10);
        $this->teamPositionB->method('getGoalsScored')->willReturn(9);

        $this->assertSame(-1, $this->ruleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

    public function testDecideReturnsPositiveOneWhenTeamsAreEqualInPointsButSecondTeamHasMoreGoalsScored()
    {
        $this->teamPositionA->method('getPoints')->willReturn(42);
        $this->teamPositionB->method('getPoints')->willReturn(42);

        $this->teamPositionA->method('getGoalsScored')->willReturn(10);
        $this->teamPositionB->method('getGoalsScored')->willReturn(11);

        $this->assertSame(1, $this->ruleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

    public function testDecideReturnsZeroWhenBothTeamsHaveEqualAmountOfPointsAndEqualGoalsScored()
    {
        $this->teamPositionA->method('getPoints')->willReturn(42);
        $this->teamPositionB->method('getPoints')->willReturn(42);

        $this->teamPositionA->method('getGoalsScored')->willReturn(10);
        $this->teamPositionB->method('getGoalsScored')->willReturn(10);

        $this->assertSame(0, $this->ruleBook->decide($this->teamPositionA, $this->teamPositionB));
    }
}
