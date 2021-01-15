<div class="row course-box-container">
    <div class="col-12 course-box-light" style="background-image: url('{{$image}}');">
        <div class="row">
            <div class="col-12 col-md-6 course-box-icon">
                <div class="row">
                    <div class="col-12">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 course-box-content">
                <div class="row">
                    <div class="col-12">
                        <span class="course-state-label" style="background-color: {{$stateBtnColor}}">
                            {{$state}}
                        </span>
                        <h3 class="">
                            <a href="{{$link}}" class="course-link-name">
                                {{$title}}
                            </a>
                        </h3>
                        <p class="course-description">
                            {{$description}}
                        </p>
                    </div>
                    <div class="col-12 d-none d-sm-block">
                        <div class="row">
                            <div class="col-5  course-difficulty">
                                <div class="progress vertical progress-xxs" style="height: 20px;">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="{{$difficultyNumber}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$difficultyNumber}}%">
                                        <span class="sr-only">{{$difficulty}} Difficulty</span>
                                    </div> 
                                </div>{{$difficulty}}
                            </div>
                            <div class="col-4">
                                <i class="fab fa-buffer"></i> {{$levels}} Levels
                            </div>
                            <div class="col-3">
                                <i class="fas fa-clock"></i> {{$time}}
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <a href="#" class="start-course-link">
                                    <i class="far fa-play-circle fa-lg"></i> <span>Start Course</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>