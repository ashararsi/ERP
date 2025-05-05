<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ImportForm extends Component
{
    public $route;
    public $label;
    public $cancelRoute;
    public $sampleFile;

    public function __construct($route, $label, $cancelRoute, $sampleFile = null)
    {
        $this->route = $route;
        $this->label = $label;
        $this->cancelRoute = $cancelRoute;
        $this->sampleFile = $sampleFile;
    }

    public function render()
    {
        return view('components.import-form');
    }
}
