<?php 
/**
 * ============================== 
 * Aegis Framework | MIT License
 * http://www.aegisframework.com/
 * ==============================
 */
class Text {

	function __construct(){
	
    }
    
    public function capitalize($text){
	  return  ucwords(strtolower($text));
    }	 		
	
	public function checkSimilarity($text1,$text2){
	  similar_text($text1, $text2, $percent);
	  return  $percent;
    }
	
	public function findText(){
		
	}
 
    public function getSuffix($text,$key){
        $suffix = "";
        $position = strrpos($text,$key);
        if($position !== false){
            $position+= strlen($key);
            $suffix = substr($text,$position, strlen($text) - $position);
        }
        return $suffix;
    }
    public function getPreffix($text,$key){
        $prefix = "";
        $position = strrpos($text,$key);
        if($position !== false){
            $prefix = substr($text,0,$position);
        }
        return $prefix;
    }
    
    public function getAffixes($text,$key){
        return [$this->getPrefix($string,$key), $this->getSuffix($string,$key)];
    }
    
    public function getStringBetween($string, $start, $end){
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }
}

?>