<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ImportForm extends Component
{
    public $route;
    public $label;
    public $cancelRoute;

    public function __construct($route, $label, $cancelRoute)
    {
        $this->route = $route;
        $this->label = $label;
        $this->cancelRoute = $cancelRoute;
    }

    public function render()
    {
        return view('components.import-form');
    }
}
