<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./css/bootstrap3_3_2/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="./js/jqplot/jquery.jqplot.min.css" />
        <script src="./js/jquery/jquery-1.11.1.min.js"></script>    

    </head>
    <body>
        <?php
        include('Mesh2D.php');

        if ($_POST) {

            $mssubmit = new Mesh2D();

            $mssubmit->initFromForm($_POST);
            $record = $mssubmit->printConf();
            $mssubmit->cleanConfig(__DIR__ . "/conf2d.TXT");
            $mssubmit->saveConfig(__DIR__ . "/conf2d.TXT", $record, FILE_APPEND);
        }

        $ms = new Mesh2D();

        $ms->initFromFile(__DIR__ . "/conf2d.TXT");

        $ms->initMesh2D();
        ?>

        <a href="">refresh</a>

        <form action="" method="post">
            <div style="width: 900px;">

                <div class="row">
                    <div class="col-sm-4"> 

                        <div class="form-group">
                            <label for="xCoor">if yes fill in width [x-coordinate]</label>     
                            <input class="form-control" id="xCoor" type="number" name="xCoor" value="<?php echo $ms->getXCoor(); ?>">
                        </div>
                    </div>           
                    <div class="col-sm-4">             
                        <div class="form-group">
                            <label for="yCoor">length [z-coordinate]</label>          
                            <input class="form-control" id="yCoor" type="number" name="yCoor" value="<?php echo $ms->getYCoor(); ?>">
                        </div> 
                    </div>
                    <div class="col-sm-4">      
                        <div class="form-group">
                            <label for="density">density</label>     
                            <input class="form-control" id="density" type="number" name="density" value="<?php echo $ms->getDensity(); ?>">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-4"> 
                        <div class="form-group">
                            <label for="numberEdge">density</label>
                            <input class="form-control" onchange="setCoordinates(this.value);" id="numberEdge" type="number" name="numberEdge" value="<?php echo $ms->getNumberEdge(); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3"> 
                        X 
                    </div>
                    <div class="col-sm-3"> 
                        Y
                    </div>
                    <div class="col-sm-3"> 
                        X 
                    </div>
                    <div class="col-sm-3"> 
                        Y
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-sm-12"> 
                        <div id="coordinatesContainer" class="form-inline">

                            <?php for ($i = 1; $i <= $ms->getNumberEdge(); $i++): ?>
                                <div class="form-group">
                                    <label><?php echo $i; ?>. </label>
                                    <input class="form-control short" id="coordinates_<?php echo $i; ?>_1" type="number" name="coordinates_<?php echo $i; ?>_1" value="<?php echo $ms->getCoordinates($i, 0); ?>">
                                    <input class="form-control" id="coordinates_<?php echo $i; ?>_2"  type="number" name="coordinates_<?php echo $i; ?>_2" value="<?php echo $ms->getCoordinates($i, 1); ?>">
                                    <input class="form-control" id="coordinates_<?php echo $i; ?>_3" type="number" name="coordinates_<?php echo $i; ?>_3" value="<?php echo $ms->getCoordinates($i, 2); ?>">
                                    <input class="form-control" id="coordinates_<?php echo $i; ?>_4"  type="number" name="coordinates_<?php echo $i; ?>_4" value="<?php echo $ms->getCoordinates($i, 3); ?>">                                
                                </div>
                            <?php endfor; ?>

                        </div>
                    </div>
                </div>
                <br>
                
                <div class="row"> 
                    <div class="col-sm-4">
                        <input type="submit" value="SAVE" class="btn btn-default">
                    </div>
                    <div class="col-sm-4"></div>
                </div>

            </div>
        </form>

        <script>

            function setCoordinates(num) {

                feildCont = new Array();
                for (i = 1; i <= num; i++) {
                    fieldset = document.createElement("div");
                    fieldset.className = "form-group";
                    legend = document.createElement("label");
                    legend.innerHTML = i + ". ";
                    fieldset.appendChild(legend);
                    controls = new Array();
                    for (j = 1; j < 5; j++) {
                        control = document.createElement("input");
                        if (document.getElementById('coordinates_' + i + "_" + j)) {
                            control.value = document.getElementById('coordinates_' + i + "_" + j).value;
                        }
                        control.id = 'coordinates_' + i + "_" + j;
                        control.type = "number";
                        control.className = "form-control";
                        control.setAttribute('name', 'coordinates_' + i + "_" + j);
                        controls.push(control);
                    }
                    for (k = 0; k < controls.length; k++) {

                        fieldset.appendChild(controls[k]);
                    }
                    feildCont.push(fieldset);
                }

                document.getElementById('coordinatesContainer').innerHTML = "";

                for (n = 0; n < feildCont.length; n++) {

                    document.getElementById('coordinatesContainer').appendChild(feildCont[n]);
                }
            }

        </script>
    </body>
</html>
