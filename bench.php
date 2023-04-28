<? 
require_once 'vendor/autoload.php';

use GraphMatrix5xN\Graph as Graph5xN;
use DijkstraOptimized\Graph as GraphDijkstra;

function generateRandomGraph($numNodes, $numEdges) {
    $graph = [];
    for ($i = 0; $i < $numNodes; $i++) {
        $nodeName = chr(ord('A') + $i);
        $graph[$nodeName] = [];
    }

    $edges = 0;
    while ($edges < $numEdges) {
        $source = chr(ord('A') + rand(0, $numNodes - 1));
        $target = chr(ord('A') + rand(0, $numNodes - 1));
        $weight = rand(1, 100);

        if ($source !== $target && !isset($graph[$source][$target])) {
            $graph[$source][$target] = $weight;
            $edges++;
        }
    }

    return $graph;
}

$numNodes = 10;
$numEdges = 20;

$graphData = generateRandomGraph($numNodes, $numEdges);

$dijkstra = new Dijkstra();
$graph5xN = new Graph();

foreach ($graphData as $node => $edges) {
    $dijkstra->addNode($node);
    $graph5xN->addNode($node);

    foreach ($edges as $target => $weight) {
        $dijkstra->addEdge($node, $target, $weight);
        $graph5xN->addEdge($node, $target, $weight);
    }
}

$source = 'A';
$target = chr(ord('A') + $numNodes - 1);

$startMemoryDijkstra = memory_get_usage();
$startDijkstra = microtime(true);
$resultDijkstra = $dijkstra->findShortestPath($source, $target);
$endDijkstra = microtime(true);
$endMemoryDijkstra = memory_get_usage();

$startMemory5xN = memory_get_usage();
$start5xN = microtime(true);
$result5xN = $graph5xN->findShortestPath($source, $target);
$end5xN = microtime(true);
$endMemory5xN = memory_get_usage();

echo "Dijkstra: time: " . ($endDijkstra - $startDijkstra) . " sec, memory: " . ($endMemoryDijkstra - $startMemoryDijkstra) . " bytes\n";
echo "5xN: time: " . ($end5xN - $start5xN) . " sec, memory: " . ($endMemory5xN - $startMemory5xN) . " bytes\n";

?>
