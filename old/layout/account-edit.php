<?php include 'header.php'; ?>

        <!-- Account -->   
        <div class="container top-block">
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-lg-2 account-menu">
                    <?php include 'account_menu.php'; ?>
                </div>
                <div class="col-xs-12 col-sm-9 col-lg-10">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#">General Info</a></li>
                        <li><a href="#">Comments</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Orders History</a></li>
                    </ul>
                    
                    <div class="account-content">
                        <br />
                        <div class="row">
                            <div class="col-xs-12 col-sm-3">
                                <img src="resources/offer.jpg" class="img-responsive">
                                <p class="text-right service-link"><a href="#">+ Manage photos</a></p>
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label class="control-label">Title:</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Description:</label>
                                        <textarea class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Rental Information:</label>
                                        <textarea class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <a href="#" class="btn btn-success btn-submit">Save Changes <i class="fa fa-angle-right"></i></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php include 'footer.php'; 