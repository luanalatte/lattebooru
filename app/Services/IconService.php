<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class IconService
{
    const API_URL = 'https://api.iconify.design';

    protected $iconSets = [];

    protected function downloadIcon(string $set, string $icon)
    {
        logger()->info("Downloading '$icon' from iconify set '$set'.");
        $response = Http::get(self::API_URL . "/$set.json", [
            'icons' => $icon
        ])->throw()->json();

        if (!isset($this->iconSets[$set]) || $response['lastModified'] > ($this->iconSets[$set]['lastModified'] ?? 0)) {
            $this->iconSets[$set] = $response;
        } else {
            $this->iconSets[$set] = array_merge_recursive($this->iconSets[$set], $response);
        }

        $this->iconSets[$set]['prefix'] = $response['prefix'] ?? $set;
        $this->iconSets[$set]['lastModified'] = $response['lastModified'] ?? 0;
        $this->iconSets[$set]['width'] = $response['width'] ?? 24;
        $this->iconSets[$set]['height'] = $response['height'] ?? 24;

        Cache::put("icons.$set", $this->iconSets[$set], now()->addWeek());
    }

    public function getAlias(string $set, string $icon): string
    {
        return $this->iconSets[$set]['aliases'][$icon]['parent'] ?? $icon;
    }

    public function getIcon(string $set, string $icon)
    {
        if (!isset($this->iconSets[$set])) {
            $this->iconSets[$set] = Cache::get("icons.$set", []);
        }

        $icon = $this->getAlias($set, $icon);

        if (isset($this->iconSets[$set]['icons'][$icon])) {
            return $this->iconSets[$set]['icons'][$icon];
        }

        $this->downloadIcon($set, $icon);

        $icon = $this->getAlias($set, $icon); // Refresh the alias

        return $this->iconSets[$set]['icons'][$alias ?? $icon] ?? throw new Exception("Icon not found: $set:$icon.");
    }
}
