<?php

declare(strict_types=1);

namespace App\DTO;

use InvalidArgumentException;
use Illuminate\Support\Collection;

class ParsedResolutionCollection extends Collection
{
    /**
     * Erstellt eine neue ParsedResolutionsCollection.
     *
     * @param  array  $items
     */
    public function __construct($items = [])
    {
        foreach ($items as $item) {
            if (!($item instanceof ParsedResolution)) {
                throw new InvalidArgumentException('Alle Elemente müssen Instanzen von ParsedResolution sein.');
            }
        }

        parent::__construct($items);
    }

    /**
     * Fügt ein neues ParsedResolution-Element zur Collection hinzu.
     *
     * @param ParsedResolution $resolution
     */
    public function add($item)
    {
        if (!($item instanceof ParsedResolution)) {
            throw new InvalidArgumentException('Das Element muss eine Instanz von ParsedResolution sein.');
        }

        parent::add($item);
    }
}
