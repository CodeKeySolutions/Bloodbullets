<?php

if($security->checkSSL() === false) exit(0);
if(!$user->checkLoggedSession())
{
    $route->headTo('home');
    exit(0);
}
else
{
    // check if date is april 1st to strtotime

    if(date('m-d') != '04-01')
    {
        $route->headTo('home');
        exit(0);
    }
    if(isset($_POST['submit-prank']))
    {
        $route->createActionMessage($route->errorMessage('You have been fooled!'));
        $route->headTo('game');
        $_SESSION['prank'] = true;
        exit(0);
    }
    else {
    $route->headTo('1-april-fool');
    exit(0);
    }

    require_once __DIR__ . '/.inc.foot.php';

    print_r($twig->render('/src/Views/game/april-fools.twig', $twigVars));
}