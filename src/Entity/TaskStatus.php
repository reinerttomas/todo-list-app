<?php
declare(strict_types=1);

namespace App\Entity;

enum TaskStatus: int
{
    case NEW = 1;
    case DONE = 2;
}