<?PHP

namespace src\Business;

use src\Entities\PlayerGuards;
use stdClass;

// use src\Data\NotificationDAO;

class PlayerGuardService
{
    private $data;

    public function __construct()
    {
      self::initGuards();
    }
    private function createFollower(int $id, int $attack, int $defense, string $name) : PlayerGuards
    {
        $follower = new PlayerGuards();
        $follower->setId($id);
        $follower->setAttack($attack);
        $follower->setDefense($defense);
        $follower->setName($name);
        return $follower;
    }

    public function initGuards() : array
    {
        $followers = array();
        $followers[] = self::createFollower(1, 10, 20, "Follower 1");
        $followers[] = self::createFollower(2, 20, 30, "Follower 2");
        $this->data = $followers;
        return $followers;
    }

    public function getFollowerById(int $id) : PlayerGuards | false
    {

        foreach($this->data as $follower)
        {
            if($follower->getId() == $id)
            {
                return $follower;
            }
        }
        return false;
    }


}