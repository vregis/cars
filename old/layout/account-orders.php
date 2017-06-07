<?php include 'header.php'; ?>

        <!-- Account -->   
        <div class="container top-block">
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-lg-2 account-menu">
                    <?php include 'account_menu.php'; ?>
                </div>
                <div class="col-xs-12 col-sm-9 col-lg-10">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#">Active Orders</a></li>
                        <li><a href="#">Public Offers</a></li>
                        <li><a href="#">Archived Offers</a></li>
                    </ul>
                    
                    <div class="account-content">
                        <h3>Active Orders</h3>
                        
                        <div class="row order-view">
                            <div class="col-xs-12 col-sm-4 col-md-2 col-lg-3">
                                <a href="#"><img src="resources/offer.jpg" class="img-responsive"></a>
                                <ul class="order-view-tools">
                                    <li><a href="#" class="text-default"><i class="fa fa-pencil"></i></a></li>
                                    <li><a href="#" class="text-danger"><i class="fa fa-times"></i></a></li>
                                </ul>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-5">
                                <h4><a href="#">CATVOS XP900 arched lower arms</a></h4>
                                <p class="offer-view-client">ordered by <a href="#">Michele Brown</a></p>
                                <p class="price-block"><span class="text-success">$345</span> / 3240 UAH</p>
                                <p>
                                    <span class="text-muted">From:</span> 34, Rue Guillame Tell, Paris <i class="fa fa-map-marker"></i><br />
                                    <span class="text-muted">To:</span> 34, Rue Guillame Tell, Paris <i class="fa fa-map-marker"></i>
                                </p>
                            </div>
                            <div class="col-xs-12 col-md-5 col-lg-4">
                                <div class="order-details">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-5">
                                            <h5>Reception</h5>
                                            <big>5</big>
                                            <p>October, 2015</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-2">
                                            <span class="date-between">~</span>
                                        </div>
                                        <div class="col-xs-12 col-sm-5">
                                            <h5>Return</h5>
                                            <big>8</big>
                                            <p>October, 2015</p>
                                        </div>
                                    </div>
                                    <p class="text-center total-days">total 4 days</p>
                                </div>
                            </div>
                            
                            <hr />
                        </div>
                        
                        <h3>Archived Orders</h3>
                        
                        <table class="table archived-offers">
                            <thead>
                                <tr><th></th><th>Status</th><th>Reception</th><th>Return</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="archived-offer-name">
                                        <a href="#" class="archived-offer-preview"><img src="resources/sq_owner.jpg" class="img-responsive"></a>
                                        <a href="#" class="archived-offer-link">Custom Bicycle Chopper Bike</a> ordered by <a href="#">Michele Brown</a>
                                    </td>
                                    <td class="archived-offer-price"><big>$345</big> / 3240 UAH <span class="text-success">PAID</span></td>
                                    <td>3 Sep 2015, 11:30</td>
                                    <td>7 Sep 2015, 18:00</td>
                                </tr>
                                <tr>
                                    <td class="archived-offer-name">
                                        <a href="#" class="archived-offer-preview"><img src="resources/sq_owner.jpg" class="img-responsive"></a>
                                        <a href="#" class="archived-offer-link">CATVOS XP900 arched lower arms</a> ordered <a href="#">by Michele Brown</a>
                                    </td>
                                    <td class="archived-offer-price"><big>$280</big> / 2440 UAH <span class="text-danger">CANCELED</span></td>
                                    <td>1 Aug 2015, 10:00</td>
                                    <td>12 Aug 2015, 17:30</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

<?php include 'footer.php'; 