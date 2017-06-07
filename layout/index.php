<?php include 'header.php'; ?>

        <!-- Home search -->
        <div id="home-search">
            <div id="home-search-bg">
                <div class="home-search-cover" style="background-image: url(resources/screen-1.jpg);">
                    <video muted loop>
                        <source src="resources/home-video-1.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="home-search-cover hidden-xs" style="background-image: url(resources/screen-2.jpg);">
                    <video muted loop>
                        <source src="resources/home-video-2.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="home-search-cover hidden-xs" style="background-image: url(resources/screen-3.jpg);">
                    <video muted loop>
                        <source src="resources/home-video-3.mp4" type="video/mp4">
                    </video>
                </div>
            </div>
            <div class="container text-center">
                <h1 class="display-inblock">Smart way to Rent a Vehicle</h1><br />
                <p class="display-inblock">Best offers from owners all over the world</p>
                <div class="row text-left">
                    <div class="col-xs-12 col-md-8 col-md-offset-2">
                        
                        <form action="" method="GET">
                            <label for="home-search-input" class="hidden-xs">Location</label><input type="text" id="home-search-input" placeholder="e.g. Paris, France"><a href="#" class="btn-submit"><i class="fa fa-map-o"></i></a>
                            <ul id="home-search-results">
                                <li class="first">Search results:</li>
                                <li><a href="#"><i class="fa fa-fw fa-map-marker"></i><span class="text-success">Par</span>is Il de France, France — иконка для области, района, страны</a></li>
                                <li><a href="#"><i class="fa fa-fw fa-compass"></i>New <span class="text-success">Yor</span>k, United States — иконка для города</a></li>
                                <li><a href="#"><i class="fa fa-fw fa-building-o"></i>Cal<span class="text-success">ifo</span>rnia str., United States — иконка для улицы</a></li>
                                <li><a href="#"><i class="fa fa-fw fa-plane"></i>Man<span class="text-success">hat</span>tan, United States — иконка для аэропорта</a></li>
                            </ul>
                        </form>
                    </div>  
                </div>  
            </div>  
        </div>  
        
        <!-- Top Promo -->   
        <div class="container">
            <div class="row info-block">
                <div class="col-xs-12 col-md-5 col-md-offset-1">
                    <img src="img/home-top-photo.jpg" class="img-responsive">
                </div>
                <div class="col-xs-12 col-md-5">
                    <h1 class="half-header">Rent your transport for those who need it</h1>
                    <p class="lead">Earn on a transport you don’t use, renting it for travelers and tourists.</p>

                    <p>
                    <a href="#" class="btn btn-success">Become an Owner <i class="fa fa-angle-right"></i></a>
                    <a href="#" class="btn btn-info pull-right xs-no-float btn-margins">How It Works <i class="fa fa-angle-right"></i></a>
                    </p>
                </div>  
            </div>  
        </div>
        
        <!-- Quick Search --> 
        <div class="info-block">
            <hr />
            <div class="container">
                <form action="" method="GET" class="row" id="home-quick-search">  
                    <div class="col-xs-12 col-md-3 col-lg-2">
                        <h3>Quick Search:</h3>
                    </div>    
                    <div class="col-xs-12 col-md-3 col-lg-4">
                        <select class="form-control selectpicker">
                            <option value="0" disabled selected>Select category...</option>
                            <option value="0">Item 1</option>
                            <option value="1">Item 2</option>
                            <option value="2">Item 3</option>
                        </select>
                    </div>   
                    <div class="col-xs-12 col-md-3 col-lg-4">
                        <select class="form-control selectpicker">
                            <option value="0" disabled selected>Select type...</option>
                            <option value="0">Item 1</option>
                            <option value="1">Item 2</option>
                            <option value="2">Item 3</option>
                        </select>
                    </div>   
                    <div class="col-xs-12 col-md-3 col-lg-2">
                        <a href="#" class="btn btn-muted btn-submit"><i class="fa fa-search fa-before"></i> Search</a>
                    </div>  
                </form>  
            </div>  
            <hr />
        </div>  
        
        <!-- Top Promo -->   
        <div class="container">
            <div class="row info-block">
                <div class="col-xs-12 home-categories-preview">
                    <h1 class="text-center zero-header">Explore new horizons</h1>
                    <p class="text-center">See what tourists actually use to achieve new impression, all over the world.</p>
                </div>  
                <div class="col-xs-12 col-md-4 home-categories">
                    <img src="resources/home-cruiser.jpg" class="img-responsive">
                    <div>
                        <h4>Cruiser Bikes</h4>
                        <p>@</p>
                        <p><a href="#">LA, United States</a></p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 home-categories">
                    <img src="resources/home-bicycle.jpg" class="img-responsive">
                    <div>
                        <h4>Travel Bicycles</h4>
                        <p>@</p>
                        <p><a href="#">Paris, France</a></p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 home-categories">
                    <img src="resources/home-paraplane.jpg" class="img-responsive">
                    <div>
                        <h4>Paragliding</h4>
                        <p>@</p>
                        <p><a href="#">Olu Deniz, Turkey</a></p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 home-categories">
                    <img src="resources/home-boat.jpg" class="img-responsive">
                    <div>
                        <h4>Fishing Boats</h4>
                        <p>@</p>
                        <p><a href="#">Kharkiv, Ukraine</a></p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-8 home-categories">
                    <img src="resources/home-parachute.jpg" class="img-responsive">
                    <div>
                        <h4>Parachute Jumps</h4>
                        <p>@</p>
                        <p><a href="#">CA, United States</a></p>
                    </div>
                </div>
            </div>  
        </div>  
        
        <!-- Bundles Block -->   
        <div id="mountains-bg">
            <div class="container">
                <div class="row info-block">
                    <div class="col-xs-12 col-md-7 col-md-offset-1">
                        <h2 class="text-success half-header">Have a Big Travel? Check Bundles!</h2>
                        <p class="small-lead">The movement of the rotor requires more attention to the analysis of errors that gives the pitch. However, the study of the problem in a more rigorous formulation shows that the integral of variable integrates the moment.</p>
                        <p class="small-lead">The angular velocity of the gyroscopic effect on the components of the moment more than a resonance angular momentum of its own in accordance with the system of equations.</p>
                        <p><br /><a href="#" class="btn btn-success">Get more info <i class="fa fa-angle-right"></i></a><br /><br /></p>
                        <div class="row">
                            <div class="col-m-12 col-sm-8 col-sm-offset-4">
                                <p class="small-lead">The consumer society allows convergent reach. Changing global strategy reverses the strategic product placement. Behavioral Targeting multifaceted organizes a popular advertising brief.</p>
                                <p class="small-lead">Building a brand is concentrating convergent ad unit, gaining market segment. Youth audience specifies booth, increasing competition. CTR attracted enough daily ranking.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 hidden-xs hidden-sm col-sm-4"> 
                        <img src="resources/home-bundles.jpg" class="img-responsive">
                    </div>
                </div> 
                
                <div class="row info-block">
                    <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1">
                        <div class="home-areas-cover">
                            <div class="home-areas">
                                <a href="#"><img src="img/home-ground.jpg" class="img-responsive"></a>
                                <div>
                                    <i class="fa fa-bicycle"></i>
                                    <h4>Vehicles</h4>
                                    <p>cars, bikes, bicycles</p>
                                </div>
                            </div>
                            <p>Behavioral Targeting multifaceted organizes a popular advertising brief.</p>
                            <p>CTR attracted enough daily ranking. Monitoring the activity of an empirical intuition enhances BTL.</p>
                            <p><a href="#" class="btn btn-success btn-block">Set location & Search</a></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1">
                        <div class="home-areas-cover">
                            <div class="home-areas">
                                <a href="#"><img src="img/home-water.jpg" class="img-responsive"></a>
                                <div>
                                    <i class="fa fa-ship"></i>
                                    <h4>Boats</h4>
                                    <p>ships, speed-boats</p>
                                </div>
                            </div>
                            <p>Behavioral Targeting multifaceted organizes a popular advertising brief.</p>
                            <p>CTR attracted enough daily ranking. Monitoring the activity of an empirical intuition enhances BTL.</p>
                            <p><a href="#" class="btn btn-success btn-block">Set location & Search</a></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1">
                        <div class="home-areas-cover">
                            <div class="home-areas">
                                <a href="#"><img src="img/home-ground.jpg" class="img-responsive"></a>
                                <div>
                                    <i class="fa fa-plane"></i>
                                    <h4>Aircraft</h4>
                                    <p>planes, gliders</p>
                                </div>
                            </div>
                            <p>Behavioral Targeting multifaceted organizes a popular advertising brief.</p>
                            <p>CTR attracted enough daily ranking. Monitoring the activity of an empirical intuition enhances BTL.</p>
                            <p><a href="#" class="btn btn-success btn-block">Set location & Search</a></p>
                        </div>
                    </div>
                </div> 
            </div>   
        </div>  

<?php include 'footer.php'; 