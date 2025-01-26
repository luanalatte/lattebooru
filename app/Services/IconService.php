<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class IconService
{
    protected $iconSets = [];

    public function getIcon(string $set, string $icon)
    {
        if (isset($this->iconSets[$set]['icons'][$icon])) {
            return $this->iconSets[$set]['icons'][$icon];
        }

        if (!isset($this->iconSets[$set])) {
            $cachedSet = Cache::get("icons.$set");
            if ($cachedSet !== null) {
                $this->iconSets[$set] = $cachedSet;
                if (isset($cachedSet['icons'][$icon])) {
                    return $cachedSet['icons'][$icon];
                }
            }
        }

        logger()->info("Downloading '$icon' from iconify set '$set'.");
        $response = Http::get('https://api.iconify.design/' . $set . '.json', [
            'icons' => $icon
        ])->throw()->json();

        if (!isset($this->iconSets[$set])) {
            $this->iconSets[$set] = $response;
        } else {
            $this->iconSets[$set]['icons'][$icon] = $response['icons'][$icon];
        }

        Cache::put("icons.$set", $this->iconSets[$set], now()->addWeek());
        return $response['icons'][$icon];
    }
}
