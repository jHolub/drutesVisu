<?php
include("config.php");
?>

<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">
        <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="<?php echo \GLOBALVAR\ROOT; ?>/js/jqplot/jquery.jqplot.min.js"></script>
        <script type="text/javascript" src="<?php echo \GLOBALVAR\ROOT; ?>/js/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
        <script type="text/javascript" src="<?php echo \GLOBALVAR\ROOT; ?>/js/jqplot/plugins/jqplot.logAxisRenderer.min.js"></script>
        <script type="text/javascript" src="<?php echo \GLOBALVAR\ROOT; ?>/js/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
        <script type="text/javascript" src="<?php echo \GLOBALVAR\ROOT; ?>/js/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
        <script type="text/javascript" src="<?php echo \GLOBALVAR\ROOT; ?>/js/jqplot/plugins/jqplot.ohlcRenderer.min.js"></script>
        <script type="text/javascript" src="<?php echo \GLOBALVAR\ROOT; ?>/js/jqplot/plugins/jqplot.cursor.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo \GLOBALVAR\ROOT; ?>/js/jqplot/jquery.jqplot.min.css" />


        <script type="text/javascript" src="<?php echo \GLOBALVAR\ROOT; ?>/js/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
        <script type="text/javascript" src="<?php echo \GLOBALVAR\ROOT; ?>/js/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
        <script type="text/javascript" src="<?php echo \GLOBALVAR\ROOT; ?>/js/jqplot/plugins/jqplot.highlighter.min.js"></script>        



    </head>
    <body>

        <h1>PARSER</h1>
        <div id="chart1" style="width:1120px; height: 1100px;"></div>

<?php
include('Parser.php');

$pr = new Parser(__DIR__ . "/RE_matrix_theta-1.dat");
//$pr = new Parser(__DIR__ . "/obspt_RE_matrix-1.out");
$pr->init();

//$pr->printHtmlTable();
?>

        <script>
            $(document).ready(function() {
                
                y = [<?php echo $pr->getArrayJS(0,10);?>];
                val = [<?php echo $pr->getArrayJS(1,10);?>];
                
                data = [];
                for (var i = 0; i < y.length; i++) {
                    data.push([val[i], y[i]]);
                }
                var plot1 = $.jqplot('chart1', [data], {
                    series: [{showMarker: false}],
                    axes: {
                        xaxis: {
                            label: 'X'
                        },
                        yaxis: {
                            label: 'Y'
                        }
                    }
                });
            });
        </script>    
        
    </body>
</html>
