<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\ParsedResolutionCollection;

interface ResolutionImportParserInterface
{
    public function parse(string $file): ParsedResolutionCollection;
}
