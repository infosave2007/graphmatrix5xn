# GraphMatrix5xN finding shortest paths in a graph

GraphMatrix5xN is an efficient algorithm for finding the shortest path between two nodes in a graph using a 5xN matrix structure. This algorithm was designed to solve a wide range of problems including those involving predicates and artificial intelligence. Compared to Dijkstra's algorithm (used matrix NxN), GraphMatrix5xN offers significant performance benefits for large graphs due to its reduced memory footprint and optimized processing of graph edges. This makes it especially suitable for applications where memory constraints and computational efficiency are critical factors.

## Features

- Efficient algorithm for finding the shortest path in a graph
- Uses a 5xN matrix to represent the graph
- Suitable for solving problems involving predicates and artificial intelligence
- Easy-to-use API for adding nodes, edges, and finding the shortest path

## Installation

1. Clone the repository or download the ZIP archive and extract it to your desired location.

```bash
git clone https://github.com/infosave2007/graphmatrix5xn.git

cd graphmatrix5xn

composer install
```


## Usage

To use GraphMatrix5xN, first import the `Graph` class and create a new instance:

```php
require_once 'vendor/autoload.php';

use GraphMatrix5xN\Graph;

$graph = new Graph();
```

Next, add nodes and edges to the graph:

```php
$graph->addNode('A');
$graph->addNode('B');
$graph->addNode('C');
$graph->addEdge('A', 'B', 5);
$graph->addEdge('B', 'C', 7);
$graph->addEdge('A', 'C', 10);
```

Finally, find the shortest path between two nodes:

```php
$result = $graph->findShortestPath('A', 'C');
print_r($result);
```

This will output:

```
Array
(
    [path] => Array
        (
            [0] => A
            [1] => B
            [2] => C
        )

    [totalWeight] => 12
)
```

## License

This project is licensed under the MIT License.
```

Kirichenko Oleg Urevich infosave@mail.ru
