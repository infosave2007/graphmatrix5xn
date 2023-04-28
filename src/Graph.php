<?php

namespace GraphMatrix5xN;

class Graph
{
    private array $nodes = []; // Array to store the nodes and their connections (edges)

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
        $distances = []; // Array to store the current shortest distance to each node
        $previousNodes = []; // Array to store the previous node in the path for each node
        $nodes = array_keys($this->nodes); // Get the list of node keys

        // Initialize the arrays with default values
        foreach ($nodes as $node) {
            $previousNodes[$node] = null;
            $distances[$node] = INF;
        }

        $distances[$start] = 0; // Set the initial distance for the start node to 0

        $queue = new \SplPriorityQueue(); // Create a new priority queue

        $queue->insert($start, 0); // Insert the start node into the priority queue with a priority of 0

        // Main loop to process each node
        while (!$queue->isEmpty()) {
            $currentNode = $queue->extract(); // Get the node with the highest priority (lowest distance)

            if ($currentNode === $end) { // If we've reached the end node, break the loop
                break;
            }

            $neighbors = $this->nodes[$currentNode]; // Get the neighbors of the current node
            $currentDistance = $distances[$currentNode]; // Get the current shortest distance for the current node

            // Process the neighbors of the current node
            foreach ($neighbors as $neighbor => $weight) {
                $newDistance = $currentDistance + $weight; // Calculate the new distance for the neighbor node

                // Update the distance to the neighbor if a shorter path is found
                if ($newDistance < $distances[$neighbor]) {
                    $distances[$neighbor] = $newDistance;
                    $previousNodes[$neighbor] = $currentNode;
                    $queue->insert($neighbor, -$newDistance); // Insert the neighbor into the priority queue with a negative priority (lower distance means higher priority)
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
