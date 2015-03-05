<?php

class ConfigClass{
    
    
    public function __construct() {
        
    } 
    
//    DELIMITERS options : array(',', ' ', "\t", "\n"); 
    public function initFromFile($path, $delimiters = "\t") {

        if (file_exists($path) && ($handle = fopen($path, "r")) !== FALSE) {

            $row = 0;

            while (($data = fgetcsv($handle, 1000, $delimiters)) !== FALSE) {

                if ($data[0] !== NULL && $data[0][0] !== "#") {

                    for ($coll = 0; $coll < count($data); $coll++) {

                        $this->arrayData[$row][$coll] = $data[$coll];
                    }
                    $row++;
                }
            }
            fclose($handle);



            $this->initMesh();
        }
    }    
    
    public function cleanConfig($path) {

        file_put_contents($path, '');
    }

    public function saveConfig($path, $content) {

        file_put_contents($path, $content, FILE_APPEND);
    }     

    public function __get($name){
        
        return $this->$name;
    }    
}

?>