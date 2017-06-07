<?php
class LanguageSelector extends CWidget
{
    public function run()
    {
        $currentLang = Yii::app()->language;
        
        $this->render('languageSelector', array('currentLang' => $currentLang));
    }
}
?>