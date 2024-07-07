<?php

declare(strict_types=1);


namespace App\DTO;

class ParsedResolution
{
    public string $title;
    public string $tag;
    public string $year;
    public string $text;
    public string $category;
    public string $councilId;
    public array $applicants = [];
}
