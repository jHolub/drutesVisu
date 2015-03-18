
var query = null;


function load() {
  //selectDataType();

  //loadCsvExample();
  //loadJsonExample();
  //loadJavascriptExample();
  //loadGooglespreadsheetExample();
  //loadDatasourceExample();

 // draw();
 
loadCsvAnimationExample();
draw();
 
}



/**
 * Upate the UI based on the currently selected datatype
 */
function selectDataType() {
}


function round(value, decimals) {
  return parseFloat(value.toFixed(decimals));
}


function loadCsvAnimationExample() {
  var csv = "";

  // headers
  csv += '"x", "y", "value", "time"\n';

  // create some nice looking data with sin/cos
  var steps = 2.5;
  var axisMax = 10;
  var tMax = 2;
  var axisStep = axisMax / steps;
  
  yy = 100;
  
  for (var t = 0; t < tMax; t++) {
    for (var x = 0; x < axisMax; x+=axisStep) {
      for (var y = 0; y < axisMax; y+=axisStep) {
        var value = Math.sin(x/50 + t/10) * Math.cos(y/50 + t/10) * 50 + 50;
        csv += round(x, 2) + ', ' + round(y, 2) + ', ' + round(value, 2) + ', ' + t + '\n';
        
        if(yy == 100){
            yy = 0;
        }else{yy = 100;}
        
        //csv += round(x, 2) + ', ' + yy + ', ' + round(value, 2) + ', ' + t + '\n';
        
      }
    }
  }

  document.getElementById("csvTextarea").innerHTML = csv;

  // also adjust some settings
  document.getElementById("style").value = "surface";
  document.getElementById("verticalRatio").value = "0.5";
  document.getElementById("animationInterval").value = 100;

  document.getElementById("xLabel").value = "x";
  document.getElementById("yLabel").value = "y";
  document.getElementById("zLabel").value = "value";
  document.getElementById("filterLabel").value = "time";
  document.getElementById("legendLabel").value = "";

  drawCsv();
}

/**
 * Retrieve teh currently selected datatype
 * @return {string} datatype
 */
function getDataType() {
  return "csv";
}


/**
 * Retrieve the datatable from the entered contents of the csv text
 * @param {boolean} [skipValue] | if true, the 4th element is a filter value
 * @return {vis DataSet}
 */
function getDataCsv() {
  var csv = document.getElementById("csvTextarea").value;

  // parse the csv content
  var csvArray = csv2array(csv);

  var data = new vis.DataSet();

  var skipValue = false;
  if (document.getElementById("filterLabel").value != "" && document.getElementById("legendLabel").value == "") {
    skipValue = true;
  }

  // read all data
  for (var row = 1; row < csvArray.length; row++) {
    if (csvArray[row].length == 4 && skipValue == false) {
      data.add({x:parseFloat(csvArray[row][0]),
        y:parseFloat(csvArray[row][1]),
        z:parseFloat(csvArray[row][2]),
        style:parseFloat(csvArray[row][3])});
    }
    else if (csvArray[row].length == 4 && skipValue == true) {
      data.add({x:parseFloat(csvArray[row][0]),
        y:parseFloat(csvArray[row][1]),
        z:parseFloat(csvArray[row][2]),
        filter:parseFloat(csvArray[row][3])});
    }
    else if (csvArray[row].length == 5) {
      data.add({x:parseFloat(csvArray[row][0]),
        y:parseFloat(csvArray[row][1]),
        z:parseFloat(csvArray[row][2]),
        style:parseFloat(csvArray[row][3]),
        filter:parseFloat(csvArray[row][4])});
    }
    else {
      data.add({x:parseFloat(csvArray[row][0]),
        y:parseFloat(csvArray[row][1]),
        z:parseFloat(csvArray[row][2]),
        style:parseFloat(csvArray[row][2])});
    }
  }

  return data;
}

/**
 * remove leading and trailing spaces
 */
function trim(text) {
  while (text.length && text.charAt(0) == ' ')
    text = text.substr(1);

  while (text.length && text.charAt(text.length-1) == ' ')
    text = text.substr(0, text.length-1);

  return text;
}

/**
 * Retrieve the datatable from the entered contents of the javascript text
 * @return {vis Dataset}
 */
function getDataJson() {
  var json = document.getElementById("jsonTextarea").value;
  var data = new google.visualization.DataTable(json);

  return data;
}


/**
 * Retrieve the datatable from the entered contents of the javascript text
 * @return {vis Dataset}
 */
function getDataJavascript() {
  var js = document.getElementById("javascriptTextarea").value;

  eval(js);

  return data;
}


/**
 * Retrieve the datatable from the entered contents of the datasource text
 * @return {vis Dataset}
 */
function getDataDatasource() {
}

/**
 * Retrieve a JSON object with all options
 */
