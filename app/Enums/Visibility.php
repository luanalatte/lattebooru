<?php

namespace App\Enums;

enum Visibility: int
{
    case PUBLIC = 0;
    case PRIVATE = 1;
    case HIDDEN = 2;

    public function toString(): string
    {
        return match($this) {
            self::PUBLIC => __('Public'),
            self::PRIVATE => __('Private'),
            self::HIDDEN => __('Hidden')
        };
    }

    public function toArray(): array
    {
        return [
            'id' => $this->value,
            'name' => $this->toString()
        ];
    }
}
