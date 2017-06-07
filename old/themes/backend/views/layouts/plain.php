<!DOCTYPE html>
<html>
    <head>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-2.1.1.js"></script>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="robots" content="index, follow" />
        <meta name="viewport" content="width=1280" />
        
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
        
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/animate.css" rel="stylesheet">        
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" rel="stylesheet">   
        
    </head>
    <body class="gray-bg">
        <?php echo $content; ?>
        
        <!-- Mainly scripts -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.min.js"></script>        
    </body>
</html>