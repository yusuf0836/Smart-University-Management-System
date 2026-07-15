<?php

namespace App\Enums;

enum AcademicSessionStatus: string
{
    case UPCOMING = 'upcoming';
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
}