<?php

class Parser {

    private $source;
    private $arrayData;

    public function __construct($source) {

        $this->source = $source;
    }

    public function init($delimiters = "\t") {

        if (file_exists($this->source) && ($handle = fopen($this->source, "r")) !== FALSE) {

            $row = 0;

            while (($data = fgetcsv($handle, 1000, $delimiters)) !== FALSE) {

                if ($data[0] !== NULL && $data[0] !== "" && $data[0][0] !== "#") {

                    for ($coll = 0; $coll < count($data); $coll++) {

                        $this->arrayData[$row][$coll] = (float) $data[$coll];
                    }
                    $row++;
                }
            }
            fclose($handle);
        }
    }

    public function getArray() {

        return $this->arrayData;
    }

    public function printHtmlTable() {

        foreach ($this->arrayData as $rows => $row) {
            echo "<table border='1'><tr>";
            foreach ($row as $col => $cell) {
                echo "<td>" . str_replace(".", ",", $cell) . "</td>";
            }
            echo "</tr></table>";
        }
    }

    public function getArrayJS($coll, $start = 0) {
        
        $js = "";
        for ($i = $start; $i < count($this->arrayData); $i++) {
            
            $js.= $this->arrayData[$i][$coll] . ",";
        }
        
        return substr_replace($js, "", -1);
    }

    public function getNameColumn() {
        
    }

    public function setNameColumn() {
        
    }

}

?>