<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CourseWideCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $state, $stateBtnColor;
    public $image;
    public $title;
    public $link;
    public $description;
    public $difficulty;
    public $levels;
    public $time;
    public $difficultyNumber, $progressColor;

    public function __construct($state, $image, $title, $link, $description, $difficulty, $levels, $time)
    {
        $this->state        = $state;
        $this->image        = $image;
        $this->title        = $title;
        $this->link         = $link;
        $this->description  = $description;
        $this->levels       = $levels;
        switch($difficulty){
            case $time >= 60:
                $this->time = round($time/60,0,PHP_ROUND_HALF_DOWN) . "h " . $time%60 . "m";
            break;
            case $time < 60:
                $this->time =  $time . "m";
            break;
        }
        
        
        switch($difficulty){
            case "easy":
            case "Easy":
            case "EASY":
                $this->difficulty   = "Easy";
                $this->difficultyNumber="20";
                $this->progressColor="success";
            break;
            case "inter":
            case "Inter":
            case "INTER":
            case "intermediate":
            case "Intermediate":
            case "INTERMEDIATE":
                $this->difficulty   = "INTER";
                $this->difficultyNumber="50";
                $this->progressColor="warning";
            break;
            case "difficult":
            case "Difficult":
            case "DIFFICULT":
            case "hard":
            case "Hard":
            case "HARD":
                $this->difficulty   = "Difficult";
                $this->difficultyNumber="100";
                $this->progressColor="danger";
            break;
        }
        switch($state){
            case "In progress":
                $this->stateBtnColor="rgba(255, 187, 0)";
            break;
            case "Complete":
                $this->stateBtnColor="rgb(49, 202, 138)";
            break;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.Course-wide-card');
    }
}
