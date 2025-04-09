<?PHP
use src\Business\MemberService;

$member = new MemberService();
$member->redirectIfLoggedIn();

if(isset($_POST['submit-login']))
{
    // $member->createMember("info@bloodbullets.nl", "password", "123", "123","123","123","123");
    $remember = "";
    if(isset($_POST['remember'])) $remember = $_POST['remember'];
    $check = $member->login($_POST['email'], $_POST['password'], $_POST['security-token'], $remember);
    if(isset($check) && is_bool($check) && $check == TRUE)
    {
        $security->generateNewToken();
        $route->headTo('admin');
        exit(0);
    }
    else
    {
        $security->generateNewToken();
        $route->createActionMessage($route::errorMessage($check));
        $route->headTo('admin-login');
        exit(0);
    }
}
else
{
    require_once __DIR__ . '/.inc.foot.php';

    print_r($twig->render('/src/Views/admin/login.twig', $twigVars));
}
