<?php

namespace DijkstraOptimized;

class Dijkstra
{
    private array $nodes = []; // An array to store nodes and their connections (edges)

    // Adds a node to the graph
    public function addNode(string $node): void
    {
        if (!isset($this->nodes[$node])) {
            $this->nodes[$node] = []; // Initialize the array for the node's connections
        }
    }

    // Adds an edge between two nodes with a specified weight
    public function addEdge(string $from, string $to, int $weight): void
    {
        $this->nodes[$from][$to] = $weight; // Add the edge from the 'from' node to the 'to' node
        $this->nodes[$to][$from] = $weight; // Add the edge from the 'to' node to the 'from' node
    }

    // Finds the shortest path between the start and end nodes
    public function findShortestPath(string $start, string $end): array
    {
        $distances = [];       // An array to store the current shortest distance to each node
        $previousNodes = [];   // An array to store the previous node in the path for each node
        $nodes = array_keys($this->nodes); // Get an array of all node names

        // Initialize the arrays with default values
        foreach ($nodes as $node) {
            $previousNodes[$node] = null; // Set the previous node for each node to null
            $distances[$node] = INF;      // Set the initial distance for each node to infinity
        }

        $distances[$start] = 0; // Set the initial distance for the start node to 0

        $queue = new \SplPriorityQueue(); // Create a new priority queue

        $queue->insert($start, 0); // Insert the start node into the priority queue with a priority of 0

        // Main loop to process each node
        while (!$queue->isEmpty()) {
            $currentNode = $queue->extract(); // Get the node with the highest priority (lowest distance)

            if ($currentNode === $end) { // If the current node is the end node, break the loop
                break;
            }

            $neighbors = $this->nodes[$currentNode]; // Get the neighbors of the current node
            $currentDistance = $distances[$currentNode]; // Get the current distance to the current node

            // Process the neighbors of the current node
            foreach ($neighbors as $neighbor => $weight) {
                $newDistance = $currentDistance + $weight; // Calculate the new distance to the neighbor

                // Update the distance to the neighbor if a shorter path is found
                if ($newDistance < $distances[$neighbor]) {
                    $distances[$neighbor] = $newDistance; // Update the distance
                    $previousNodes[$neighbor] = $currentNode; // Set the previous node for the neighbor
                    $queue->insert($neighbor, -$newDistance); // Insert the neighbor with the updated distance
                }
            }
        }

        // Reconstruct the shortest path from the previous nodes array
        $path = [];
        $currentNode = $end;

        while ($currentNode !== null) {
            $path[] = $currentNode; // Add the current node to the path
            $currentNode = $previousNodes[$currentNode]; // Move to the previous node in the path
        }

        $path = array_reverse($path);// Reverse the path to get the correct order

    // Return the shortest path along with the total weight
    return [
        'path' => $path,
        'totalWeight' => $distances[$end],
    ];
}
}
?>
