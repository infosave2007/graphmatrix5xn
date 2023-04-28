<? 
require_once 'vendor/autoload.php';

use GraphMatrix5xN\Graph;
use DijkstraOptimized\Dijkstra;

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

function calculateMemoryUsage(int $numNodes, int $numEdges): array
{
    $memoryUsageNxN = ($numNodes * $numNodes) * 4;
    $memoryUsage5xN = (5 * $numEdges) * 4;

    return [
        'D' => $memoryUsageNxN/1024,
        '5N' => $memoryUsage5xN/1024,
    ];
}

$numNodes = 500;
$numEdges = 2000;
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

foreach ($graphData['nodes'] as $node) {
    $graph5xN->addNode($node);
}

foreach ($graphData['edges'] as $edge) {
    $graph5xN->addEdge($edge['node1'], $edge['node2'], $edge['weight']);
}


$startDijkstra = microtime(true);
$resultDijkstra = $dijkstra->findShortestPath($source, $target);
//print_r($resultDijkstra);
$endDijkstra = microtime(true);

$start5xN = microtime(true);
$result5xN = $graph5xN->findShortestPath($source, $target);
//print_r($result5xN);
$end5xN = microtime(true);
$memoryUsage = calculateMemoryUsage($numNodes, $numEdges);
$memory5xn=$memoryUsage['5N'];
$memoryD=$memoryUsage['D'];

echo "Dijkstra: time: " . ($endDijkstra - $startDijkstra) . " sec, memory: " . ($memoryD) . " KB\n";
echo "5xN: time: " . ($end5xN - $start5xN) . " sec, memory: " . ($memory5xn) . " KB\n";

?>
