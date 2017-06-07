<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
</head>
<body style="min-width: 800px;">
    <table border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto; width: 800px;">
        <tr>
            <td colspan="2">
                <br />
                <?php echo CHtml::link(CHtml::image(Yii::app()->request->hostInfo.'/themes/frontend/img/logo-mail.png', Yii::app()->name), Yii::app()->createAbsoluteUrl('/site/index')); ?>
                <br />
                <hr style="border: 0; border-bottom: 2px #ad0b32 solid; height: 0;" />
                <br />
            </td>
        </tr>
        <?php echo $content ?>
    </table>
</body>
</html>