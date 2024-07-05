<?php

namespace App\Enums;

enum ResolutionStatus: string
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Live = 'live';
    case Archived = 'archived';
}
