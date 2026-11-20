<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2025;

use Dannyvdsluijs\AdventOfCode2025\Concerns\ContentReader;

class Day04
{
    use ContentReader;

    /**
     * @var array<int, array<int, string>>
     */
    private array $grid;

    public function partOne(): string
    {
        $this->grid = $this->readInputAsGridOfCharacters();
        $answer = 0;

        foreach ($this->grid as $x => $line) {
            foreach ($line as $y => $cell) {
                if ($this->grid[$x][$y] !== '@') {
                    continue;
                }

                $neighbours = $this->getNeighbours($x, $y);
                $rolls = array_filter($neighbours, static fn ($neighbour) => $neighbour === '@');

                if (count($rolls) < 4) {
                    $answer++;
                }
            }
        }

        return (string) $answer;
    }

    public function partTwo(): string
    {
        $this->grid = $this->readInputAsGridOfCharacters();
        $answer = 0;
        $removed = [];

        while (true) {
            foreach ($this->grid as $x => $line) {
                foreach ($line as $y => $cell) {
                    if ($this->grid[$x][$y] !== '@') {
                        continue;
                    }

                    $neighbours = $this->getNeighbours($x, $y);
                    $rolls = array_filter($neighbours, static fn($neighbour) => $neighbour === '@');

                    if (count($rolls) < 4) {
                        $answer++;
                        $removed[] = [$x, $y];
                    }
                }
            }

            if ($removed === []) {
                break;
            }

            foreach ($removed as $r) {
                [$x, $y] = $r;
                $this->grid[$x][$y] = '.';
            }
            $removed = [];
        }

        return (string) $answer;
    }

    private function getNeighbours(int $x, int $y): array
    {
        return [
            $this->grid[$x-1][$y] ?? '.',
            $this->grid[$x-1][$y-1] ?? '.',
            $this->grid[$x-1][$y+1] ?? '.',
            $this->grid[$x][$y-1] ?? '.',
            $this->grid[$x][$y+1] ?? '.',
            $this->grid[$x+1][$y] ?? '.',
            $this->grid[$x+1][$y-1] ?? '.',
            $this->grid[$x+1][$y+1] ?? '.',
        ];
    }
}