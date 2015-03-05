<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">
    </head>
    <body>
        <?php
        include('GlobalConf.php');

        if ($_POST) {

            $mssubmit = new GlobalConf();

            $mssubmit->initFromForm($_POST);
            $record = $mssubmit->printMeshConf();
            $mssubmit->cleanConfig(__DIR__ . "/conf.TXT");
            $mssubmit->saveConfig(__DIR__ . "/conf.TXT", $record, FILE_APPEND);
        }

        $ms = new GlobalConf();

        $ms->initFromFile(__DIR__ . "/conf.TXT");
        ?>

        <a href="">refresh</a>

        <form method='POST' action=''>         

            <table class='conf_group'>              
                <tr>            
                    <td>
                        <label>
                            problem type
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select id='model' name='model'>
                            <option value='RE_std' selected>
                                standard Richards equation ( RE_std ) - recommended
                            </option>
                            <option value='RE_mod'>
                                modified Richards eq. (Noborio) ( RE_mod )
                            </option>
                        </select>
                    </td>
                </tr>
            </table>

            <table class='conf_group'>        
                <tr>        
                <tr>            
                    <td>
                        <label>
                            problem dimension (1D, 2D, 3D), recently only 1D and 2D is implemented [integer]
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select id='dimension' name='dimension'>
                            <option value='1' selected>1D
                            </option>
                            <option value='2'>2D
                            </option> 
                        </select>
                    </td>
                </tr>
            </table>



            <table class='conf_group'>
                <tr>
                    <td>
                        <label for='maxIteration'>
                            maximum number of iteration of tde Picard metdod [integer]
                        </label>
                    </td> 
                    <td>
                        <label for='iterationCriterion'>
                            iteration criterion for the Picard method
                        </label>
                    </td>            
                </tr>
                <tr><td>
                        <input rule='int' type='number' id='maxIteration' name='maxIteration'  step='any'>
                    </td>
                    <td>
                        <input rule='real' type='number' id='iterationCriterion' name='iterationCriterion' step='any'>
                    </td>                                
                </tr>
                <tr>
                <tr>
                    <td>
                        <label for='endTime'>
                            end time [real]
                        </label>
                    </td>
                    <td>
                        <label for='minTime'>
                            minimal time step [real]
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input rule='real' type='number' id='endTime' name='endTime' step='any'>
                    </td>
                    <td>
                        <input rule='real' type='number' id='minTime' name='minTime' step='any'>
                    </td>
                </tr>
                </tr>

                <tr>
                <tr>
                    <td>
                        <label for='maxTime'>
                            maximal time step [real]
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input rule='real' type='number' id='maxTime' name='maxTime' step='any'>
                    </td>
                </tr>

            </table>    

            <br>



            <table class='conf_group'>
                <tr>
                    <td>
                        <label for='numberObservationTimes'>number of observation times
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input rule='int' type='number' id='numberObservationTimes' name='numberObservationTimes' current_amount="<?php echo $this->model->amount['number_observation_times']; ?>" type='number' value='1' step='any' onchange="setAmount(this, 'number_observation_times', 'observed time ')">
                    </td>
                </tr>
            </table>






            <table class='conf_group'>

                <tr><td>
                        <div class='conf_group' id='number_observation_times_group'>  

                            <?php for ($i = 0; $i < $this->model->amount['number_observation_times']; $i++): ?>  

                                <fieldset id='number_observation_times_group_<?php echo $i; ?>'>
                                    <legend>observed time <?php echo $i + 1; ?></legend>

                                    <input rule = 'real' id='observation_time_<?php echo $i; ?>' type='number' name='observation_time_<?php echo $i; ?>' value='0' step='any'>

                                </fieldset>
                            <?php endfor; ?>
                        </div> 
                </tr>
            </table>    





            <br>







            <table class='conf_group'>
                <tr>
                    <td>
                        <label for='observation_points'>number of observation points (only 1D)[integer]
                        </label>
                    </td>
                </tr>
                <tr><td>
                        <input id='observation_points' rule='int' current_amount="<?php echo $this->model->amount['observation_points']; ?>" type='number' name='observation_points' value='1' step='any' onchange="setAmount(this, 'observation_points', 'point')"></td>
                </tr>
            </table>



            <table class='conf_group'>
                <tr>
                    <td>
                        <label>observation points coordinates X
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class='conf_group' id='observation_points_group'>  

                            <?php for ($i = 0; $i < $this->model->amount['observation_points']; $i++): ?>  

                                <fieldset id='observation_points_group_<?php echo $i; ?>'>
                                    <legend>point <?php echo $i + 1; ?></legend>

                                    <input rule = 'real' id='observation_point_X_<?php echo $i; ?>' type='number' name='observation_point_X_<?php echo $i; ?>' value='0' step='any'>
                               <!--     <input rule = 'real' id='observation_point_Y_<?php echo $i; ?>' type='number' name='observation_point_Y_<?php echo $i; ?>' value='' step='any'>
                                    -->
                                </fieldset>
                            <?php endfor; ?>
                        </div> 
                    </td>
                </tr>
            </table>

            <input type='submit' value='CONFIRM'>
            
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