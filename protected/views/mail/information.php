<tr>
    <td style="padding: 0 10px; font-size: 15px;" colspan="2">                     
        <?php echo $message; ?>
        <br /><br />
        <hr style="margin: 0 -10px; border: 0; border-bottom: 2px #ad0b32 solid; height: 0;" />
        <br />
    </td>
</tr>
<tr>
    <td style="padding: 0 0 0 10px; color: #848484; font-size: 12px; vertical-align: top;">
        <?php echo Yii::app()->name; ?><br />
        г. Харьков, ул. Котлова, 29<br />
        <?php echo CHtml::link('Контактная информация', Yii::app()->createAbsoluteUrl('/staticPages/default/view', array('url_name'=>'contacts'))); ?>
    </td>
    <td style="padding: 0 10px 0 0; color: #848484; font-size: 12px; text-align: right; vertical-align: top;">
        Читайте нас в <?php echo CHtml::link('Facebook', SiteVars::v('SOCIAL_FB')); ?><br />
        <?php echo CHtml::link('www.'.Yii::app()->request->serverName, Yii::app()->request->hostInfo); ?>
    </td>
</tr>

