<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain;

use BallGame\Domain\BinaryGap;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;


class GetTheBallRollingTest extends TestCase
{
    /**
     * @var Team
     */
    private $favorites;
    /**
     * @var Team
     */
    private $rivals;

    /**
     * @var BinaryGap
     */
    protected $binaryGap;

    public function setUp(): void
    {
        $this->favorites = Team::create('Bayern');
        $this->rivals = Team::create('Borussia');

        $this->binaryGap = new BinaryGap();
    }

    public function testFavoriteTeam()
    {
        $this->assertSame('Bayern', $this->favorites->getName());
    }

    public function testNotSoFavoriteTeam()
    {
        $this->assertSame('Borussia', $this->rivals->getName());
    }

    public function testBinaryGapForNoZeros()
    {
        $expectedGap = 0;
        $actualGap = $this->binaryGap->calculate(3); // 11

        $this->assertSame($expectedGap, $actualGap);
    }

    public function testBinaryGapForTwoZeros()
    {
        $expectedGap = 2;
        $actualGap = $this->binaryGap->calculate(9); // 1001

        $this->assertSame($expectedGap, $actualGap);
    }

    public function testBinaryGapCalculatesBiggestWhenMultipleGapsArePresent()
    {
        $expectedGap = 2;
        $actualGap = $this->binaryGap->calculate(37); // 100101

        $this->assertSame($expectedGap, $actualGap);
    }

    public function testBinaryGapWhenThereAreNoSurroundingOnes()
    {
        $expectedGap = 0;
        $actualGap = $this->binaryGap->calculate(32); // 100000

        $this->assertSame($expectedGap, $actualGap);
    }
}
