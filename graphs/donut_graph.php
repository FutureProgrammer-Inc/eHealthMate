<?php
// Include the jpgraph library
require_once('jpgraph/jpgraph.php');
require_once('jpgraph/jpgraph_pie.php');

// Sample data
$data = array(30, 20, 25, 10);

// Create a new Graph object
$graph = new PieGraph(400, 300);

// Set a title for the graph
$graph->title->Set("Donut Graph Example");

// Create a PiePlot
$plot = new PiePlot($data);

// Set the size of the center hole (0 for a traditional pie chart)
$plot->SetSize(0.4);

// Set labels for the slices
$labels = array("Slice 1", "Slice 2", "Slice 3", "Slice 4");
$plot->SetLegends($labels);

// Add the plot to the graph
$graph->Add($plot);

// Display the graph
$graph->Stroke();
