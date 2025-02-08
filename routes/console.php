<?php

use Illuminate\Support\Facades\Schedule;

if (config('queue.default' == 'schedule')) {
    Schedule::command('queue:work --stop-when-empty')
        ->everyMinute()
        ->withoutOverlapping();
}