function getOptions() {
  return {
    width:              document.getElementById("width").value,
    height:             document.getElementById("height").value,
    style:              document.getElementById("style").value,
    showAnimationControls: (document.getElementById("showAnimationControls").checked != false),
    showGrid:          (document.getElementById("showGrid").checked != false),
    showPerspective:   (document.getElementById("showPerspective").checked != false),
    showShadow:        (document.getElementById("showShadow").checked != false),
    keepAspectRatio:   (document.getElementById("keepAspectRatio").checked != false),
    verticalRatio:      document.getElementById("verticalRatio").value,
    animationInterval:  document.getElementById("animationInterval").value,
    xLabel:             document.getElementById("xLabel").value,
    yLabel:             document.getElementById("yLabel").value,
    zLabel:             document.getElementById("zLabel").value,
    filterLabel:        document.getElementById("filterLabel").value,
    legendLabel:        document.getElementById("legendLabel").value,
    animationPreload:  (document.getElementById("animationPreload").checked != false),
    animationAutoStart:(document.getElementById("animationAutoStart").checked != false),

    xCenter:           Number(document.getElementById("xCenter").value) || undefined,
    yCenter:           Number(document.getElementById("yCenter").value) || undefined,

    xMin:              Number(document.getElementById("xMin").value) || undefined,
    xMax:              Number(document.getElementById("xMax").value) || undefined,
    xStep:             Number(document.getElementById("xStep").value) || undefined,
    yMin:              Number(document.getElementById("yMin").value) || undefined,
    yMax:              Number(document.getElementById("yMax").value) || undefined,
    yStep:             Number(document.getElementById("yStep").value) || undefined,
    zMin:              Number(document.getElementById("zMin").value) || undefined,
    zMax:              Number(document.getElementById("zMax").value) || undefined,
    zStep:             Number(document.getElementById("zStep").value) || undefined,

    valueMin:          Number(document.getElementById("valueMin").value) || undefined,
    valueMax:          Number(document.getElementById("valueMax").value) || undefined,

    xBarWidth:         Number(document.getElementById("xBarWidth").value) || undefined,
    yBarWidth:         Number(document.getElementById("yBarWidth").value) || undefined
  };
}

/**
 * Redraw the graph with the entered data and options
 */
function draw() {
  return drawCsv();
}


function drawCsv() {
  // retrieve data and options
  var data = getDataCsv();
  
  console.log(data);
  
  var options = getOptions();

  // Creat a graph
  var graph = new vis.Graph3d(document.getElementById('graph'), data, options);
}

function drawJson() {
  // retrieve data and options
  var data = getDataJson();
  var options = getOptions();

  // Creat a graph
  var graph = new vis.Graph3d(document.getElementById('graph'), data, options);
}

function drawJavascript() {
  // retrieve data and options
  var data = getDataJavascript();
  var options = getOptions();

  // Creat a graph
  var graph = new vis.Graph3d(document.getElementById('graph'), data, options);
}


function drawGooglespreadsheet() {
  // Instantiate our graph object.
  drawGraph = function(response) {
    document.getElementById("draw").disabled = "";

    if (response.isError()) {
      error = 'Error: ' + response.getMessage();
      document.getElementById('graph').innerHTML =
          "<span style='color: red; font-weight: bold;'>" + error + "</span>"; ;
    }

    // retrieve the data from the query response
    data = response.getDataTable();

    // specify options
    options = getOptions();

    // Instantiate our graph object.
    var graph = new vis.Graph3d(document.getElementById('graph'), data, options);
  }

  url = document.getElementById("googlespreadsheetText").value;
  document.getElementById("draw").disabled = "disabled";

  // send the request
  query && query.abort();
  query = new google.visualization.Query(url);
  query.send(drawGraph);
}


function drawDatasource() {
  // Instantiate our graph object.
  drawGraph = function(response) {
    document.getElementById("draw").disabled = "";

    if (response.isError()) {
      error = 'Error: ' + response.getMessage();
      document.getElementById('graph').innerHTML =
          "<span style='color: red; font-weight: bold;'>" + error + "</span>"; ;
    }

    // retrieve the data from the query response
    data = response.getDataTable();

    // specify options
    options = getOptions();

    // Instantiate our graph object.
    var graph = new vis.Graph3d(document.getElementById('graph'), data, options);
  };

  url = document.getElementById("datasourceText").value;
  document.getElementById("draw").disabled = "disabled";

  // if the entered url is a google spreadsheet url, replace the part
  // "/ccc?" with "/tq?" in order to retrieve a neat data query result
  if (url.indexOf("/ccc?")) {
    url.replace("/ccc?", "/tq?");
  }

  // send the request
  query && query.abort();
  query = new google.visualization.Query(url);
  query.send(drawGraph);
}
