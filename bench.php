<? 
require_once 'vendor/autoload.php';

use GraphMatrix5xN\Graph as Graph5xN;
use DijkstraOptimized\Graph as GraphDijkstra;

<? 
function generateRandomGraph($numNodes, $numEdges)
{
    $nodes = [];
    $edges = [];

    for ($i = 1; $i <= $numNodes; $i++) {
        $nodes[] = (string)$i;
    }

    for ($i = 0; $i < $numEdges; $i++) {
        $node1 = $nodes[array_rand($nodes)];
        $node2 = $nodes[array_rand($nodes)];

        while ($node1 == $node2) {
            $node2 = $nodes[array_rand($nodes)];
        }

        $edges[] = [
            'node1' => $node1,
            'node2' => $node2,
            'weight' => rand(1, 100)
        ];
    }

    return [
        'nodes' => $nodes,
        'edges' => $edges
    ];
}

$numNodes = 10000;
$numEdges = 50000;
$source = '1';
$target = $numNodes;

$graphData = generateRandomGraph($numNodes, $numEdges);

$dijkstra = new Dijkstra();
$graph5xN = new Graph();

foreach ($graphData['nodes'] as $node) {
    $dijkstra->addNode($node);
}

foreach ($graphData['edges'] as $edge) {
    $dijkstra->addEdge($edge['node1'], $edge['node2'], $edge['weight']);
}

$endMemoryDijkstra = memory_get_usage();
$usedMemoryDijkstra = $endMemoryDijkstra - $startMemoryDijkstra;


$endMemoryDijkstra = memory_get_usage();
$usedMemoryDijkstra = $endMemoryDijkstra - $startMemoryDijkstra;

$startMemory5xN = memory_get_usage();

foreach ($graphData['nodes'] as $node) {
    $graph5xN->addNode($node);
}

foreach ($graphData['edges'] as $edge) {
    $graph5xN->addEdge($edge['node1'], $edge['node2'], $edge['weight']);
}

$endMemory5xN = memory_get_usage();
$usedMemory5xN = $endMemory5xN - $startMemory5xN;




$startDijkstra = microtime(true);
$resultDijkstra = $dijkstra->findShortestPath($source, $target);
//print_r($resultDijkstra);
$endDijkstra = microtime(true);


$startMemory5xN = memory_get_usage();
$start5xN = microtime(true);
$result5xN = $graph5xN->findShortestPath($source, $target);
//print_r($result5xN);
$end5xN = microtime(true);


echo "Dijkstra: time: " . ($endDijkstra - $startDijkstra) . " sec, memory: " . ($usedMemoryDijkstra) . " bytes\n";
echo "5xN: time: " . ($end5xN - $start5xN) . " sec, memory: " . ($usedMemory5xN) . " bytes\n";

?>
