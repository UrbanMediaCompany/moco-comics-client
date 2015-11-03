<?php 


class Updater{

    function __construct($version, $version_num, $url){
        $this->url = $url;
        $this->current_version = $version;
        $this->current_version_number = $version_num;
    }
    
    private function getData(){
        $json = file_get_contents($this->url);
        $obj = json_decode($json);
        return json_decode(json_encode($obj),true);
    }
    
    public function checkUpdates(){
        $data = $this->getData();
        $update=array();
        foreach($data as $i){
            if(intval($i["VersionNumber"])> intval($this->current_version_number)){
                $update = $i;
            }
        }
        if(count($update)>0){
            return $update;  
        }else{
            return false;   
        }
    }
    
    public function install(){
        $data= $this->checkUpdates();
        if(!is_writable(__DIR__."/../../")) {
			return false;
		}
        
        if(copy($data["File"],$data["FileName"])){
            if($data["Hash"]==md5_file($data["FileName"])){
                $zip = new ZipArchive;
                if($zip->open($data["FileName"]) === true){
                    $zip->extractTo(__DIR__."/../../");
                    $zip->close();
                    unlink($data["FileName"]);
                    return true;
                }else{
                    return false;   
                }
            }else{
                return false;   
            }
            
        }else{
            return false;
        }   
    }
    
}
?>