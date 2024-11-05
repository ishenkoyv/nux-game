<?php

namespace Tests\Unit\Services\Application;

use PHPUnit\Framework\TestCase;
use App\Models\GameHistory;
use App\Services\Application\Imfeelinglucky;

class ImfeelluckyTest extends TestCase
{
    public function testGenerateRandomNumber()
    {
        $service = new Imfeelinglucky();
        $randomNumber = $service->generateRandomNumber();
        $this->assertGreaterThanOrEqual(1, $randomNumber);
        $this->assertLessThanOrEqual(1000, $randomNumber);
        $this->assertIsInt($randomNumber);
    }

    public function testIsWinOrLose()
    {
        $service = new Imfeelinglucky();
        $this->assertTrue($service->isWinOrLose(2));
        $this->assertFalse($service->isWinOrLose(3));
    }

    public function testIsWinOrLoseStr()
    {
        $service = new Imfeelinglucky();
        $this->assertEquals(GameHistory::WINNINGS_WIN, $service->isWinOrLoseStr(2));
        $this->assertEquals(GameHistory::WINNINGS_LOSE, $service->isWinOrLoseStr(3));
    }

    public function testWinAmountCalc()
    {
        $service = new Imfeelinglucky();
        $this->assertEquals(10, $service->winAmountCalc(100));
        $this->assertEquals(135, $service->winAmountCalc(450));
        $this->assertEquals(350, $service->winAmountCalc(700));
        $this->assertEquals(637, $service->winAmountCalc(910));
    }

    public function testWinAmountCalcBasedOnWin()
    {
        $service = new Imfeelinglucky();
        $this->assertEquals(10, $service->winAmountCalcBasedOnWin(GameHistory::WINNINGS_WIN, 100));
        $this->assertEquals(0, $service->winAmountCalcBasedOnWin(GameHistory::WINNINGS_LOSE, 100));
    }
}
