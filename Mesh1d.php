<?php


include 'ConfigClass.php';

class Mesh1D extends ConfigClass{

    protected $arrayData;
    
    protected $information = "text";
    protected $intervals = 1;
    protected $layers = array(array(1, 1, 1));
    protected $numberMaterials = 1;
    protected $materials = array(array(1, 1, 1));
 
    public function __construct() {
        
    }

    public function initFromForm($post) {

        $key = 0;
        $this->arrayData[$key][0] = $post['information'];
        
        $key++;
        $this->arrayData[$key][0] = $post['intervals'];
        
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

    function initMesh() {

        $this->information = $this->arrayData[0][0];
        $this->intervals = $this->arrayData[1][0];
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

    public function getIntervals() {

        return $this->intervals;
    }

    public function getLayers($interval, $coll) {

        return $this->layers[$interval][$coll];
    }

    public function getNumberMatarials() {

        return $this->numberMaterials;
    }

    public function getMaterials($materials, $coll) {

        return $this->materials[$materials][$coll];
    }
    
    public function printMeshConf() {

        $collSeparator = "\t";

        $conf = "";

        $conf = $conf . "#information" . "\n";

        $conf = $conf . $this->information . "\n" . "\n";

        $conf = $conf . "#mumber intervals" . "\n";

        $conf = $conf . $this->intervals . "\n" . "\n";

        $conf = $conf . "#layers" . "\n";

        for ($i = 0; $i < count($this->layers); $i++) {

            for ($j = 0; $j < count($this->layers[$i]); $j++) {

                $conf = $conf . $this->layers[$i][$j];

                if ($j < (count($this->layers[$i]) - 1)) {
                    $conf = $conf . $collSeparator;
                }
            }
            $conf = $conf . "\n";
        }
        $conf = $conf . "\n";

        $conf = $conf . "#number materials" . "\n";

        $conf = $conf . $this->numberMaterials . "\n" . "\n";

        $conf = $conf . "#materials" . "\n";

        for ($i = 0; $i < count($this->materials); $i++) {
            for ($j = 0; $j < count($this->materials[$i]); $j++) {

                $conf = $conf . $this->materials[$i][$j];

                if ($j < (count($this->materials[$i]) - 1)) {
                    $conf = $conf . $collSeparator;
                }
            }
            $conf = $conf . "\n";
        }
        return $conf;
    }

}

?>