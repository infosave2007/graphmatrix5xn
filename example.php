<?php 

require_once 'vendor/autoload.php';

use GraphMatrix5xN\Graph;

$graph = new Graph();

$graph->addNode('A');
$graph->addNode('B');
$graph->addNode('C');
$graph->addEdge('A', 'B', 5);
$graph->addEdge('B', 'C', 7);
$graph->addEdge('A', 'C', 10);

$result = $graph->findShortestPath('A', 'C');
print_r($result);
?>
