<?php

namespace DijkstraOptimized;

/**
 * Класс Graph представляет собой граф с методом для поиска кратчайшего пути с помощью оптимизированного алгоритма Дейкстры.
 */
class Graph
{
    private $nodes;
    private $edges;

    public function __construct()
    {
        $this->nodes = [];
        $this->edges = [];
    }

    /**
     * Добавляет узел в граф.
     *
     * @param string $node
     */
    public function addNode($node)
    {
        $this->nodes[$node] = true;
    }

    /**
     * Добавляет ребро между двумя узлами с заданным весом.
     *
     * @param string $node1
     * @param string $node2
     * @param float $weight
     */
    public function addEdge($node1, $node2, $weight)
    {
        if (!isset($this->edges[$node1])) {
            $this->edges[$node1] = [];
        }
        if (!isset($this->edges[$node2])) {
            $this->edges[$node2] = [];
        }

        $this->edges[$node1][$node2] = $weight;
        $this->edges[$node2][$node1] = $weight;
    }

    /**
     * Находит кратчайший путь между двумя узлами с помощью оптимизированного алгоритма Дейкстры.
     *
     * @param string $source
     * @param string $target
     * @return array
     */
    public function findShortestPath($source, $target)
    {
        $distances = [];
        $previous = [];
        $visited = [];
        $unvisitedNodes = $this->nodes;

        foreach ($this->nodes as $node => $_) {
            $distances[$node] = INF;
            $previous[$node] = null;
        }

        $distances[$source] = 0;

        while (!empty($unvisitedNodes)) {
            $minNode = null;
            $minDistance = INF;

            foreach ($unvisitedNodes as $node => $_) {
                if ($distances[$node] < $minDistance) {
                    $minDistance = $distances[$node];
                    $minNode = $node;
                }
            }

            if ($minNode === null) {
                break;
            }

            foreach ($this->edges[$minNode] as $neighbor => $weight) {
                $newDistance = $distances[$minNode] + $weight;
                if ($newDistance < $distances[$neighbor]) {
                    $distances[$neighbor] = $newDistance;
                    $previous[$neighbor] = $minNode;
                }
            }

            $visited[$minNode] = true;
            unset($unvisitedNodes[$minNode]);
        }

        $path = [];
        $current = $target;

        while ($current !== null) {
            array_unshift($path, $current);
            $current = $previous[$current];
        }

        return [
            'path' => $path,
            'totalWeight' => $distances[$target],
        ];
    }
}
?>
