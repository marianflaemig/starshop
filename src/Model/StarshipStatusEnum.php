<?php

namespace App\Model;

enum StarshipStatusEnum: string
{
    case WAITING = 'WAITING';
    case IN_PROGRESS = 'IN_PROGRESS';
    case COMPLETED = 'COMPLETED';
}
