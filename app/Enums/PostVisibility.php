<?php

namespace App\Enums;

enum PostVisibility: int
{
    case PUBLIC = 0;
    case PRIVATE = 1;
    case HIDDEN = 2;
}
