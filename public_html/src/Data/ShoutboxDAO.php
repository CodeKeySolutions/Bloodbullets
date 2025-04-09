<?PHP

namespace src\Data;

use src\Business\ShoutboxService;
use src\Business\SeoService;
use src\Data\config\DBConfig;
use src\Entities\Shoutbox;

class ShoutboxDAO extends DBConfig
{
    protected $con = "";
    private $dbh = "";
    private $lang = "en";
    private $dateFormat = "%d-%m-%y %H:%i:%s";

    public $familyID = 0;

    public function __construct()
    {
        global $lang;
        global $connection;

        $this->con = $connection;
        $this->dbh = $connection->con;
        $this->lang = $lang;
        if($this->lang == 'en') $this->dateFormat = "%m-%d-%y %r";
    }

    public function __destruct()
    {
        $this->dbh = null;
    }

    public function getRecordsCount()
    {
        if(isset($_SESSION['UID']))
        {
            $statement = $this->dbh->prepare("SELECT COUNT(*) AS `total` FROM `shoutbox_".$this->lang."` WHERE `deleted` = 0 AND `familyID` = :famID ORDER BY `date` DESC");
            $statement->execute(array(':famID' => $this->familyID));
            $row = $statement->fetch();
            return $row['total'];
        }
    }

    public function getLastMessageID()
    {
        if(isset($_SESSION['UID']))
        {
            $row = $this->con->getDataSR("SELECT `id` FROM `shoutbox_".$this->lang."` WHERE `familyID`= :famID AND `deleted`='0' ORDER BY `date` DESC LIMIT 1", array(':famID' => $this->familyID));
            if(isset($row['id']) && $row['id'] > 0)
                return $row['id'];
        }
        return 0;
    }

