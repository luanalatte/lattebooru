<?php

namespace App\View\Components\Sidebar;

use App\Http\Resources\TagResource;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TagList extends Component
{
    public function __construct(public $tags, public $title = 'Tags')
    {
        $this->tags = TagResource::collection($this->tags)->toArray(request());
    }

    public function render(): View|Closure|string
    {
        return view('components.sidebar.tag-list');
    }
}
