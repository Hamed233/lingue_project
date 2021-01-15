<?php

namespace App\View\Components\Dashboard;

use Illuminate\View\Component;

class CustomTabs extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $title;

    public function __construct($headerTitle="Sales")
    {
        $this->title = $headerTitle;
       
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.dashboard.CustomTabs');
    }
}
