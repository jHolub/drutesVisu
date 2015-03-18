<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">
    </head>
    <body>
        <?php
        include('WaterConf.php');

        if ($_POST) {

            $mssubmit = new WaterConf();

            $mssubmit->initFromForm($_POST);
            $record = $mssubmit->printConf();
            $mssubmit->cleanConfig(__DIR__ . "/water.TXT");
            $mssubmit->saveConfig(__DIR__ . "/water.TXT", $record, FILE_APPEND);
        }

        $ms = new WaterConf();

        $ms->initFromFile(__DIR__ . "/water.TXT");

        $ms->initWater();
        ?>

        <a href="">refresh</a>

        <form method="POST" action="" >

            <label for="amount_layers">amount of soil layers [integer]</label>

            <input id="layers" rule="int" type="number" name="layers" value="<?php echo $ms->layers ?>" step="any">


            <div id="layersContainer">

                <?php for ($i = 0; $i < $ms->layers; $i++): ?>

                    <fieldset>

                        <legend>layer <?php echo $i; ?></legend>

                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <label>alfa [real]</label>
                                        <input rule="real" id="param1_<?php echo $i; ?>_0" type="number" name="param1_<?php echo $i; ?>_0" value="<?php echo $ms->getParam1($i,0);?>" step="any">
                                    </td>
                                    <td>
                                        <label>n [real]</label>
                                        <input rule="real" id="param1_<?php echo $i; ?>_1" type="number" name="param1_<?php echo $i; ?>_1" value="<?php echo $ms->getParam1($i,1);?>" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>m [real]</label>
                                        <input rule="real" id="param1_<?php echo $i; ?>_2" type="number" name="param1_<?php echo $i; ?>_2" value="<?php echo $ms->getParam1($i,2);?>" step="any">
                                    </td>
                                    <td>
                                        <label>theta_r [real]</label>
                                        <input rule="real" id="param1_<?php echo $i; ?>_3" type="number" name="param1_<?php echo $i; ?>_3" value="<?php echo $ms->getParam1($i,3);?>" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>theta_s [real]</label>
                                        <input rule="real" id="param1_<?php echo $i; ?>_4" type="number" name="param1_<?php echo $i; ?>_4" value="<?php echo $ms->getParam1($i,4);?>" step="any">
                                    </td>
                                    <td>
                                        <label>specific storage [real]</label>
                                        <input rule="real" id="param1_<?php echo $i; ?>_5" type="number" name="param1_<?php echo $i; ?>_5" value="<?php echo $ms->getParam1($i,5);?>" step="any">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </fieldset>
                <?php endfor; ?>
            </div> 

            <br><br>

            <div id="layersContainer">
                <?php for ($i = 0; $i < $ms->layers; $i++): ?>

                    <fieldset>

                        <legend>layer <?php echo $i; ?></legend>

                        <table>
                            <tbody><tr>
                                    <td>
                                        <label>angle [degrees]</label>
                                        <input rule="real" id="param2_<?php echo $i; ?>_0" type="number" name="param2_<?php echo $i; ?>_0" value="<?php echo $ms->getParam2($i,0);?>" step="any">
                                    </td>
                                    <td>
                                        <label>K_11 [real]</label>
                                        <input rule="real" id="param2_<?php echo $i; ?>_1" type="number" name="param2_<?php echo $i; ?>_1" value="<?php echo $ms->getParam2($i,1);?>" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>K_22</label>
                                        <input rule="real" id="param2_<?php echo $i; ?>_2" type="number" name="param2_<?php echo $i; ?>_2" value="<?php echo $ms->getParam2($i,2);?>" step="any">
                                    </td>
                                    <td>
                                        <label>K_33</label>
                                        <input rule="real" id="param2_<?php echo $i; ?>_3" type="number" name="param2_<?php echo $i; ?>_3" value="<?php echo $ms->getParam2($i,3);?>" step="any">
                                    </td>
                                </tr>
                            </tbody></table>
                    </fieldset>
                <?php endfor; ?>
            </div> 

            <br>

            <div class="conf_group" id="amount_layers_II_group">  

                <?php for ($i = 0; $i < $ms->layers; $i++): ?>

                    <fieldset id="amount_layers_II_group_0">
                        <legend>layer <?php echo $i; ?></legend>

                        <label>init. cond [real]</label>
                        <input rule="real" id="param3_<?php echo $i; ?>" type="number" name="param3_<?php echo $i; ?>" value="<?php echo $ms->getParam3($i);?>" step="any">

                    </fieldset>

                <?php endfor; ?>
            </div> 


            <br>


            <label for="boundaries">number of boundaries (for 1D problem obviously not more then 2) [int]</label>

            <input id="boundaries" rule="int" type="number" name="boundaries" value="<?php echo $ms->boundaries;?>" step="any" >

            <div>  
                
                <?php for ($i = 0; $i < $ms->boundaries; $i++): ?>

                <fieldset>
                    
                    <legend>boundary <?php echo $i;?></legend>
                    
                    <table>
                        <tbody><tr>
                                <td>
                                    <label>boundary id</label>   
                                    <input rule="int" id="boundary_<?php echo $i;?>_0" type="number" value="<?php echo $ms->getBoundary($i,0);?>" name="boundary_<?php echo $i;?>_0">    
                                </td>
                            </tr>
                            <tr>
                                <td>                            
                                    <label>boundary type</label>                       
                                </td>
                                <td>
                                    <select id="boundary_<?php echo $i;?>_1" name="boundary_<?php echo $i;?>_1">
                                        <option value="0"
                                        <?php if ($ms->getBoundary($i,1) == 0): ?>selected<?php endif; ?>                                                
                                                >no bc for this domain</option>
                                        <option value="1"
                                        <?php if ($ms->getBoundary($i,1) == 1): ?>selected<?php endif; ?>                                        
                                                >Dirichlet boundary</option>
                                        <option value="-1"
                                        <?php if ($ms->getBoundary($i,1) == -1): ?>selected<?php endif; ?>        
                                                >Dirichlet boundary, the pressure is equal to vertical distance from the defined value</option> 
                                        <option value="2"
                                        <?php if ($ms->getBoundary($i,1) == 2): ?>selected<?php endif; ?>       
                                                >Neumann boundary (e.g. rain)</option>
                                        <option value="3"
                                        <?php if ($ms->getBoundary($i,1) == 3): ?>selected<?php endif; ?>        
                                                >Free Drainage</option>
                                        <option value="4"
                                        <?php if ($ms->getBoundary($i,1) == 4): ?>selected<?php endif; ?>        
                                                >Seepage Face</option>                     
                                    </select>                        
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>use rain.dat [y/n]</label>
                                    <input type="hidden" name="boundary_<?php echo $i;?>_2" value="n">
                                    <input id="boundary_<?php echo $i;?>_2" type="checkbox" name="boundary_<?php echo $i;?>_2" value="y"
                                            <?php if($ms->getBoundary($i,2)== 'y'):?> checked="checked"<?php endif;?>
                                           >
                                </td>
                                <td>
                                    <label>value [real]</label>
                                    <input id="boundary_<?php echo $i;?>_3" rule="real" type="number" name="boundary_<?php echo $i;?>_3" value="<?php echo $ms->getBoundary($i,3);?>" step="any">
                                </td>                        
                            </tr>
                            <tr>  
                                <td>
                                    <label>layer [int]</label>
                                    <input rule="int" id="boundary_<?php echo $i;?>_4" type="number" name="boundary_<?php echo $i;?>_4" value="<?php echo $ms->getBoundary($i,4);?>" step="any">
                                </td>
                            </tr>
                        </tbody></table>
                </fieldset>
                <?php endfor;?>
            </div> 


            <input type="submit" value="CONFIRM">

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
