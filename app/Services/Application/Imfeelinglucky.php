<?php

namespace App\Services\Application;

use Illuminate\Database\Eloquent\Collection;
use App\Models\GameHistory;
use App\Models\User;

class Imfeelinglucky
{
    /**
     * generateRandomNumber
     *
     * @access public
     * @return int
     */
    public function generateRandomNumber(): int
    {
        return random_int(1, 1000);
    }

    /**
     * isWinOrLose
     *
     * @param int $num
     * @access public
     * @return bool
     */
    public function isWinOrLose(int $num): bool
    {
        return $num % 2 === 0;
    }

    /**
     * isWinOrLoseStr
     *
     * @param int $num
     * @access public
     * @return string
     */
    public function isWinOrLoseStr(int $num): string
    {
        return $this->isWinOrLose($num)
            ? GameHistory::WINNINGS_WIN
            : GameHistory::WINNINGS_LOSE;
    }

    /**
     * winAmountCalcBasedOnWin
     *
     * @param string $winOrLose
     * @param int $num
     * @access public
     * @return float
     */
    public function winAmountCalcBasedOnWin(string $winOrLose, int $num): float
    {
        $res = 0.00;

        if (GameHistory::WINNINGS_WIN === $winOrLose) {
            $res = $this->winAmountCalc($num);
        }

        return $res;
    }

    /**
     * winAmountCalc
     *
     * @param int $num
     * @access public
     * @return float
     */
    public function winAmountCalc(int $num): float
    {
        $winnings = match (true) {
            $num > 900 => $num * 0.7,
            $num > 600 => $num * 0.5,
            $num > 300 => $num * 0.3,
            default => $num * 0.1,
        };

        return $winnings;
    }

    /**
     * getLatestUserEntries
     *
     * @param User $user
     * @access public
     * @return Collection
     */
    public function getLatestUserEntries(User $user): Collection
    {
        $historyEntries = GameHistory::where('user_id', $user->id)
            ->orderBy('played_at', 'desc')
            ->limit(3)
            ->get();

        return $historyEntries;
    }
}
