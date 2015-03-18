<?php

include 'ConfigClass.php';

class WaterConf extends ConfigClass {

    protected $arrayData;
      
    protected $layers = 1;
    protected $param1 = array(array(0.01,2.5,0.8,0.064,0.14,0.1));
    protected $param2 = array(array(0,10.0,10.0,10.0));
    protected $param3 = -200;    
    protected $boundaries = 1;
    protected $boundary = array(array(101,2,"n",2.0,1));

    public function __construct() {
        
    }

    public function initFromForm($post) {

        $key = 0;
        $this->arrayData[$key][0] = $post['layers'];

        $key++;
        for ($edge = 0; $edge < $this->arrayData[0][0]; $edge ++) {
            $this->arrayData[$key][0] = $post["param1_" . $edge . "_0"];
            $this->arrayData[$key][1] = $post["param1_" . $edge . "_1"];
            $this->arrayData[$key][2] = $post["param1_" . $edge . "_2"];
            $this->arrayData[$key][3] = $post["param1_" . $edge . "_3"];
            $this->arrayData[$key][4] = $post["param1_" . $edge . "_4"];
            $this->arrayData[$key][5] = $post["param1_" . $edge . "_5"];            
            $key++;
        }
        
        for ($edge = 0; $edge < $this->arrayData[0][0]; $edge ++) {
            $this->arrayData[$key][0] = $post["param2_" . $edge . "_0"];
            $this->arrayData[$key][1] = $post["param2_" . $edge . "_1"];
            $this->arrayData[$key][2] = $post["param2_" . $edge . "_2"];
            $this->arrayData[$key][3] = $post["param2_" . $edge . "_3"];           
            $key++;
        }
        
        for ($edge = 0; $edge < $this->arrayData[0][0]; $edge ++) {
            $this->arrayData[$key][0] = $post['param3_' . $edge];
            $key++;
        }
        
        $this->arrayData[$key][0] = $post['boundaries'];        
        $boundaries = $key;
        $key++;
        for ($edge = 0; $edge < $this->arrayData[$boundaries][0]; $edge ++) {
            $this->arrayData[$key][0] = $post["boundary_" . $edge . "_0"];
            $this->arrayData[$key][1] = $post["boundary_" . $edge . "_1"];
            
            if($post["boundary_" . $edge . "_2"] == "n"){
                $this->arrayData[$key][2] = "n";
            }else{
                $this->arrayData[$key][2] = "y";
            }
            
            $this->arrayData[$key][3] = $post["boundary_" . $edge . "_3"];
            $this->arrayData[$key][4] = $post["boundary_" . $edge . "_4"];            
            $key++;
        }
        $this->initWater();
    }

    public function initWater() {

        $key = 0;
        $this->layers = $this->arrayData[$key][0];
        $key++;
// clean default value        
        $this->param1 = array();
        for ($num = 0; $num < $this->layers; $num ++) {

            $this->param1[] = $this->arrayData[$key];
            $key++;
        }
        
        $this->param2 = array();     
        for ($num = 0; $num < $this->layers; $num ++) {

            $this->param2[] = $this->arrayData[$key];
            $key++;
        }
        
        $this->param3 = array();
        for ($num = 0; $num < $this->layers; $num ++) {
            
            $this->param3[] = $this->arrayData[$key];
            $key++;
        }
        
        $this->boundaries = $this->arrayData[$key][0];
        $key++;
// clean default value        
        $this->boundary = array();
        for ($bound = 0; $bound < $this->boundaries; $bound ++) {

            $this->boundary[] = $this->arrayData[$key];
            $key++;
        }
    }

    public function __get($name){

        return $this->$name;
    }
    
    public function getParam1($order,$t){
        
        return $this->param1[$order][$t];
    }
    
    public function getParam2($order,$t){
        
        return $this->param2[$order][$t];
    }

    public function getBoundary($order,$t){
    
        return $this->boundary[$order][$t];    
    }
    
    public function getParam3($i){
        
        return $this->param3[$i][0];
    }
    
    public function printConf() {

        $collSeparator = "\t";

        $conf = "";    

        $conf = $conf . "#layers" . "\n";

        $conf = $conf . $this->layers . "\n" . "\n";           
        
        $conf = $conf . "#param1" . "\n";

        for ($i = 0; $i < count($this->param1); $i++) {

            for ($j = 0; $j < count($this->param1[$i]); $j++) {

                $conf = $conf . $this->param1[$i][$j];

                if ($j < (count($this->param1[$i]) - 1)) {
                    $conf = $conf . $collSeparator;
                }
            }
            $conf = $conf . "\n";
        }
        $conf = $conf . "\n";

        for ($i = 0; $i < count($this->param2); $i++) {

            for ($j = 0; $j < count($this->param2[$i]); $j++) {

                $conf = $conf . $this->param2[$i][$j];

                if ($j < (count($this->param2[$i]) - 1)) {
                    $conf = $conf . $collSeparator;
                }
            }
            $conf = $conf . "\n";
        }        
        
        $conf = $conf . "\n";
        
        $conf = $conf . "#param3" . "\n";

        for ($i = 0; $i < count($this->param3); $i++) {

            for ($j = 0; $j < count($this->param3[$i]); $j++) {

                $conf = $conf . $this->param3[$i][$j];

                if ($j < (count($this->param3[$i]) - 1)) {
                    $conf = $conf . $collSeparator;
                }
            }
            $conf = $conf . "\n";
        }

        $conf = $conf . "#boundaries" . "\n";
        
        $conf = $conf . $this->boundaries . "\n" . "\n";
        
        $conf = $conf . "#boundary" . "\n";        

        for ($i = 0; $i < count($this->boundary); $i++) {
            for ($j = 0; $j < count($this->boundary[$i]); $j++) {

                $conf = $conf . $this->boundary[$i][$j];

                if ($j < (count($this->boundary[$i]) - 1)) {
                    $conf = $conf . $collSeparator;
                }
            }
            $conf = $conf . "\n";
        }
        return $conf;
    }

}

?>