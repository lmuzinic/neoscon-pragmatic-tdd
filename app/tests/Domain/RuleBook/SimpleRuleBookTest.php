<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\RuleBook;

use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Team\Position;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SimpleRuleBookTest extends TestCase
{
    /**
     * @var SimpleRuleBook
     */
    protected $ruleBook;

    public function setUp()
    {
        $this->ruleBook = new SimpleRuleBook();
    }

    public function testDecideReturnsNegativeOneWhenFirstTeamHasMorePoints()
    {
        /** @var MockObject|Position $teamPositionA */
        $teamPositionA = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();
        $teamPositionA->method('getPoints')->willReturn(42);

        /** @var MockObject|Position $teamPositionB */
        $teamPositionB = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();
        $teamPositionB->method('getPoints')->willReturn(41);

        $this->assertSame(-1, $this->ruleBook->decide($teamPositionA, $teamPositionB));
    }

    public function testDecideReturnsPositiveOneWhenSecondTeamHasMorePoints()
    {
        /** @var MockObject|Position $teamPositionA */
        $teamPositionA = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();
        $teamPositionA->method('getPoints')->willReturn(42);

        /** @var MockObject|Position $teamPositionB */
        $teamPositionB = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();
        $teamPositionB->method('getPoints')->willReturn(43);

        $this->assertSame(1, $this->ruleBook->decide($teamPositionA, $teamPositionB));
    }

    public function testDecideReturnsZeroWhenBothTeamsHaveEqualAmountOfPoints()
    {
        /** @var MockObject|Position $teamPositionA */
        $teamPositionA = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();
        $teamPositionA->method('getPoints')->willReturn(42);

        /** @var MockObject|Position $teamPositionB */
        $teamPositionB = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();
        $teamPositionB->method('getPoints')->willReturn(42);

        $this->assertSame(0, $this->ruleBook->decide($teamPositionA, $teamPositionB));
    }
}
