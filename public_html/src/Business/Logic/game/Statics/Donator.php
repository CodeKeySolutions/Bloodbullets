<?PHP

namespace src\Business\Logic\game\Statics;

use src\Data\config\DBConfig;

class Donator
{
    private $startEvent = "2025-03-21 00:00:00";
    private $endEvent = "2025-03-24 00:00:00";
    public function adjustWaitingTime($wt, $donatorID, $halvingTimesTime = 0)
    {
        // Halving times for donators and up, weekends
        if(((date('N') == 5 && date('H') >= 14) || (date('N') == 1 && date('H') < 14)) || date('N') >= 6)
        {
            if($donatorID == 10)
                $wt *= 0.5;
            elseif($donatorID <= 5 && $donatorID >= 1)
                $wt *= 0.75;
        }

        // User halving times from donationshop
        if($halvingTimesTime > time())
            $wt *= 0.5;

        // Halving times event example
        if(strtotime(TIME_IS_MONEY_START) < strtotime('now') && strtotime(TIME_IS_MONEY_END) > strtotime('now'))
            $wt *= 0.5;

        return round($wt);
    }
}
