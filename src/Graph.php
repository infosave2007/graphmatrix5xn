<?php

namespace GraphMatrix5xN;

class Graph
{
    private array $nodes = []; // Array to store the nodes and their connections (edges)
    private array $matrix = []; // Array to store the matrix representation of the graph

    // Adds a node to the graph
    public function addNode(string $node): void
    {
        if (!isset($this->nodes[$node])) {
            $this->nodes[$node] = [];
        }
    }

    // Adds an edge between two nodes with a specified weight
    public function addEdge(string $from, string $to, int $weight): void
    {
        $this->nodes[$from][$to] = $weight;
        $this->nodes[$to][$from] = $weight;
    }

    // Finds the shortest path between the start and end nodes
    public function findShortestPath(string $start, string $end): array
    {
        $visited = []; // Array to store the visited status of each node
        $distances = []; // Array to store the current shortest distance to each node
        $previousNodes = []; // Array to store the previous node in the path for each node
        $nodes = array_keys($this->nodes);

        // Initialize the arrays with default values
        foreach ($nodes as $node) {
            $visited[$node] = false;
            $previousNodes[$node] = null;
            $distances[$node] = INF;
        }

        $distances[$start] = 0;
        $currentNode = $start;

        // Main loop to process each node
        while ($currentNode !== null) {
            $neighbors = $this->nodes[$currentNode];
            $currentDistance = $distances[$currentNode];

            // Process the neighbors of the current node
            foreach ($neighbors as $neighbor => $weight) {
                $newDistance = $currentDistance + $weight;

                // Update the distance to the neighbor if a shorter path is found
                if ($newDistance < $distances[$neighbor]) {
                    $distances[$neighbor] = $newDistance;
                    $previousNodes[$neighbor] = $currentNode;
                }
            }

            // Mark the current node as visited
            $visited[$currentNode] = true;

            // Find the next unvisited node with the shortest distance
            $currentNode = null;
            $minDistance = INF;

            foreach ($nodes as $node) {
                if (!$visited[$node] && $distances[$node] < $minDistance) {
                    $currentNode = $node;
                    $minDistance = $distances[$node];
                }
            }
        }

        // Reconstruct the shortest path from the previous nodes array
        $path = [];
        $currentNode = $end;

        while ($currentNode !== null) {
            $path[] = $currentNode;
            $currentNode = $previousNodes[$currentNode];
        }

        // Reverse the path and return it along with the total weight
        $path = array_reverse($path);
        return [
            'path' => $path,
            'totalWeight' => $distances[$end],
        ];
    }
}
?>
