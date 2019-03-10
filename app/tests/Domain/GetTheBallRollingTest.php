<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain;

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

    public function setUp(): void
    {
        $this->favorites = Team::create('Bayern');
        $this->rivals = Team::create('Borussia');
    }

    public function testFavoriteTeam()
    {
        $this->assertSame('Bayern', $this->favorites->getName());
    }

    public function testNotSoFavoriteTeam()
    {
        $this->assertSame('Borussia', $this->rivals->getName());
    }
}
