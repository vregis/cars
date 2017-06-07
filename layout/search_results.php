<?php include 'header.php'; ?>

        <!-- Search Block -->   
        <form action="" method="GET" class="form-horizontal" id="main-search">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="abc" class="control-label col-xs-12 col-sm-4">Location</label>
                            <div class="col-xs-12 col-sm-8">
                                <input type="text" placeholder="Paris, France" class="form-control">
                            </div>
                        </div>       
                        <div class="form-group">
                            <label for="abc" class="control-label col-xs-12 col-sm-4">Type</label>
                            <div class="col-xs-12 col-sm-8">
                                <select class="form-control selectpicker">
                                    <option value="" disabled selected>Select category...</option>
                                    <option value="1">First item</option>
                                    <option value="1">Second item</option>
                                    <option value="1">Third item</option>
                                </select>
                            </div>
                        </div>                        
                    </div>  
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="abc" class="control-label col-xs-12 col-sm-4">Date Period</label>
                            <div class="col-xs-12 col-sm-8">
                                <span class="date-icon"><i class="fa fa-calendar"></i></span><input type="text" placeholder="Set actual dates..." class="form-control daterangepicker">
                            </div>
                        </div>       
                        <div class="form-group">
                            <label for="abc" class="control-label col-xs-12 col-sm-4">Rating</label>
                            <div class="col-xs-12 col-sm-8">
                                <ul class="star-rating">
                                    <li data-value="6"><i class="fa fa-star-o"></i></li>
                                    <li data-value="7"><i class="fa fa-star-o"></i></li>
                                    <li data-value="8"><i class="fa fa-star-o"></i></li>
                                    <li data-value="9"><i class="fa fa-star-o"></i></li>
                                    <li data-value="10"><i class="fa fa-star-o"></i></li>
                                    <li class="star-result"><input type="hidden" value="" name="rating"> <span>all</span> offers</li>
                                </ul>
                            </div>
                        </div>                        
                    </div>  
                </div>   
                <div class="collapse" id="advanced-search">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="abc" class="control-label col-xs-12 col-sm-4">Additional</label>
                                <div class="col-xs-12 col-sm-8">
                                    <input type="text" placeholder="More options..." class="form-control">
                                </div>
                            </div>                          
                        </div>  
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="abc" class="control-label col-xs-12 col-sm-4">Additional</label>
                                <div class="col-xs-12 col-sm-8">
                                    <input type="text" placeholder="More options..." class="form-control">
                                </div>
                            </div>                     
                        </div>  
                    </div> 
                </div>             
            </div>
            <div class="search-subbar">  
                <div class="container">
                    <div class="row">   
                        <div class="col-xs-12 col-sm-4 col-md-4 col-md-offset-2">
                            <a href="#advanced-search" class="more-options dashed" data-toggle="collapse" aria-expanded="false" aria-controls="advanced-search">Get more search options</a>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-6">
                            <span class="hidden-xs">Sort Order</span>
                            <a href="#" class="results-sort">by Price <i class="fa fa-caret-down"></i></a>
                            <a href="#" class="results-sort">by Rating <i class="fa fa-caret-down"></i></a>
                            <a href="#" class="results-sort">by Date <i class="fa fa-caret-down"></i></a>
                        </div>
                    </div>                
                </div>                
            </div>
        </form>
        
        <div id="search-results-cover">
            <div id="search-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d141212.6603291652!2d2.275644886002968!3d48.87873595360624!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e1f06e2b70f%3A0x40b82c3688c9460!2z0J_QsNGA0LjQtiwg0KTRgNCw0L3RhtGW0Y8!5e0!3m2!1suk!2sua!4v1448355429452" frameborder="0" style="border:0; height: 100%;" allowfullscreen></iframe>
            </div>
            <div id="search-results-list">
                <div class="row offer-short-info">
                    <div class="col-xs-12 col-md-4 col-lg-3 offer-preview">
                        <a href="#" class="offer-image"><img src="resources/offer.jpg" class="img-responsive"></a>
                        <a href="#" class="offer-fav"><i class="fa fa-heart-o"></i></a>
                        <div class="owner-info">
                            <a href="#"><img src="resources/sq_owner.jpg"></a>
                            <a href="#">Russell J.</a>
                            <p class="star-rating-small"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-8 col-lg-9 offer-description">
                        <h2><a href="#">Custom Bicycle Chopper Bike <span>[2014]</span></a></h2>
                        <div class="offer-stats">
                            <p class="star-rating-medium"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></p>
                            <p><a href="#" class="text-primary">19 reviews</a>&nbsp;&nbsp;-&nbsp;&nbsp;<span class="text-warning">219 saves</span>&nbsp;&nbsp;-&nbsp;&nbsp;<span class="text-muted">1 247 views</span></p>
                        </div>
                        <p class="offer-price">$34<span class="old-price"> / 650 UAH</span></p>
                        <p class="offer-more"><a href="#">Read more...</a></p>
                        <p class="offer-details">
                            <span class="pull-right">since 17.10.2015</span>
                            10748, Paris, Rue de Bobigny, 17
                        </p>
                    </div>
                </div>
                <div class="row offer-short-info">
                    <div class="col-xs-12 col-md-4 col-lg-3 offer-preview">
                        <a href="#" class="offer-image"><img src="resources/offer.jpg" class="img-responsive"></a>
                        <a href="#" class="offer-fav"><i class="fa fa-heart-o"></i></a>
                        <div class="owner-info">
                            <a href="#"><img src="resources/sq_owner.jpg"></a>
                            <a href="#">Russell J.</a>
                            <p class="star-rating-small"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-8 col-lg-9 offer-description">
                        <h2><a href="#">Custom Bicycle Chopper Bike <span>[2014]</span></a></h2>
                        <div class="offer-stats">
                            <p class="star-rating-medium"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></p>
                            <p><a href="#" class="text-primary">19 reviews</a>&nbsp;&nbsp;-&nbsp;&nbsp;<span class="text-warning">219 saves</span>&nbsp;&nbsp;-&nbsp;&nbsp;<span class="text-muted">1 247 views</span></p>
                        </div>
                        <p class="offer-price">$34<span class="old-price"> / 650 UAH</span></p>
                        <p class="offer-more"><a href="#">Read more...</a></p>
                        <p class="offer-details">
                            <span class="pull-right">since 17.10.2015</span>
                            10748, Paris, Rue de Bobigny, 17
                        </p>
                    </div>
                </div>
                <div class="row offer-short-info">
                    <div class="col-xs-12 col-md-4 col-lg-3 offer-preview">
                        <a href="#" class="offer-image"><img src="resources/offer.jpg" class="img-responsive"></a>
                        <a href="#" class="offer-fav"><i class="fa fa-heart-o"></i></a>
                        <div class="owner-info">
                            <a href="#"><img src="resources/sq_owner.jpg"></a>
                            <a href="#">Russell J.</a>
                            <p class="star-rating-small"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-8 col-lg-9 offer-description">
                        <h2><a href="#">Custom Bicycle Chopper Bike <span>[2014]</span></a></h2>
                        <div class="offer-stats">
                            <p class="star-rating-medium"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></p>
                            <p><a href="#" class="text-primary">19 reviews</a>&nbsp;&nbsp;-&nbsp;&nbsp;<span class="text-warning">219 saves</span>&nbsp;&nbsp;-&nbsp;&nbsp;<span class="text-muted">1 247 views</span></p>
                        </div>
                        <p class="offer-price">$34<span class="old-price"> / 650 UAH</span></p>
                        <p class="offer-more"><a href="#">Read more...</a></p>
                        <p class="offer-details">
                            <span class="pull-right">since 17.10.2015</span>
                            10748, Paris, Rue de Bobigny, 17
                        </p>
                    </div>
                </div>
                <div class="row offer-short-info">
                    <div class="col-xs-12 col-md-4 col-lg-3 offer-preview">
                        <a href="#" class="offer-image"><img src="resources/offer.jpg" class="img-responsive"></a>
                        <a href="#" class="offer-fav"><i class="fa fa-heart-o"></i></a>
                        <div class="owner-info">
                            <a href="#"><img src="resources/sq_owner.jpg"></a>
                            <a href="#">Russell J.</a>
                            <p class="star-rating-small"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-8 col-lg-9 offer-description">
                        <h2><a href="#">Custom Bicycle Chopper Bike <span>[2014]</span></a></h2>
                        <div class="offer-stats">
                            <p class="star-rating-medium"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></p>
                            <p><a href="#" class="text-primary">19 reviews</a>&nbsp;&nbsp;-&nbsp;&nbsp;<span class="text-warning">219 saves</span>&nbsp;&nbsp;-&nbsp;&nbsp;<span class="text-muted">1 247 views</span></p>
                        </div>
                        <p class="offer-price">$34<span class="old-price"> / 650 UAH</span></p>
                        <p class="offer-more"><a href="#">Read more...</a></p>
                        <p class="offer-details">
                            <span class="pull-right">since 17.10.2015</span>
                            10748, Paris, Rue de Bobigny, 17
                        </p>
                    </div>
                </div>
                <div class="row offer-short-info">
                    <div class="col-xs-12 col-md-4 col-lg-3 offer-preview">
                        <a href="#" class="offer-image"><img src="resources/offer.jpg" class="img-responsive"></a>
                        <a href="#" class="offer-fav"><i class="fa fa-heart-o"></i></a>
                        <div class="owner-info">
                            <a href="#"><img src="resources/sq_owner.jpg"></a>
                            <a href="#">Russell J.</a>
                            <p class="star-rating-small"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-8 col-lg-9 offer-description">
                        <h2><a href="#">Custom Bicycle Chopper Bike <span>[2014]</span></a></h2>
                        <div class="offer-stats">
                            <p class="star-rating-medium"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></p>
                            <p><a href="#" class="text-primary">19 reviews</a>&nbsp;&nbsp;-&nbsp;&nbsp;<span class="text-warning">219 saves</span>&nbsp;&nbsp;-&nbsp;&nbsp;<span class="text-muted">1 247 views</span></p>
                        </div>
                        <p class="offer-price">$34<span class="old-price"> / 650 UAH</span></p>
                        <p class="offer-more"><a href="#">Read more...</a></p>
                        <p class="offer-details">
                            <span class="pull-right">since 17.10.2015</span>
                            10748, Paris, Rue de Bobigny, 17
                        </p>
                    </div>
                </div>
            </div>
        </div>

<?php include 'footer.php'; 