<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">
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
            <table>
                <tr>
                    <td>
                        <label id="information">information</label>
                    </td><td>
                        <input id="information" type="text" name="information" value="<?php echo $ms->information; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label id="intervals">number intervals</label>
                    </td><td>
                        <input id="intervals" type="number" name="intervals" value="<?php echo $ms->intervals; ?>">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>X - Y</td>
                </tr>
                <tr>
                    <td>Layers:</td>
                    <td>
                        <div id="layersContainer">

                            <?php for ($i = 0; $i < $ms->getIntervals(); $i++): ?>
                                <fieldset>
                                    <legend>Layers <?php echo $i; ?></legend>
                                    
                                    <input id="layers_<?php echo $i; ?>_0" type="number" name="layers_<?php echo $i; ?>_0" value="<?php echo $ms->getLayers($i, 0); ?>">
                                    <input id="layers_<?php echo $i; ?>_1" type="number" name="layers_<?php echo $i; ?>_1" value="<?php echo $ms->getLayers($i, 1); ?>">
                                    <input id="layers_<?php echo $i; ?>_2" type="number" name="layers_<?php echo $i; ?>_2" value="<?php echo $ms->getLayers($i, 2); ?>">
                                </fieldset>
                            <?php endfor; ?>

                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label id="numberMaterials">number materials</label>
                    </td><td>
                        <input id="numberMaterials" type="number" name="numberMaterials" value="<?php echo $ms->getNumberMatarials(); ?>">
                    </td>
                </tr>
                
                <tr>
                    <td>Materials:</td>
                    <td>
                        <div id="layersContainer">

                            <?php for ($i = 0; $i < $ms->getNumberMatarials(); $i++): ?>
                                <fieldset>
                                    <legend>Materials: <?php echo $i; ?></legend>
                                    
                                    <input id="materials_<?php echo $i; ?>_0" type="number" name="materials_<?php echo $i; ?>_0" value="<?php echo $ms->getMaterials($i, 0); ?>">
                                    <input id="materials_<?php echo $i; ?>_1" type="number" name="materials_<?php echo $i; ?>_1" value="<?php echo $ms->getMaterials($i, 1); ?>">
                                    <input id="materials_<?php echo $i; ?>_2" type="number" name="materials_<?php echo $i; ?>_2" value="<?php echo $ms->getMaterials($i, 2); ?>">
                                </fieldset>
                            <?php endfor; ?>

                        </div>
                    </td>
                </tr>              
                
                <tr>
                    <td>
                        <input type="submit" value="SAVE">
                    </td>
                </tr>
            </table>

        </form>

        <script>

            function setCoordinates(num) {
                
                feildCont = new Array();
                for (i = 1; i <= num; i++) {
                    fieldset = document.createElement("fieldset");
                    legend = document.createElement("legend");
                    legend.innerHTML = "Edge: " + i;
                    fieldset.appendChild(legend);
                    controls = new Array();
                    for (j = 1; j < 5; j++) {
                        control = document.createElement("input");
                        if (document.getElementById('coordinates_' + i + "_" + j)) {
                            control.value = document.getElementById('coordinates_' + i + "_" + j).value;
                        }
                        control.id = 'coordinates_' + i + "_" + j;
                        control.type = "number";
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
