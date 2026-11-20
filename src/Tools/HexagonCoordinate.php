<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2025\Tools;

final readonly class HexagonCoordinate
{
    public function __construct(
        public int $subgrid,
        public int $row,
        public int $column,
    ) {}
}
