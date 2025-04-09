<?PHP
use src\Business\MarketService;
$message = $route->setActionMessage();
$marketService = new MarketService();
$lastMarketID = $marketService->getLastMarketItem();
$twigVars = array(
    'routing' => $route,
    'settings' => $route->settings,
    'securityToken' => $security->getToken(),
    'langs' => $langs,
    'lang' => $lang,
    'message' => $message,
    'userData' => $userData,
    'online' => $user->getOnlinePlayers(),
    'prisonersCount' => $user->getPrisonersCount(),
    'time' => time(),
    'serverTime' => $serverTime,
    'statusDonatorColors' => $user->getStatusAndDonatorColors(),
    'lastShoutboxID' => $lastShoutboxID,
    'lastFamilyShoutboxID' => $lastFamilyShoutboxID,
    'lastMarketID' => $lastMarketID,
    'unvotedPoll' => $unvotedPoll,
    'offline' => OFFLINE
);
$twigVars['langs']['TRAVELING'] = $route->replaceMessagePart($travelCounter, $twigVars['langs']['TRAVELING'], '/{sec}/');


if(strtotime(DOUBLE_TROUBLE_START) < strtotime('now') && strtotime(DOUBLE_TROUBLE_END) > strtotime('now'))
{
    $twigVars['eventName'] = $twigVars['langs']['DOUBLE_TROUBLE'];
    $twigVars['eventCountdown'] = countdownHmsTime("EventCountdown", strtotime(DOUBLE_TROUBLE_END) - time());
}

//Valatine's day
if(date('Y-m-d') === date('Y')."-02-14"){
    $twigVars['eventName'] = "All you need is 💘💋";
    $twigVars['eventCountdown'] = countdownHmsTime("EventCountdown", strtotime(date('Y')."-02-14 23:59:59") - time());
}
if(strtotime(DOUBLE_CREDITS_START) < strtotime('now') && strtotime(DOUBLE_CREDITS_END) > strtotime('now'))
{
    $twigVars['eventName'] = "Credits x2";
    $twigVars['eventCountdown'] = countdownHmsTime("EventCountdown", strtotime(DOUBLE_CREDITS_END) - time());
}
if(strtotime(TIME_IS_MONEY_START) < strtotime('now') && strtotime(TIME_IS_MONEY_END) > strtotime('now'))
{
    $twigVars['eventName'] = $twigVars['langs']['TIME_IS_MONEY'];
    $twigVars['eventCountdown'] = countdownHmsTime("EventCountdown", strtotime(TIME_IS_MONEY_END) - time());
}
if(strtotime(DOUBLE_FOLLOWERS_START) < strtotime('now') && strtotime(DOUBLE_FOLLOWERS_END) > strtotime('now'))
{
    $twigVars['eventName'] = $twigVars['langs']['MERCENARIES'] . " /2";
    $twigVars['eventCountdown'] = countdownHmsTime("EventCountdown", strtotime(DOUBLE_FOLLOWERS_END) - time());
}

