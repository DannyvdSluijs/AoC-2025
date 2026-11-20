<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2025;

use Dannyvdsluijs\AdventOfCode2025\Concerns\ContentReader;
use Dannyvdsluijs\AdventOfCode2025\Tools\HexagonCoordinate;

class Day31
{
    use ContentReader;

    /**
     * @var array{
     *     0: list<int|null>,
     *     1: list<int|null>,
     * }
     */
    private array $grid;
    /**
     * @var array{
     *     0: list<int|null>,
     *     1: list<int|null>,
     * }
     */
    private array $nextGrid;

    public function partOne(): string
    {
        $content = $this->readInputAsLines();
        // Skip header
        array_shift($content);
        // Skip footer
        array_pop($content);
        $this->grid = [
            0 => [],
            1 => [],
        ];

        $content = array_map(static function ($line) {
            $trees = [];
            if (str_starts_with($line, '/')) {
                $offset = 1;
            } else {
                $offset = 4;
            }

            while ($offset < strlen($line)) {
                $tree = $line[$offset];
                $trees[] = is_numeric($tree) ? (int) $tree : null;
                $offset += 6;
            }

            return $trees;
        }, $content);

        foreach ($content as $index => $line) {
            $this->grid[$index % 2][] = $line;
        }

        $maxDays = 3;
        $lightPositions = ['N', 'E', 'S', 'W'];
        $numberOfRows = count($this->grid[0]);
        $numberOfColumns = count($this->grid[0][0]);
        $cutDownTrees = 0;
        for ($day = 1; $day <= $maxDays; $day++) {
            $lightPosition = $lightPositions[($day - 1) % 4];
            $this->nextGrid = $this->grid;
            foreach ([0, 1] as $subgrid) {
                switch ($lightPosition) {
                    case 'N':
                        for ($columnNumber = 0; $columnNumber < $numberOfColumns; $columnNumber++) {
                            $highestTree = 0;
                            for ($rowNumber = 0; $rowNumber < $numberOfRows; $rowNumber++) {
                                $tree = $this->grid[$subgrid][$rowNumber][$columnNumber];
                                $highestTree = max($highestTree, $tree ?? 0);
                                if (is_null($tree)) {
                                    $c = new HexagonCoordinate($subgrid, $rowNumber, $columnNumber);
                                    $neighbours = $this->getNeighbours($c);
                                    $treesHigherThanTwo = array_filter($neighbours, static function ($neighbour) { return !is_null($neighbour) && $neighbour >= 2;});
                                    if (count($treesHigherThanTwo) >= 2) {
                                        $this->nextGrid[$subgrid][$rowNumber][$columnNumber] = 0;
                                    }
                                }
                                // Tree growth
                                if (!is_null($tree)) {
                                    $this->nextGrid[$subgrid][$rowNumber][$columnNumber] += 1;
                                }
                                // Cut down tall trees
                                if ($tree === 5) {
                                    $this->nextGrid[$subgrid][$rowNumber][$columnNumber] = null;
                                    $cutDownTrees++;
                                }
                            }
                        }
                        break;
                    case 'E':
                        break;
                    case 'S':
                        break;
                    case 'W':
                        break;
                }
            }
            $this->grid = $this->nextGrid;
        }

        return '';
    }

    public function partTwo(): string
    {
        $content = $this->readInput();

        return '';
    }

    /** @return list<HexagonCoordinate> */
    private function getNeighbours(HexagonCoordinate $c): array
    {
        return [
            $this->grid[$c->subgrid][$c->row - 1][$c->column] ?? null,
            $this->grid[($c->subgrid + 1) % 2][$c->row - 1][$c->column] ?? null,
            $this->grid[($c->subgrid + 1) % 2][$c->row][$c->column] ?? null,
            $this->grid[$c->subgrid][$c->row + 1][$c->column] ?? null,
            $this->grid[($c->subgrid + 1) % 2][$c->row][$c->column - 1] ?? null,
            $this->grid[($c->subgrid + 1) % 2][$c->row - 1][$c->column - 1] ?? null,
        ];
    }
}