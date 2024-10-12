<?php

return [
    'thumb' => [
        'format' => env('THUMBNAIL_FORMAT', 'jpeg'),
        'quality' => env('THUMBNAIL_QUALITY', 90),
        'dimensions' => env('THUMBNAIL_DIMENSIONS', 250)
    ]
];
