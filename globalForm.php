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
            $record = $mssubmit->printConf();
            $mssubmit->cleanConfig(__DIR__ . "/global.conf");
            $mssubmit->saveConfig(__DIR__ . "/global.conf", $record, FILE_APPEND);
        }

        $ms = new GlobalConf();

        $ms->initFromFile(__DIR__ . "/global.conf");

        $ms->initGlobal();
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
                            <option value='RE_std' 
                                    <?php if ($ms->model == "RE_std"): ?>selected<?php endif; ?>
                                    >
                                standard Richards equation ( RE_std ) - recommended
                            </option>
                            <option value='RE_mod'
                                    <?php if ($ms->model == "RE_mod"): ?>selected<?php endif; ?>
                                    >
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
                        <select id='dimension' name='dimension' onchange="changeDimension(this.value);">
                            <option value='1' 
                                    <?php if ($ms->dimension == 1): ?>selected<?php endif; ?>
                                    >1D
                            </option>
                            <option value='2'
                                    <?php if ($ms->dimension == 2): ?>selected<?php endif; ?>                                    
                                    >2D
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
                        <input rule='int' type='number' id='maxIteration' name='maxIteration'  step='any' value="<?php echo $ms->maxIteration; ?>">
                    </td>
                    <td>
                        <input rule='real' type='number' id='iteration' name='iteration' step='any' value="<?php echo $ms->iteration; ?>">
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
                        <input rule='real' type='number' id='endTime' name='endTime' step='any' value="<?php echo $ms->endTime; ?>">
                    </td>
                    <td>
                        <input rule='real' type='number' id='minTime' name='minTime' step='any' value="<?php echo $ms->minTime; ?>">
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
                        <input rule='real' type='number' id='maxTime' name='maxTime' step='any' value="<?php echo $ms->maxTime; ?>">
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
                        <input rule='int' type='number' id='numberObservationTimes' name='numberObservationTimes' type='number' value='<?php echo $ms->numberObservationTimes; ?>' step='any' onchange="setObservationTimes(this.value,'observationTime')">
                    </td>
                </tr>
            </table>

            <table class='conf_group'>

                <tr><td>
                        <div id='observationTimeContainer'>  

                            <?php for ($i = 0; $i < $ms->numberObservationTimes; $i++): ?>  

                                <fieldset>
                                    <legend>observed time <?php echo $i + 1; ?></legend>

                                    <input rule = 'real' id='observationTime_<?php echo $i; ?>' type='number' name='observationTime_<?php echo $i; ?>' value='<?php echo $ms->getObservationTime($i); ?>' step='any'>

                                </fieldset>
                            <?php endfor; ?>
                        </div> 
                </tr>
            </table> 

            <br>



            <table class='conf_group'>
                <tr>
                    <td>
                        <label for='observationPoints'>number of observation points (only 1D)[integer]
                        </label>
                    </td>
                </tr>
                <tr><td>
                        <input id='observationPoints' rule='int' type='number' name='observationPoints' value='<?php echo $ms->observationPoints; ?>' step='any' onchange="setObservationPoint(this.value,'observationPoint')">
                    </td>
                </tr>
            </table>



            <table class='conf_group'>
                <tr>
                    <td>
                        <label>observation points coordinates 1D - X, 2D - X,Y
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id='observationPointContainer'>  

                            <?php for ($i = 0; $i < $ms->observationPoints; $i++): ?>  

                                <fieldset>
                                    <legend> Point <?php echo $i + 1; ?></legend>

                                    <input rule = 'real' id='observationPoint_<?php echo $i; ?>_0' type='number' name='observationPoint_<?php echo $i; ?>_0' value='<?php echo $ms->getObservationPointX($i); ?>' step='any'>
                                    <?php if ($ms->dimension == 2): ?>                               
                                        <input rule = 'real' id='observationPoint_<?php echo $i; ?>_1' type='number' name='observationPoint_<?php echo $i; ?>_1' value='<?php echo $ms->getObservationPointY($i); ?>' step='any'>
                                    <?php endif; ?>                                     
                                </fieldset>
                            <?php endfor; ?>
                        </div> 
                    </td>
                </tr>
            </table>

            <input type='submit' value='CONFIRM'>

        </form>

        <script>

            function setObservationTimes(num, pattern) {
                
                feildCont = new Array();
                for (i = 0; i < num; i++) {
                    fieldset = document.createElement("fieldset");
                    legend = document.createElement("legend");
                    legend.innerHTML = "Edge: " + i;
                    fieldset.appendChild(legend);
                    controls = new Array();
     
                        control = document.createElement("input");
                        if (document.getElementById(pattern + '_' + i)) {
                            control.value = document.getElementById(pattern + '_' + i).value;
                        }
                        control.id = pattern + '_' + i;
                        control.type = "number";
                        control.setAttribute('name', pattern + '_' + i);
                        controls.push(control);
           
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

            function setObservationPoint(num, pattern) {
                
                feildCont = new Array();
                for (i = 0; i < num; i++) {
                    fieldset = document.createElement("fieldset");
                    legend = document.createElement("legend");
                    legend.innerHTML = "Edge: " + i;
                    fieldset.appendChild(legend);
                    controls = new Array();
                    
                    dim = document.getElementById('dimension').value;
                    
                    for (j = 0; j < dim; j++) {
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
            
            
            function changeDimension(value){
                
                
            }
            
            
            
        </script>
    </body>
</html>