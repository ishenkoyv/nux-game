<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\LinkRequest;
use App\Models\Link;
use App\Models\GameHistory;
use App\Services\Application\Imfeelinglucky as ImfeelingluckyApplicationService;

class DashboardController extends Controller
{
    /**
     * Dashboard
     */
    public function index(Request $request): View
    {
        $link = $request->user()->getLastActiveLink();

        if (!$link) {
            $link = $request->user()->generateLink();
        }

        return view('dashboard.index', compact('link'));
    }

    /**
     * Page A
     */
    public function link(Link $link, ImfeelingluckyApplicationService $imfeelingluckyService, Request $request): View
    {
        $historyEntries = $imfeelingluckyService->getLatestUserEntries($request->user());

        return view('dashboard.link', compact(['link', 'historyEntries']));
    }

    /**
     * Link deactivation
     */
    public function deactivateLink(Link $link, Request $request): RedirectResponse
    {
        $link->is_active = false;
        $link->save();

        return redirect()->route('dashboard');
    }

    /**
     * Generate new link
     */
    public function generateNewLink(Request $request, ImfeelingluckyApplicationService $imfeelingluckyService): RedirectResponse
    {
        $link = $request->user()->generateLink();

        $historyEntries = $imfeelingluckyService->getLatestUserEntries($request->user());

        return redirect()->route('dashboard.link', compact(['link', 'historyEntries']));
    }


    /**
     * Imfeelinglucky game
     */
    public function imfeelinglucky(Link $link, ImfeelingluckyApplicationService $imfeelingluckyService, Request $request): View
    {
        $number = $imfeelingluckyService->generateRandomNumber();
        $result = $imfeelingluckyService->isWinOrLoseStr($number);
        $winnings = $imfeelingluckyService->winAmountCalcBasedOnWin($result, $number);

        $isImfeelinglucky = true;

        $gameHistory = new GameHistory([
            'user_id' => $request->user()->id,
            'number' => $number,
            'result' => $result,
            'winnings' => $winnings,
        ]);
        $gameHistory->save();

        $historyEntries = $imfeelingluckyService->getLatestUserEntries($request->user());

        return view(
            'dashboard.link',
            compact(['link', 'number', 'result', 'winnings', 'isImfeelinglucky', 'historyEntries'])
        );
    }
}
