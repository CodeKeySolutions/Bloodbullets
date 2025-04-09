<?php

use app\config\Routing;
use src\Business\ShoutboxService;

require_once __DIR__ . '/.inc.head.php';



// require_once __DIR__ ."/.inc.foot.php";
$reportID = $route->requestGetParam(4);
$type = $route->requestGetParam(3);


$sb = new ShoutboxService();
if($type == "report" && isset($reportID) )
{
  $sb->reportMessage($reportID);
  exit(0);
}

if($userData->getStatusId() <= 4){
  if($type == "mute" && isset($reportID))
  {

    $sb->muteUserById($reportID);
    exit(0);
  }
  if($type == "delete" && isset($reportID))
  {
    $sb->deleteMessageById($reportID);
    exit(0);
  }
}

?>