    public function getMessageRows($from, $to)
    {
        if(isset($_SESSION['UID']) && is_int($from) && is_int($to) && $to <= 50 && $to >=1)
        {
            $statement = $this->dbh->prepare("
                SELECT s.`id`, s.`message`,s.`type`, s.`userID`,u.`userStyle`, u.`username`,u.`avatar`,u.`statusID`,u.donatorID, st.`status_".$this->lang."` AS `status`, d.`donator_".$this->lang."` AS `donator`,
                DATE_FORMAT( s.`date`, '".$this->dateFormat."' ) AS `when`
                FROM `shoutbox_".$this->lang."` AS s
                LEFT JOIN `user` AS u
                ON (s.userID=u.id)
                LEFT JOIN `status` AS st
                ON (u.statusID=st.id)
                LEFT JOIN `donator` AS d
                ON (u.donatorID=d.id)
                WHERE s.`deleted`='0'
                AND s.`familyID`= :famID
                ORDER BY s.`date` DESC
                LIMIT $from,$to
            ");
            $statement->execute(array(':famID' => $this->familyID));
            $list = array();
            $i = 1;
            while($row = $statement->fetch())
            {
                if($row['statusID'] < 7 || $row['statusID'] == 8)
                {
                    $className = SeoService::seoUrl($row['status']);
                }
                else
                {
                    $className = SeoService::seoUrl($row['donator']);
                }
                $shoutbox = new Shoutbox();
                $shoutbox->setId($row['id']);
                $shoutbox->setUserID($row['userID']);
                $shoutbox->setUsername($row['username']);
                $shoutbox->setUsernameClassName($className);
                $shoutbox->setDonatorID($row['donatorID']);
                $shoutbox->setAvatar(FALSE);
                $shoutbox->setType($row['type']);
                $shoutbox->setUserStyle($row['userStyle']);
                if(file_exists(DOC_ROOT . '/web/public/images/users/'.$row['userID'].'/uploads/'.$row['avatar'])) $shoutbox->setAvatar($row['avatar']);
                if($row['type'] == 1) $shoutbox->setAvatar(DOC_ROOT. '/web/public/images/favicon/apple-icon-60x60.png');
                // if($shoutbox->getType() == 1) $shoutbox->setAvatar(DOC_ROOT. '/web/public/images/favicon/apple-icon-60x60.png');
                $shoutbox->setMessage(ShoutboxService::parseMessage($row['message']));
                $shoutbox->setDate($row['when']);

                array_push($list, $shoutbox);

                if($i == 1)
                {
                    if($this->familyID != 0)
                        $field = "`lrfsID_".$this->lang."`";
                    else
                        $field = "`lrsID_".$this->lang."`";

                    $this->con->setData("
                        UPDATE `user` SET " . $field . "= :id WHERE `id`= :uid AND " . $field . "< :id AND `active`='1' AND `deleted`='0'
                    ", array(':id' => $shoutbox->getId(), ':uid' => $_SESSION['UID']));
                }
                $i++;
            }
            return $list;
        }
    }

    public function getMessageRowsIds($from, $to)
    {
        if(isset($_SESSION['UID']) && is_int($from) && is_int($to) && $to <= 50 && $to >=1)
        {
            $statement = $this->dbh->prepare("
                SELECT `id` FROM `shoutbox_".$this->lang."` WHERE `deleted`='0' AND `familyID`= :famID ORDER BY `date` DESC LIMIT $from, $to
            ");
            $statement->execute(array(':famID' => $this->familyID));
            $list = array();
            while($row = $statement->fetch())
            {
                $shoutbox = new Shoutbox();
                $shoutbox->setId($row['id']);

                array_push($list, $shoutbox);
            }
            return $list;
        }
    }

    public function checkLastShoutMessageSender($famID)
    {
        if(isset($_SESSION['UID']))
        {
            $statement = $this->dbh->prepare("SELECT `userID` FROM `shoutbox_".$this->lang."` WHERE `familyID`=:fid AND `deleted`='0' ORDER BY `date` DESC LIMIT 3");
            $statement->execute(array(':fid' => $famID));
            $msgCount = 0;
            while($row = $statement->fetch())
            {
                if($row['userID'] == $_SESSION['UID']) $msgCount++;
            }
            if($msgCount == 3)
            {
                return $_SESSION['UID'];
            }
        }
        return null;
    }

    public function postMessage($famID,$message, int $type = 0) : void
    {
        if(!isset($_SESSION['UID'])) return;

            if($type == 1){
                $statement = $this->dbh->prepare("INSERT INTO `shoutbox_nl` (`userID`,`familyID`,`message`,`date`, `type`) VALUES (:uid,:fid,:msg,:date, :type)");
                $statement->execute(array(':uid' => 0, ':fid' => $famID, ':msg' => $message, ':date' => date('Y-m-d H:i:s'), ':type' => $type));
                $statement = $this->dbh->prepare("INSERT INTO `shoutbox_en` (`userID`,`familyID`,`message`,`date`, `type`) VALUES (:uid,:fid,:msg,:date, :type)");
                $statement->execute(array(':uid' => 0, ':fid' => $famID, ':msg' => $message, ':date' => date('Y-m-d H:i:s'), ':type' => $type));
            }
            else{
                $statement = $this->dbh->prepare("INSERT INTO `shoutbox_".$this->lang."` (`userID`,`familyID`,`message`,`date`, `type`) VALUES (:uid,:fid,:msg,:date, :type)");
                $statement->execute(array(':uid' => $_SESSION['UID'], ':fid' => $famID, ':msg' => $message, ':date' => date('Y-m-d H:i:s'), ':type' => $type));
            }


    }

    public function reportMessage($reportID) : void
    {
        if(!isset($_SESSION['UID'])) return;
        if( $reportID <= 0 ) return;
        if(isset($_SESSION['reported'])){
            if($_SESSION['reported'] == $reportID)
                return;
        }

        // exit($this->lang);
        $statement = $this->dbh->prepare("UPDATE `shoutbox_".$this->lang."` SET `reports` = `reports` + 1 WHERE `userID` != ? AND `id` = ? AND `active` = 1 AND `deleted` = 0");
        $statement->execute(array($_SESSION['UID'], $reportID));
        $_SESSION['reported'] = $reportID;
    }

    public function muteUserById($userId)
    {
        if(!isset($_SESSION['UID'])) return;
        $stmt = $this->dbh->prepare("UPDATE `user` SET `chatMute` =DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE `id` = :userID ");
        $stmt->execute(array(":userID" => $userId));
    }

    public function deleteMessageById($messageId)
    {
        if(!isset($_SESSION['UID'])) return;
        if($messageId <= 0 ) return;
        $stmt = $this->dbh->prepare("UPDATE `shoutbox_".$this->lang."` SET `active` = 0, `deleted` = 1 WHERE `id` = :messageID AND `active` = 1");
        $stmt->execute(array(":messageID"=>$messageId));
    }

    public function isUserMuted($userId)
    {
        if(!isset($_SESSION['UID'])) return;
        if($userId <= 0 ) return;
        $stmt = $this->dbh->prepare("SELECT `chatMute` FROM `user` WHERE `id` = ? AND `chatMute` >= NOW() AND `active` = 1");
        $stmt->execute(array($userId));
        $result = $stmt->fetch();
        return (!$result) ? FALSE : TRUE;
    }
}
