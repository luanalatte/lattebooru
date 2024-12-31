<?php

namespace App\Enums;

enum PostVisibility: int
{
    case PUBLIC = 0;
    case PRIVATE = 1;
    case HIDDEN = 2;

    public function toString(): string
    {
        return match($this) {
            self::PUBLIC => trans('post.visibility.public'),
            self::PRIVATE => trans('post.visibility.private'),
            self::HIDDEN => trans('post.visibility.hidden')
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
