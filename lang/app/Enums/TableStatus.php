<?php

namespace App\Enums;

enum TableStatus: string
{

    case Pending ='pending';
    case Inside ='inside';
    case Unavailable ='unavailable';
}