<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

abstract class AbstractLayout extends Component
{
    public function __construct(public string $title = '')
    {
        $this->title = config('app.name') . ($title ? " | $title" : '');
    }
}