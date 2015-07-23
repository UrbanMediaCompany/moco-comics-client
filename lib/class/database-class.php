<?php   
      class Database {
        protected $pdo;
        private $host;
        private $pass;
        private $user;
        private $database;
        
        function __construct($user, $pass, $database,$host = "localhost"){
            $this->host = $host;
            $this->user = $user;
            $this->pass = $pass;
            $this->database = $database;
            $this->connect();
        }
        
        public function getPdo(){
            return $this->pdo;
        }
        
        protected function connect(){
            try{
                $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->database;charset=utf8", $this->user, $this->pass);
            } catch(PDOException $e) {
                die();
            }
        }
        
        public function query($query){
	        if($sth=$this->pdo->prepare($query)){
		       if($sth->execute()){
			       return $sth;
		       }else{
			       return false;
		       }
	        }else{
		        return false;
	        }
         }
         
         
		public function select($key,$table,$keyname){
			if($sth=$this->pdo->prepare("SELECT * FROM `$table` WHERE `$keyname` = ?")){
			$sth->execute(array($key));
			$result=$sth->fetch(PDO::FETCH_ASSOC);
			return $result;
			}
		}
         
        public function selectAllFrom($table){
            if($sth=$this->pdo->prepare("SELECT * FROM `$table`")){
                $sth->execute();
                $result=$sth->fetchAll(PDO::FETCH_ASSOC);
				
				return $result;
            }
        }
         
        public function exists($keyname,$table,$key){
            if($sth=$this->pdo->prepare("SELECT $keyname FROM $table WHERE $keyname = ?")){
                 $sth->execute(array($key));
                 if($sth->rowCount()>0){
                     return true;
                 }else{
                     return false;
                 }
            }
        }
         /**
          * Delete a Database Entry.
          * 
          * @access public
          * @param mixed $table - Table Name
          * @param mixed $key - Value Key
          * @param mixed $value - Value
          * @param mixed $type - Data type
          * @return void
          */
        public function delete($table,$keyname,$key){
            if($sth=$this->pdo->prepare("DELETE FROM $table WHERE $keyname=?")){
               $sth->execute(array($key));
            }
        }
        
        public function backup($dir="backup"){
	        $fopen = fopen("$dir/backup_".date('Y-m-d_h_i_s') . '.sql', 'w');
	        
	        fwrite($fopen,"-- Aegis Database Backup \n");
	        fwrite($fopen,"-- Server version:".mysql_get_server_info()."\n");
	        fwrite($fopen,"-- Generated: ".date('Y-m-d h:i:s')."\n");
	        fwrite($fopen,'-- Current PHP version: '.phpversion()."\n");
	        fwrite($fopen,'-- Database:'.$this->database."\n");
	        
	        $Tables = array();
			$data=$this->query("SHOW TABLES"); 
			
			while($row = $data->fetch()) {
            	$Tables[] = $row[0];
   			}
			
			foreach($Tables as $Table){
				fwrite($fopen,"-- ============================== \n");
				fwrite($fopen,"-- Structure for $Table\n");
				fwrite($fopen,"-- ============================== \n\n");
				
				fwrite($fopen,'DROP TABLE IF EXISTS '.$Table.';');
				
				if(!$create= $this->query("SHOW CREATE TABLE $Table")){
					return false;
				}
                	
				$row_create = $create->fetch(PDO::FETCH_ASSOC);
				
				fwrite($fopen,"\n".$row_create['Create Table'].";\n");
				
				fwrite($fopen,"-- ============================== \n");
	            fwrite($fopen,"-- Dump Data for `$Table`\n");
	            fwrite($fopen,"-- ============================== \n\n");
	            
	            if(!$res_select = $this->query("SELECT * FROM $Table")){
		            return false;
	            }
	            
	            $fields_info = $res_select->fetch(PDO::FETCH_OBJ);
	            while ($values = $res_select->fetch(PDO::FETCH_ASSOC)){

	                $Fields = '';
	                $Values = '';
	                foreach ($fields_info as $name =>$field) {
	                    if ($Fields != ''){
		                	$Fields .= ',';    
	                    } 
	                    $Fields .= "`$name`";
	                    
	                    if(strtolower($name)=="id"){
		                    $field=0;
	                    }
	
	                    if($Values != ''){
		                	$Values .= ',';
	                    } 
	                    
	                    $Values .= "'".preg_replace('/[^(\x20-\x7F)\x0A]*/','',str_replace("'","''",$field)."'");
	                    
	                }
	
	                fwrite($fopen,"INSERT INTO $Table ($Fields) VALUES ($Values);\n");
	            }
	            fwrite($fopen,"\n\n\n");

			}
			fclose($fopen);
        }
        
        public function restore($file){
	        $data=file_get_contents($file);
	        if($this->query($data)){
		        return true;
	        }
	        return false;
        }
          
        public function selectAllByDate($table,$date){
             if($sth=$this->pdo->prepare("SELECT * FROM `$table` ORDER BY DATE(`$date`) ASC")){
                $sth->execute();
                $result=$sth->fetchAll(PDO::FETCH_ASSOC);
				return $result;
            }
         }
          
        
        
        function __destruct() {
            $this->pdo=null;
            
        }
        
    }
    
?>