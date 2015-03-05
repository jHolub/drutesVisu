<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">
    </head>
    <body>
        <?php
        include('Mesh2D.php');

        if ($_POST) {

            $mssubmit = new Mesh2D();

            $mssubmit->initFromForm($_POST);
            $record = $mssubmit->printMesh2DConf();
            $mssubmit->cleanConfig(__DIR__ . "/conf2d.TXT");
            $mssubmit->saveConfig(__DIR__ . "/conf2d.TXT", $record, FILE_APPEND);
        }

        $ms = new Mesh2D();

        $ms->initFromFile(__DIR__ . "/conf2d.TXT");
        ?>

        <a href="">refresh</a>

        <form action="" method="post">
            <table>
                <tr>
                    <td>
                        <label id="xCoor">if yes fill in width [x-coordinate]</label>
                    </td><td>
                        <input id="xCoor" type="number" name="xCoor" value="<?php echo $ms->getXCoor(); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label id="yCoor">length [z-coordinate]</label>
                    </td><td>
                        <input id="yCoor" type="number" name="yCoor" value="<?php echo $ms->getYCoor(); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label id="density">density</label>
                    </td><td>
                        <input id="density" type="number" name="density" value="<?php echo $ms->getDensity(); ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label id="numberEdge">density</label>
                    </td><td>
                        <input onchange="setCoordinates(this.value);" id="numberEdge" type="number" name="numberEdge" value="<?php echo $ms->getNumberEdge(); ?>">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>X - Y</td>
                </tr>
                <tr>
                    <td>Edges:</td>
                    <td>
                        <div id="coordinatesContainer">

                            <?php for ($i = 1; $i <= $ms->getNumberEdge(); $i++): ?>
                                <fieldset>
                                    <legend>Edge: <?php echo $i; ?></legend>
                                    <input id="coordinates_<?php echo $i; ?>_1" type="number" name="coordinates_<?php echo $i; ?>_1" value="<?php echo $ms->getCoordinates($i, 0); ?>">

                                    <input id="coordinates_<?php echo $i; ?>_2"  type="number" name="coordinates_<?php echo $i; ?>_2" value="<?php echo $ms->getCoordinates($i, 1); ?>"> 

                                    <input id="coordinates_<?php echo $i; ?>_3" type="number" name="coordinates_<?php echo $i; ?>_3" value="<?php echo $ms->getCoordinates($i, 2); ?>">

                                    <input id="coordinates_<?php echo $i; ?>_4"  type="number" name="coordinates_<?php echo $i; ?>_4" value="<?php echo $ms->getCoordinates($i, 3); ?>">                                
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
