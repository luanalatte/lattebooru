<?php

namespace App\Enums;

enum ImageType: int
{
    case IMAGE = 1;
    case THUMBNAIL = 2;
    case IMAGE_PREVIEW = 3;
}
