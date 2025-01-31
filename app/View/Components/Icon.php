<?php

namespace App\View\Components;

use App\Services\IconService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{
    protected string $set;
    protected string $icon;

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
        $svg = app(IconService::class)->getIcon($this->set, $this->icon);
        if (!$svg) {
            return '';
        }

        return function () use ($svg) {
            return '<svg xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(["width" => "1em", "height" => "1em", "viewBox" => "0 0 24 24"]) }}>' . $svg . '</svg>';
        };
    }
}
