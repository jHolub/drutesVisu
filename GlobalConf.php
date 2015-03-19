<?php

include 'ConfigClass.php';

class GlobalConf extends ConfigClass {

    protected $arrayData;
    
    protected $model = "RE_std";
    protected $dimension = 1;
    protected $maxIteration = 20;
    protected $iteration = 0.001;
    protected $endTime = 100;
    protected $minTime = 0.1;
    protected $maxTime = 1;
    protected $numberObservationTimes = 1;
    protected $observationTime = array(array(1));
    protected $observationPoints = 1;
    protected $observationPoint = array(array(1));

    public function __construct() {
        
    }

    public function initFromForm($post) {

        $key = 0;
        $this->arrayData[$key][0] = $post['model'];

        $key++;
        $this->arrayData[$key][0] = $post['dimension'];

        $key++;
        $this->arrayData[$key][0] = $post['maxIteration'];
        
        $key++;
        $this->arrayData[$key][0] = $post['iteration'];
        
        $key++;
        $this->arrayData[$key][0] = $post['endTime'];
        
        $key++;
        $this->arrayData[$key][0] = $post['minTime'];
        
        $key++;
        $this->arrayData[$key][0] = $post['maxTime'];
 
        $key++;
        $this->arrayData[$key][0] = $post['numberObservationTimes'];        
        
        $key++;
        for ($edge = 0; $edge < $this->arrayData[7][0]; $edge ++) {
            $this->arrayData[$key][0] = $post["observationTime_" . $edge];
            $key++;
        }

        $this->arrayData[$key][0] = $post['observationPoints'];
        $observationPoints = $key;
        $key++;
        for ($edge = 0; $edge < $this->arrayData[$observationPoints][0]; $edge ++) {
            $this->arrayData[$key][0] = $post["observationPoint_" . $edge . "_0"];
            $this->arrayData[$key][1] = $post["observationPoint_" . $edge . "_1"];
            $key++;
        }
            
        $this->initGlobal();
        
    }

    public function initGlobal() {

        $this->model = $this->arrayData[0][0];
        $this->dimension = $this->arrayData[1][0];
        $this->maxIteration = $this->arrayData[2][0];
        $this->iteration = $this->arrayData[3][0]; 
        $this->endTime = $this->arrayData[4][0]; 
        $this->minTime = $this->arrayData[5][0]; 
        $this->maxTime = $this->arrayData[6][0];       
        $this->numberObservationTimes = $this->arrayData[7][0];      
// clean default value        
        $this->observationTime = array();
        for ($numIntervals = 0; $numIntervals < $this->numberObservationTimes; $numIntervals ++) {

            $this->observationTime[] = $this->arrayData[8 + $numIntervals][0];
        }

        $this->observationPoints = $this->arrayData[8 + $this->numberObservationTimes][0];
// clean default value        
        $this->observationPoint = array();
        for ($materials = 0; $materials < $this->observationPoints; $materials ++) {

            $this->observationPoint[] = $this->arrayData[9 + $this->numberObservationTimes + $materials];
        }
    }

    public function __get($name){
        
        return $this->$name;
    }
    
    public function getObservationTime($i){

        return $this->observationTime[$i];
    }

    public function getObservationPointX($i){

        return $this->observationPoint[$i][0];
    } 
    
    public function getObservationPointY($i){

        return $this->observationPoint[$i][1];
    }     
    
    public function printConf() {

        $collSeparator = "\t";

        $conf = "";

        $conf = $conf . "#model" . "\n";

        $conf = $conf . $this->model . "\n" . "\n";

        $conf = $conf . "#dimension" . "\n";

        $conf = $conf . $this->dimension . "\n" . "\n";

        $conf = $conf . "#maxIteration" . "\n";

        $conf = $conf . $this->maxIteration . "\n" . "\n";

        $conf = $conf . "#iterationCriterion" . "\n";

        $conf = $conf . $this->iteration . "\n" . "\n"; 
        
        $conf = $conf . "#endTime" . "\n";

        $conf = $conf . $this->endTime . "\n" . "\n";

        $conf = $conf . "#minTime" . "\n";

        $conf = $conf . $this->minTime . "\n" . "\n";

        $conf = $conf . "#maxTime" . "\n";

        $conf = $conf . $this->maxTime . "\n" . "\n";       

        $conf = $conf . "#numberObservationTimes" . "\n";

        $conf = $conf . $this->numberObservationTimes . "\n" . "\n";           
        
        $conf = $conf . "#observationTime" . "\n";

        for ($i = 0; $i < count($this->observationTime); $i++) {

            for ($j = 0; $j < count($this->observationTime[$i]); $j++) {

                $conf = $conf . $this->observationTime[$i][$j];

                if ($j < (count($this->observationTime[$i]) - 1)) {
                    $conf = $conf . $collSeparator;
                }
            }
            $conf = $conf . "\n";
        }
        $conf = $conf . "\n";

        $conf = $conf . "#observationPoints" . "\n";

        $conf = $conf . $this->observationPoints . "\n" . "\n";

        $conf = $conf . "#observationPoint" . "\n";

        for ($i = 0; $i < count($this->observationPoint); $i++) {
            for ($j = 0; $j < count($this->observationPoint[$i]); $j++) {

                $conf = $conf . $this->observationPoint[$i][$j];

                if ($j < (count($this->observationPoint[$i]) - 1)) {
                    $conf = $conf . $collSeparator;
                }
            }
            $conf = $conf . "\n";
        }
        return $conf;
    }

}

?>