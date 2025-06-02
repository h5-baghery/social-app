<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Section extends Component
{

    public $title;
    public $isActive;
    public $content;

    public function __construct($title, $isActive = false, $content = null)
    {
        $this->title = $title;
        $this->isActive = $isActive;
        $this->content = $content;
    }

    public function render(): View|Closure|string
    {
        return view('components.section');
    }
}
