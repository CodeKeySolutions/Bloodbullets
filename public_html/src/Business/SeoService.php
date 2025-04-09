<?PHP

namespace src\Business;

use src\Business\Logic\SeoURL;
use src\Data\SeoDAO;
 
class SeoService extends SeoURL
{
    private $data;
    
    public function __construct()
    {
        $this->data = new SeoDAO();
    }
    
    public function __destruct()
    {
        $this->data = null;
    }
    
    public function getRecordsCount()
    {
        return $this->data->getRecordsCount();
    }
    
    public static function transliterateString($txt)
    {
        $transliterationTable = array('�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', 'a' => 'a', 'A' => 'A', '�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', 'a' => 'a', 'A' => 'A', 'a' => 'a', 'A' => 'A', '�' => 'ae', '�' => 'AE', '�' => 'ae', '�' => 'AE', '?' => 'b', '?' => 'B', 'c' => 'c', 'C' => 'C', 'c' => 'c', 'C' => 'C', 'c' => 'c', 'C' => 'C', 'c' => 'c', 'C' => 'C', '�' => 'c', '�' => 'C', 'd' => 'd', 'D' => 'D', '?' => 'd', '?' => 'D', 'd' => 'd', '�' => 'D', '�' => 'dh', '�' => 'Dh', '�' => 'e', '�' => 'E', '�' => 'e', '�' => 'E', 'e' => 'e', 'E' => 'E', '�' => 'e', '�' => 'E', 'e' => 'e', 'E' => 'E', '�' => 'e', '�' => 'E', 'e' => 'e', 'E' => 'E', 'e' => 'e', 'E' => 'E', 'e' => 'e', 'E' => 'E', '?' => 'f', '?' => 'F', '�' => 'f', '�' => 'F', 'g' => 'g', 'G' => 'G', 'g' => 'g', 'G' => 'G', 'g' => 'g', 'G' => 'G', 'g' => 'g', 'G' => 'G', 'h' => 'h', 'H' => 'H', 'h' => 'h', 'H' => 'H', '�' => 'i', '�' => 'I', '�' => 'i', '�' => 'I', '�' => 'i', '�' => 'I', '�' => 'i', '�' => 'I', 'i' => 'i', 'I' => 'I', 'i' => 'i', 'I' => 'I', 'i' => 'i', 'I' => 'I', 'j' => 'j', 'J' => 'J', 'k' => 'k', 'K' => 'K', 'l' => 'l', 'L' => 'L', 'l' => 'l', 'L' => 'L', 'l' => 'l', 'L' => 'L', 'l' => 'l', 'L' => 'L', '?' => 'm', '?' => 'M', 'n' => 'n', 'N' => 'N', 'n' => 'n', 'N' => 'N', '�' => 'n', '�' => 'N', 'n' => 'n', 'N' => 'N', '�' => 'o', '�' => 'O', '�' => 'o', '�' => 'O', '�' => 'o', '�' => 'O', 'o' => 'o', 'O' => 'O', '�' => 'o', '�' => 'O', '�' => 'oe', '�' => 'OE', 'o' => 'o', 'O' => 'O', 'o' => 'o', 'O' => 'O', '�' => 'oe', '�' => 'OE', '?' => 'p', '?' => 'P', 'r' => 'r', 'R' => 'R', 'r' => 'r', 'R' => 'R', 'r' => 'r', 'R' => 'R', 's' => 's', 'S' => 'S', 's' => 's', 'S' => 'S', '�' => 's', '�' => 'S', '?' => 's', '?' => 'S', 's' => 's', 'S' => 'S', '?' => 's', '?' => 'S', '�' => 'SS', 't' => 't', 'T' => 'T', '?' => 't', '?' => 'T', 't' => 't', 'T' => 'T', '?' => 't', '?' => 'T', 't' => 't', 'T' => 'T', '�' => 'u', '�' => 'U', '�' => 'u', '�' => 'U', 'u' => 'u', 'U' => 'U', '�' => 'u', '�' => 'U', 'u' => 'u', 'U' => 'U', 'u' => 'u', 'U' => 'U', 'u' => 'u', 'U' => 'U', 'u' => 'u', 'U' => 'U', 'u' => 'u', 'U' => 'U', 'u' => 'u', 'U' => 'U', '�' => 'ue', '�' => 'UE', '?' => 'w', '?' => 'W', '?' => 'w', '?' => 'W', 'w' => 'w', 'W' => 'W', '?' => 'w', '?' => 'W', '�' => 'y', '�' => 'Y', '?' => 'y', '?' => 'Y', 'y' => 'y', 'Y' => 'Y', '�' => 'y', '�' => 'Y', 'z' => 'z', 'Z' => 'Z', '�' => 'z', '�' => 'Z', 'z' => 'z', 'Z' => 'Z', '�' => 'th', '�' => 'Th', '�' => 'u', '?' => 'a', '?' => 'a', '?' => 'b', '?' => 'b', '?' => 'v', '?' => 'v', '?' => 'g', '?' => 'g', '?' => 'd', '?' => 'd', '?' => 'e', '?' => 'E', '?' => 'e', '?' => 'E', '?' => 'zh', '?' => 'zh', '?' => 'z', '?' => 'z', '?' => 'i', '?' => 'i', '?' => 'j', '?' => 'j', '?' => 'k', '?' => 'k', '?' => 'l', '?' => 'l', '?' => 'm', '?' => 'm', '?' => 'n', '?' => 'n', '?' => 'o', '?' => 'o', '?' => 'p', '?' => 'p', '?' => 'r', '?' => 'r', '?' => 's', '?' => 's', '?' => 't', '?' => 't', '?' => 'u', '?' => 'u', '?' => 'f', '?' => 'f', '?' => 'h', '?' => 'h', '?' => 'c', '?' => 'c', '?' => 'ch', '?' => 'ch', '?' => 'sh', '?' => 'sh', '?' => 'sch', '?' => 'sch', '?' => '', '?' => '', '?' => 'y', '?' => 'y', '?' => '', '?' => '', '?' => 'e', '?' => 'e', '?' => 'ju', '?' => 'ju', '?' => 'ja', '?' => 'ja');
        return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);
    }
    
    public static function seoUrl($string)
    {
        return parent::format($string);
    }
    
    public static function deSeoUrl($string)
    {
        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", " ", $string);
        return ucfirst($string);
    }
    
    public function getSeoDataByRouteName($rn)
    {
        return $this->data->getSeoDataByRouteName($rn);
    }
}
