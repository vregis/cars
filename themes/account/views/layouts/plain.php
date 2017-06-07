<!DOCTYPE html>
<html>
<head>

    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/jquery-2.1.4.min.js"></script>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<!--[if IE]>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow" />
    <base target="_parent" />
    <title><?= CHtml::encode($this->pageTitle) ?></title>
    <!-- ////////////////////////////////// -->
    <!-- //      Start Stylesheets       // -->
    <!-- ////////////////////////////////// -->
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/select2.min.css">
	<link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/bootstrap-select/bootstrap-select.min.css">
    
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/animate.css">
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/dialog.css">

    <!-- CSS Files -->
    <link href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/emoji.css" rel="stylesheet" type="text/css" />
    
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,700italic,700|Roboto+Condensed:400,300,300italic,400italic,700italic,700|Roboto+Slab:400,700,300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
        <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/ie8-responsive-file-warning.js"></script>
    <![endif]-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   
</head>
<body>   
    
    <div class="container-fluid">
        
        <!-- Content -->
        <?php echo $content; ?>
        
    </div>
    
    <!-- JavaScript Files -->
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/bootstrap.min.js"></script>    
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/dialog.js"></script>
</body>
</html>