<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">        

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

            <table class="table" style="width: 800px;">
                <tr>
                    <td>
                        <label id="information">information</label>
                    </td>
                    <td>
                        <input id="information" class="form-control" type="text" name="information" value="<?php echo $ms->information; ?>">              
                    </td>
                </tr>
                <tr>
                    <td>
                        <label id="intervals">number intervals</label>
                    </td>
                    <td>
                        <input id="intervals" class="form-control" type="number" name="intervals" value="<?php echo $ms->intervals; ?>" onchange="setLayers(this.value, 'layers')">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>density - bottom - top</td>
                </tr>
                <tr>
                    <td><label>Layers:</label></td>
                    <td>
                        <div id="layersContainer" class="form-inline">

                            <?php for ($i = 0; $i < $ms->getIntervals(); $i++): ?>
                              <fieldset>
                                    <legend><?php echo $i; ?></legend>

                                    <input class="form-control" id="layers_<?php echo $i; ?>_0" type="number" name="layers_<?php echo $i; ?>_0" value="<?php echo $ms->getLayers($i, 0); ?>">
                                    <input class="form-control"  id="layers_<?php echo $i; ?>_1" type="number" name="layers_<?php echo $i; ?>_1" value="<?php echo $ms->getLayers($i, 1); ?>">
                                    <input class="form-control"  id="layers_<?php echo $i; ?>_2" type="number" name="layers_<?php echo $i; ?>_2" value="<?php echo $ms->getLayers($i, 2); ?>">
                              </fieldset>
                            <?php endfor; ?>

                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label id="numberMaterials">number materials</label>
                    </td><td>
                        <input id="numberMaterials" class="form-control" type="number" name="numberMaterials" value="<?php echo $ms->getNumberMatarials(); ?>" onchange="setMaterials(this.value, 'materials')">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>density - bottom - top</td>
                </tr>
                <tr>
                    <td><label>Materials:</label></td>
                    <td>
                        <div id="materialsContainer" class="form-inline">

                            <?php for ($i = 0; $i < $ms->getNumberMatarials(); $i++): ?>
                                <fieldset>
                                    <legend><?php echo $i; ?></legend>

                                    <input class="form-control" id="materials_<?php echo $i; ?>_0" type="number" name="materials_<?php echo $i; ?>_0" value="<?php echo $ms->getMaterials($i, 0); ?>">
                                    <input class="form-control" id="materials_<?php echo $i; ?>_1" type="number" name="materials_<?php echo $i; ?>_1" value="<?php echo $ms->getMaterials($i, 1); ?>">
                                    <input class="form-control" id="materials_<?php echo $i; ?>_2" type="number" name="materials_<?php echo $i; ?>_2" value="<?php echo $ms->getMaterials($i, 2); ?>">
                                </fieldset>
                            <?php endfor; ?>

                        </div>
                    </td>
                </tr>              

                <tr>
                    <td>
                        <input type="submit" value="SAVE" class="btn btn-default">
                    </td>
                </tr>
            </table>

        </form>

        <script>

            function setLayers(num, pattern) {

                feildCont = new Array();
                for (i = 0; i < num; i++) {
                    fieldset = document.createElement("fieldset");
                    legend = document.createElement("legend");
                    legend.innerHTML = i;
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
                    fieldset = document.createElement("fieldset");
                    legend = document.createElement("legend");
                    legend.innerHTML = i;
                    fieldset.appendChild(legend);
                    controls = new Array();
                    for (j = 0; j < 3; j++) {
                        control = document.createElement("input");
                        if (document.getElementById(pattern + '_' + i + "_" + j)) {
                            control.value = document.getElementById(pattern + '_' + i + "_" + j).value;
                        }
                        control.id = pattern + '_' + i + "_" + j;
                        control.type = "number";
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
