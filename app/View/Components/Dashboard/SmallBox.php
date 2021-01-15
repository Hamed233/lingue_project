<?php

namespace App\View\Components\Dashboard;

use Illuminate\View\Component;

class SmallBox extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public  $colors=['bg-primary','bg-secondary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info'];
    public  $bgColor;
    public  $statistics;
    public  $title;
    public  $icon;
    public  $link;
    public  $detailsText;
    public function __construct($title = "Title", $icon = "", $bgColor="", $statistics="0", $link="javascript:void(0)", $detailsText="More info")
    {
         //
        if($bgColor == ""){
            $this->bgColor = $this->colors[rand(0,count($this->colors)-1)];
        }else{
            $this->bgColor = $bgColor;
        }
        $this->statistics       =   $statistics;
        $this->title            =   $title;
        $this->icon             =   $icon;
        $this->link             =   $link;
        $this->detailsText      =   $detailsText;
       
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $data=[
            'bgColor'=>$this->bgColor,
            'statistics'=> $this->statistics,
            'title' => $this->title,
            'icon' => $this->icon,
            'detailsText' => $this->detailsText
        ];
        return view('components.dashboard.SmallBox')->with($data);
    }
}
