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
        include('Mesh1D.php');

        if ($_POST) {

            $mssubmit = new Mesh1D();

            $mssubmit->initFromForm($_POST);
            $record = $mssubmit->printConf();
            $mssubmit->cleanConfig(__DIR__ . "/conf.TXT");
            $mssubmit->saveConfig(__DIR__ . "/conf.TXT", $record, FILE_APPEND);
        }

        $ms = new Mesh1D();

        $ms->initFromFile(__DIR__ . "/conf.TXT");

        $ms->initMesh();
        ?>

        <a href="">refresh</a>

        <form action="" method="post">
            <div style="width: 800px;">
                <div class="row">
                    <div class="col-sm-4"> 
                        <div class="form-group">
                            <label for="information">Information:</label>
                            <input id="information" class="form-control" type="text" name="information" value="<?php echo $ms->information; ?>">              
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="intervals">Number intervals:</label>
                            <input id="intervals" class="form-control" type="number" name="intervals" value="<?php echo $ms->intervals; ?>" onchange="setLayers(this.value, 'layers')">
                        </div>
                    </div>   
                </div>

                <div class="row">
                    <div class="col-sm-4">Density</div>
                    <div class="col-sm-4">Bottom</div> 
                    <div class="col-sm-4">Top</div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div id="layersContainer" class="form-inline">

                            <?php for ($i = 0; $i < $ms->getIntervals(); $i++): ?>    
                                <div class="form-group">
                                    <label ><?php echo $i + 1; ?>. </label>
                                    <input class="form-control" id="layers_<?php echo $i; ?>_0" type="number" name="layers_<?php echo $i; ?>_0" value="<?php echo $ms->getLayers($i, 0); ?>">
                                    <input class="form-control"  id="layers_<?php echo $i; ?>_1" type="number" name="layers_<?php echo $i; ?>_1" value="<?php echo $ms->getLayers($i, 1); ?>">
                                    <input class="form-control"  id="layers_<?php echo $i; ?>_2" type="number" name="layers_<?php echo $i; ?>_2" value="<?php echo $ms->getLayers($i, 2); ?>">
                                </div>
                            <?php endfor; ?>

                        </div>
                    </div>
                </div> 


                <br><br>

                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="numberMaterials">number materials</label>
                            <input id="numberMaterials" class="form-control" type="number" name="numberMaterials" value="<?php echo $ms->getNumberMatarials(); ?>" onchange="setMaterials(this.value, 'materials')">

                        </div>  
                    </div>    
                </div>               


                <div class="row">
                    <div class="col-sm-4">id [real]</div>
                    <div class="col-sm-4">bottom [real]</div> 
                    <div class="col-sm-4">top [real]</div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div id="materialsContainer" class="form-inline">

                            <?php for ($i = 0; $i < $ms->getNumberMatarials(); $i++): ?>
                                <div class="form-group">
                                    <label><?php echo $i + 1; ?>. </label>

                                    <input class="form-control" id="materials_<?php echo $i; ?>_0" type="number" name="materials_<?php echo $i; ?>_0" value="<?php echo $ms->getMaterials($i, 0); ?>">
                                    <input class="form-control" id="materials_<?php echo $i; ?>_1" type="number" name="materials_<?php echo $i; ?>_1" value="<?php echo $ms->getMaterials($i, 1); ?>">
                                    <input class="form-control" id="materials_<?php echo $i; ?>_2" type="number" name="materials_<?php echo $i; ?>_2" value="<?php echo $ms->getMaterials($i, 2); ?>">
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

            function setLayers(num, pattern) {

                feildCont = new Array();
                for (i = 0; i < num; i++) {
                    fieldset = document.createElement("div");
                    fieldset.className = "form-group";
                    legend = document.createElement("label");
                    legend.innerHTML = i + 1 + ".  ";
                    fieldset.appendChild(legend);
                    controls = new Array();
                    for (j = 0; j < 3; j++) {
                        control = document.createElement("input");
                        if (document.getElementById(pattern + '_' + i + "_" + j)) {
                            control.value = document.getElementById(pattern + '_' + i + "_" + j).value;
                        }
                        control.id = pattern + '_' + i + "_" + j;
                        control.type = "number";
                        control.className = "form-control";
                        control.setAttribute('name', pattern + '_' + i + "_" + j);
                        controls.push(control);
                    }
                    for (k = 0; k < controls.length; k++) {

                        fieldset.appendChild(controls[k]);
                    }
                    feildCont.push(fieldset);
                }

                document.getElementById(pattern + 'Container').innerHTML = "";

                for (n = 0; n < feildCont.length; n++) {

                    document.getElementById(pattern + 'Container').appendChild(feildCont[n]);
                }
            }


            function setMaterials(num, pattern) {

                feildCont = new Array();
                for (i = 0; i < num; i++) {
                    fieldset = document.createElement("div");
                    fieldset.className = "form-group";
                    legend = document.createElement("label");
                    legend.innerHTML = i + 1 + ".  ";
                    fieldset.appendChild(legend);
                    controls = new Array();
                    for (j = 0; j < 3; j++) {
                        control = document.createElement("input");
                        if (document.getElementById(pattern + '_' + i + "_" + j)) {
                            control.value = document.getElementById(pattern + '_' + i + "_" + j).value;
                        }
                        control.id = pattern + '_' + i + "_" + j;
                        control.type = "number";
                        control.className = "form-control";
                        control.setAttribute('name', pattern + '_' + i + "_" + j);
                        controls.push(control);
                    }
                    for (k = 0; k < controls.length; k++) {

                        fieldset.appendChild(controls[k]);
                    }
                    feildCont.push(fieldset);
                }

                document.getElementById(pattern + 'Container').innerHTML = "";

                for (n = 0; n < feildCont.length; n++) {

                    document.getElementById(pattern + 'Container').appendChild(feildCont[n]);
                }
            }

        </script>
    </body>
</html>
