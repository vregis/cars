<!DOCTYPE html>
<html>
    <head>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="robots" content="index, follow" />
        <meta name="viewport" content="width=1280" />
        
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">

        <!-- Morris -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        
        <!-- iCheck -->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/plugins/iCheck/custom.css" rel="stylesheet">

        <!-- Toastr style -->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/plugins/toastr/toastr.min.css" rel="stylesheet">

        <!-- Select2 -->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/select2.min.css" rel="stylesheet">

        <!-- Datepicker -->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
        
        <!-- Chosen instead of Combobox -->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/plugins/chosen/chosen.css" rel="stylesheet">

        <!-- ClockPicker -->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">

        <!-- Gritter -->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/animate.css" rel="stylesheet">        
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" rel="stylesheet">   
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/layout.css" rel="stylesheet">  
        
    </head>
    <body<?php if ($this->sidebar_minified == 1) echo ' class="mini-navbar"'; ?>>
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <?php echo $this->renderPartial('//layouts/sidebar'); ?>
                </div>
            </nav>

            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                            <form role="search" class="navbar-form-custom" method="GET" action="<?php echo Yii::app()->createUrl('/site/adminSearch'); ?>">
                                <div class="form-group">
                                    <input type="text" placeholder="Поиск по сайту..." class="form-control" name="text" id="top-search" autocomplete="off">
                                </div>
                            </form>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li>
                                <span class="m-r-sm text-muted welcome-message">Добро пожаловать в Панель управления MyRentClub!</span>
                            </li>
                            <li>
                                <?php echo CHtml::link('<i class="fa fa-sign-out"></i> Выйти', array('/user/logout/logout')); ?>
                            </li>
                        </ul>

                    </nav>
                </div>
                
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-9">
                        <h2><?php echo $this->title; ?></h2>
                        <?php $this->widget('application.components.widgets.beBreadcrumbs', array(
                            'links'=>$this->breadcrumbs,
                            'homeLink'=>CHtml::link('Панель управления', array('/site/admin')),
                        )); ?>
                    </div>
                </div>     

                <div class="wrapper wrapper-content animated fadeIn">

                    <?php echo $content; ?>
                    
                </div>

                <div class="footer fixed">
                    <div class="pull-right">
                        <a href="http://www.kretivz.pro/contact">Контакты разработчика</a>
                    </div>
                    <div>
                        <a href="http://www.kretivz.pro/">Создание сайта kretivz.pro</a> &copy; 2008 - <?php echo date('Y'); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mainly scripts -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Flot -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/flot/jquery.flot.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/flot/jquery.flot.spline.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/flot/jquery.flot.resize.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/flot/jquery.flot.pie.js"></script>

        <!-- Peity -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/peity/jquery.peity.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/demo/peity-demo.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/inspinia.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/pace/pace.min.js"></script>

        <!-- jQuery UI -->
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

        <!-- Morris -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

        <!-- GITTER -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/gritter/jquery.gritter.min.js"></script>

        <!-- Toastr -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script>

        <!-- EayPIE -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/easypiechart/jquery.easypiechart.js"></script>

        <!-- Sparkline -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/sparkline/jquery.sparkline.min.js"></script>

        <!-- Sparkline demo data  -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/demo/sparkline-demo.js"></script>

        <!-- Select2-->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/select2.min.js"></script>  
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/select2-ru.js"></script>  

        <!-- Datepicker-->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/datapicker/bootstrap-datepicker.js"></script>  

        <!-- ChartJS-->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/chartJs/Chart.min.js"></script>  

        <!-- iCheck -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/iCheck/icheck.min.js"></script>

        <!-- Clock picker -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/clockpicker/clockpicker.js"></script>


        <!-- Jquery Validate -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/validate/jquery.validate.min.js"></script>

        <!-- Chosen -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/chosen/chosen.jquery.js"></script>

        <!-- Listeners -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/listeners.js"></script>    

        
    </body>
</html>