<?PHP

use src\Business\CMSService;
use src\Business\SeoService;

if($security->checkSSL() === false) exit(0);

$loggedSession = $user->checkLoggedSession(false) ? true : false;
if(!$userData)
{
    if($loggedSession)
        $userData = $user->getUserData();
}

$cookie = "false";
$username = "";
if(isset($_COOKIE['cookies-accepted']) && $_COOKIE['cookies-accepted'] == "accepted") $cookie = "true";

$cms = new CMSService();
$seo = new SeoService();
$seoData = $seo->getSeoDataByRouteName($route->getRouteName());
$pageTitle =  "Online Mafia Game - " . ucfirst($route->settings['domainBase']);
$pageSubject = "Free to play text-based online mafia game";
$pageImage = PROTOCOL.STATIC_SUBDOMAIN.".".$route->settings['domainBase']."/web/public/images/bloodbullet.jpg";
$pageUrl = PROTOCOL.$_SERVER['HTTP_HOST'].$route->getRoute();
$pageDescription = $route->settings['gamename'] . " is a free mafia game where you can play with thousands of other players from all over the world. Register now and start playing!";
$pageKeywords = $route->settings['gamename'] . ",mafia game, free mafia game, free online mafia game, mafia rpg, mafia game online, mafia game free, mafia game online free, mafia game free online, mafia game text based, mafia game text based online, mafia game text based free, mafia game text based online free, mafia game text based free online";
$pageAuthor = "@Mafiasource";
if(isset($seoData) && is_object($seoData))
{
    if($seoData->getTitle()) $pageTitle = $seoData->getTitle();
    if($seoData->getSubject()) $pageSubject = $seoData->getSubject();
    if($seoData->getImage()) $pageImage = $seoData->getImage();
    if($seoData->getUrl()) $pageUrl = $seoData->getUrl();
    if($seoData->getDescription()) $pageDescription = substr($seoData->getDescription(), 0, 150)."...";
    if($seoData->getKeywords()) $pageKeywords = $seoData->getKeywords();
}

$ingame = true;
if($user->notIngame()) $ingame = false;
