<?php

namespace App\Enums;

use Illuminate\View\ComponentAttributeBag;

enum Settings: string
{
    case MAX_UPLOAD_SIZE = 'upload_max_size';
    case MAX_UPLOAD_DIMENSIONS = 'upload_max_dimensions';

    case POSTS_PAGE_SIZE = 'posts_page_size';

    case TAGS_TOP_COUNT = 'tags_top_count';

    case THUMBNAIL_DIMENSIONS = 'thumbnail_dimensions';
    case THUMBNAIL_FORMAT = 'thumbnail_format';
    case THUMBNAIL_QUALITY = 'thumbnail_quality';

    public function title(): string
    {
        return match ($this) {
            self::MAX_UPLOAD_SIZE => 'Max upload size',
            self::MAX_UPLOAD_DIMENSIONS => 'Max upload dimensions',
            self::POSTS_PAGE_SIZE => 'Posts per page',
            self::TAGS_TOP_COUNT => 'Number of tags on list',
            self::THUMBNAIL_DIMENSIONS => 'Thumbnail dimensions',
            self::THUMBNAIL_FORMAT => 'Thumbnail format',
            self::THUMBNAIL_QUALITY => 'Thumbnail quality',
            default => $this->value
        };
    }

    public function description(): string|null
    {
        return match ($this) {
            self::TAGS_TOP_COUNT => 'How many tags to show on the top tag lists.',
            self::THUMBNAIL_QUALITY => 'Applies only to lossy compression formats (jpeg, webp).',
            default => null,
        };
    }

    public function attributes(): ComponentAttributeBag
    {
        return new ComponentAttributeBag(match ($this) {
            self::POSTS_PAGE_SIZE, self::TAGS_TOP_COUNT => [
                'type' => 'number',
                'min' => 1,
                'step' => 1,
            ],
            self::MAX_UPLOAD_SIZE => [
                'type' => 'number',
                'min' => 1,
                'step' => 1,
            ],
            self::THUMBNAIL_DIMENSIONS, self::MAX_UPLOAD_DIMENSIONS => [
                'type' => 'number',
                'min' => 1,
                'step' => 1,
            ],
            self::THUMBNAIL_QUALITY => [
                'type' => 'number',
                'min' => 1,
                'max' => 100,
                'step' => 1,
            ],
            default => [
                'type' => 'text'
            ]
        });
    }

    public function inputType(): string
    {
        return match ($this) {
            self::THUMBNAIL_FORMAT => 'select',
            default => 'input'
        };
    }

    public function values(): array|null
    {
        return match ($this) {
            self::THUMBNAIL_FORMAT => ['JPEG', 'PNG'],
            default => null
        };
    }

    public function default(): mixed
    {
        return match ($this) {
            self::MAX_UPLOAD_SIZE => 20,
            self::MAX_UPLOAD_DIMENSIONS => 4000,
            self::POSTS_PAGE_SIZE => 24,
            self::TAGS_TOP_COUNT => 12,
            self::THUMBNAIL_DIMENSIONS => 250,
            self::THUMBNAIL_QUALITY => 90,
            default => null
        };
    }

    public function unit(): string|null
    {
        return match ($this) {
            self::MAX_UPLOAD_SIZE => 'MB',
            self::MAX_UPLOAD_DIMENSIONS, self::THUMBNAIL_DIMENSIONS => 'px',
            self::POSTS_PAGE_SIZE => 'posts',
            self::TAGS_TOP_COUNT => 'tags',
            self::THUMBNAIL_QUALITY => '%',
            default => null
        };
    }

    public function rules(): array|string
    {
        return match ($this) {
            self::MAX_UPLOAD_SIZE => ['integer']
        };
    }

    protected function cast($value)
    {
        return match ($this) {
            self::POSTS_PAGE_SIZE, self::TAGS_TOP_COUNT => (int) $value,
            default => $value
        };
    }

    public function get()
    {
        return $this->cast(config('settings.' . $this->value, $this->default()));
    }
}
