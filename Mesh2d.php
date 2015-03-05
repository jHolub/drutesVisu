<?php

include 'ConfigClass.php';

class Mesh2D extends ConfigClass {

    private $arrayData;
// DEFAULT VALUE    
    protected $xCoor = 100;
    protected $yCoor = 100;
    protected $density = 1;
    protected $numberEdge = 1;
    protected $coordinates = array(array(0,100),array(100,100));
    
    public function __construct() {
   
    }
    
    public function initFromForm($post) {
    
        $this->arrayData[0][0] = $post['xCoor'];
        $this->arrayData[1][0] = $post['yCoor'];
        $this->arrayData[2][0] = $post['density'];         
        $this->arrayData[3][0] = $post['numberEdge'];   
        
        $key = 0;
        for ($edge = 1; $edge <= $this->arrayData[3][0]; $edge ++) {            
            $key ++;            
            $this->arrayData[3 + $key][0] = $post["coordinates_".$edge."_1"];
            $this->arrayData[3 + $key][1] = $post["coordinates_".$edge."_2"];
            $key ++;
            $this->arrayData[3 + $key][0] = $post["coordinates_".$edge."_3"];
            $this->arrayData[3 + $key][1] = $post["coordinates_".$edge."_4"];            
        }
        
        $this->initMesh2D();
    }

    private function initMesh2D() {

        $this->xCoor = $this->arrayData[0][0];
        $this->yCoor = $this->arrayData[1][0];
        $this->density = $this->arrayData[2][0];
        $this->numberEdge = $this->arrayData[3][0];
// clean default value        
        $this->coordinates = array();
        for ($edge = 1; $edge <= $this->numberEdge * 2; $edge ++) {

            $this->coordinates[] = $this->arrayData[3 + $edge];
        }
    }

    public function getXCoor() {

        return $this->xCoor;
    }

    public function getYCoor() {

        return $this->yCoor;
    }

    public function getDensity() {

        return $this->density;
    }

    public function getNumberEdge() {

        return $this->numberEdge;
    }

    public function getCoordinates($edge, $key) {

        $edge = ($edge * 2) - 1;        
        
        if($key == 0 || $key == 1){
            return $this->coordinates[$edge - 1][$key];
        }else{
            return $this->coordinates[$edge][$key % 2];    
        }
    }

    public function printMesh2DConf() {

        $collSeparator = "\t";

        $conf = "";

        $conf = $conf . "#xCoor" . "\n";

        $conf = $conf . $this->xCoor . "\n" . "\n";

        $conf = $conf . "#yCoor" . "\n";

        $conf = $conf . $this->yCoor . "\n" . "\n";

        $conf = $conf . "#density" . "\n";

        $conf = $conf . $this->density . "\n" . "\n";

        $conf = $conf . "#edges" . "\n";

        $conf = $conf . $this->numberEdge . "\n" . "\n";

        $conf = $conf . "#coordinates X  Y" . "\n";

        for ($i = 0; $i < count($this->coordinates); $i++) {

            for ($j = 0; $j < count($this->coordinates[$i]); $j++) {

                $conf = $conf . $this->coordinates[$i][$j];

                if ($j < (count($this->coordinates[$i]) - 1)) {
                    $conf = $conf . $collSeparator;
                }
            }
            $conf = $conf . "\n";
        }
        $conf = $conf . "\n";
        return $conf;
    }

}
?>