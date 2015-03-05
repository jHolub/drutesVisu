<?php

include 'ConfigClass.php';

class GlobalConf extends ConfigClass {

    protected $arrayData;
    
    protected $model = "RE_std";
    protected $dimension = 1;
    protected $maxIteration = 20;
    protected $iterationCriterion = 0.001;
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
        for ($edge = 0; $edge < $this->arrayData[1][0]; $edge ++) {
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

        $this->model = $this->arrayData[0][0];
        $this->dimension = $this->arrayData[1][0];
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

        $conf = $conf . "#model" . "\n";

        $conf = $conf . $this->model . "\n" . "\n";

        $conf = $conf . "#dimension" . "\n";

        $conf = $conf . $this->dimension . "\n" . "\n";

        $conf = $conf . "#maxIteration" . "\n";

        $conf = $conf . $this->maxIteration . "\n" . "\n";

        $conf = $conf . "iterationCriterion" . "\n";

        $conf = $conf . $this->iterationCriterion . "\n" . "\n"; 
        
        $conf = $conf . "#endTime" . "\n";

        $conf = $conf . $this->endTime . "\n" . "\n";

        $conf = $conf . "#minTime" . "\n";

        $conf = $conf . $this->minTime . "\n" . "\n";

        $conf = $conf . "maxTime" . "\n";

        $conf = $conf . $this->maxTime . "\n" . "\n";       

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