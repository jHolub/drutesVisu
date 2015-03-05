<?php

include 'ConfigClass.php';

class WaterConf extends ConfigClass {

    private $arrayData;
      
    protected $layers = 1;
    protected $param1 = array(array(0.01,2.5,0.8,0.064,0.14,0.1));
    protected $param2 = array(array(0,10.0,10.0,10.0));
    protected $param3 = -200;    
    protected $boundaries = 1;
    protected $observationPoint = array(array(101,2,false,2.0,1));

    public function __construct() {
        
    }

    public function initFromForm($post) {

        $key = 0;
        $this->arrayData[$key][0] = $post['layers'];

        $key++;
        for ($edge = 0; $edge < $this->arrayData[0][0]; $edge ++) {
            $this->arrayData[$key][0] = $post["layers_" . $edge . "_0"];
            $this->arrayData[$key][1] = $post["layers_" . $edge . "_1"];
            $this->arrayData[$key][2] = $post["layers_" . $edge . "_2"];
            $key++;
        }

        $this->arrayData[$key][0] = $post['numberMaterials'];
        $materialsKey = $key;
        $key++;
        for ($edge = 0; $edge < $this->arrayData[$materialsKey][0]; $edge ++) {
            $this->arrayData[$key][0] = $post["materials_" . $edge . "_0"];
            $this->arrayData[$key][1] = $post["materials_" . $edge . "_1"];
            $this->arrayData[$key][2] = $post["materials_" . $edge . "_2"];
            $key++;
        }
        $this->initMesh();
    }

    private function initMesh() {

        $this->layers = $this->arrayData[0][0];
// clean default value        
        $this->layers = array();
        for ($numIntervals = 0; $numIntervals < $this->intervals; $numIntervals ++) {

            $this->layers[] = $this->arrayData[2 + $numIntervals];
        }

        $this->numberMaterials = $this->arrayData[2 + $this->intervals][0];
// clean default value        
        $this->materials = array();
        for ($materials = 0; $materials < $this->numberMaterials; $materials ++) {

            $this->materials[] = $this->arrayData[3 + $this->intervals + $materials];
        }
    }

    public function __get(){

    }

    public function printMeshConf() {

        $collSeparator = "\t";

        $conf = "";    

        $conf = $conf . "numberObservationTimes" . "\n";

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