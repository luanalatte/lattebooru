<?php

namespace App\View\Components;

use App\Services\IconService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{
    public string $set;
    public string $icon;

    public function __construct(string $name)
    {
        $data = explode(':', $name, 2);
        if (count($data) < 2) {
            return '';
        }

        [$this->set, $this->icon] = $data;
    }

    public function render(): View|Closure|string
    {
        $iconData = app(IconService::class)->getIcon($this->set, $this->icon);
        if (!$iconData) {
            return '';
        }

        return function () use ($iconData) {
            return '<svg xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(["width" => "1em", "height" => "1em", "viewBox" => "0 0 24 24"]) }}>' . $iconData['body'] . '</svg>';
        };
    }
}
