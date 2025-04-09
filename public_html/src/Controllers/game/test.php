<?PHP

use src\Business\UserService;
use src\Business\ResidenceService;

use src\Business\PlayerGuardService;

require_once __DIR__ . '/.inc.head.php';

$guards = new PlayerGuardService();




require_once __DIR__ . '/.inc.foot.php';

// $twigVars['langs'] = array_merge($twigVars['langs'], $language->statusLangs()); // Extend base langs

$twigVars['guards'] = $guards->initGuards();

print_r($twig->render('/src/Views/game/test.twig', $twigVars));