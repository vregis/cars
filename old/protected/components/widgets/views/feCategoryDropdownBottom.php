<div class="search-type-container animated">
    <div class="container">
        <div class="content-block">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#earth" aria-controls="earth" role="tab" data-toggle="tab">
                        <?= CHtml::image(Yii::app()->themeManager->getTheme('frontend')->baseUrl.'/img/home-ground-sq.jpg', Yii::t('app', 'Earth'), array('class' => 'img-circle')) ?>
                        <?= Yii::t('app', 'Earth'); ?>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#water" aria-controls="water" role="tab" data-toggle="tab">
                        <?= CHtml::image(Yii::app()->themeManager->getTheme('frontend')->baseUrl.'/img/home-water-sq.jpg', Yii::t('app', 'Water'), array('class' => 'img-circle')) ?>
                        <?= Yii::t('app', 'Water'); ?>
                    </a></li>
                <li role="presentation">
                    <a href="#air" aria-controls="air" role="tab" data-toggle="tab">
                        <?= CHtml::image(Yii::app()->themeManager->getTheme('frontend')->baseUrl.'/img/home-air-sq.jpg', Yii::t('app', 'Air'), array('class' => 'img-circle')) ?>
                        <?= Yii::t('app', 'Air'); ?>
                    </a></li>
            </ul>
            
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="earth">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <?php
                                $top_categories = Categories::getListDataWithoutChildren(1);
                                
                                $this->widget('zii.widgets.CMenu',array(
                                    'encodeLabel'=>false,
                                    'firstItemCssClass'=>'first',
                                    'items'=>$top_categories,
                                    'htmlOptions'=>array('class' => 'topcategories'),
                                ));
                            ?>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <?php
                                $all_subcategories = array();
                                if (!empty($top_categories))
                                    foreach ($top_categories as $category) {
                                        $id = $category['linkOptions']['data-id'];
                                        $second_categories = Categories::getListDataWithoutChildren($id);

                                        $this->widget('zii.widgets.CMenu',array(
                                            'id'=>'subcats-'.$id,
                                            'encodeLabel'=>false,
                                            'firstItemCssClass'=>'first',
                                            'items'=>$second_categories,
                                            'htmlOptions'=>array('class' => 'subcategories'),
                                        )); 
                                        
                                        $all_subcategories = array_merge($all_subcategories, $second_categories);
                                    }
                            ?>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <?php
                                if (!empty($all_subcategories))
                                    foreach ($all_subcategories as $category) {
                                        $id = $category['linkOptions']['data-id'];
                                        $second_categories = Categories::getListDataWithoutChildren($id);

                                        $this->widget('zii.widgets.CMenu',array(
                                            'id'=>'subcats-'.$id,
                                            'encodeLabel'=>false,
                                            'firstItemCssClass'=>'first',
                                            'items'=>$second_categories,
                                            'htmlOptions'=>array('class' => 'subcategories'),
                                        )); 
                                    }
                            ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="water">  
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <?php
                                $top_categories = Categories::getListDataWithoutChildren(2);
                                
                                $this->widget('zii.widgets.CMenu',array(
                                    'encodeLabel'=>false,
                                    'firstItemCssClass'=>'first',
                                    'items'=>$top_categories,
                                    'htmlOptions'=>array('class' => 'topcategories'),
                                ));
                            ?>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <?php
                                $all_subcategories = array();
                                if (!empty($top_categories))
                                    foreach ($top_categories as $category) {
                                        $id = $category['linkOptions']['data-id'];
                                        $second_categories = Categories::getListDataWithoutChildren($id);

                                        $this->widget('zii.widgets.CMenu',array(
                                            'id'=>'subcats-'.$id,
                                            'encodeLabel'=>false,
                                            'firstItemCssClass'=>'first',
                                            'items'=>$second_categories,
                                            'htmlOptions'=>array('class' => 'subcategories'),
                                        )); 
                                        
                                        $all_subcategories = array_merge($all_subcategories, $second_categories);
                                    }
                            ?>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <?php
                                if (!empty($all_subcategories))
                                    foreach ($all_subcategories as $category) {
                                        $id = $category['linkOptions']['data-id'];
                                        $second_categories = Categories::getListDataWithoutChildren($id);

                                        $this->widget('zii.widgets.CMenu',array(
                                            'id'=>'subcats-'.$id,
                                            'encodeLabel'=>false,
                                            'firstItemCssClass'=>'first',
                                            'items'=>$second_categories,
                                            'htmlOptions'=>array('class' => 'subcategories'),
                                        )); 
                                    }
                            ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="air">      
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <?php
                                $top_categories = Categories::getListDataWithoutChildren(3);
                                
                                $this->widget('zii.widgets.CMenu',array(
                                    'encodeLabel'=>false,
                                    'firstItemCssClass'=>'first',
                                    'items'=>$top_categories,
                                    'htmlOptions'=>array('class' => 'topcategories'),
                                ));
                            ?>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <?php
                                $all_subcategories = array();
                                if (!empty($top_categories))
                                    foreach ($top_categories as $category) {
                                        $id = $category['linkOptions']['data-id'];
                                        $second_categories = Categories::getListDataWithoutChildren($id);

                                        $this->widget('zii.widgets.CMenu',array(
                                            'id'=>'subcats-'.$id,
                                            'encodeLabel'=>false,
                                            'firstItemCssClass'=>'first',
                                            'items'=>$second_categories,
                                            'htmlOptions'=>array('class' => 'subcategories'),
                                        )); 
                                        
                                        $all_subcategories = array_merge($all_subcategories, $second_categories);
                                    }
                            ?>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <?php
                                if (!empty($all_subcategories))
                                    foreach ($all_subcategories as $category) {
                                        $id = $category['linkOptions']['data-id'];
                                        $second_categories = Categories::getListDataWithoutChildren($id);

                                        $this->widget('zii.widgets.CMenu',array(
                                            'id'=>'subcats-'.$id,
                                            'encodeLabel'=>false,
                                            'firstItemCssClass'=>'first',
                                            'items'=>$second_categories,
                                            'htmlOptions'=>array('class' => 'subcategories'),
                                        )); 
                                    }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr />
            
            <div class="row">
                <div class="col-xs-12 col-sm-9">
                    <ul id="selected-types">
                        <li><?= Yii::t('app', 'Selected types') ?>:</li>
                        <?php
                        if (!empty($_GET['t'])) {
                            $types = explode(',',$_GET['t']);
                            
                            if (!empty($types)) {
                                $criteria = new CDbCriteria();
                                $criteria->addInCondition('id', $types);
                                $selected_categories = Categories::model()->findAll($criteria);
                                
                                if (!empty($selected_categories))
                                    foreach ($selected_categories as $category) {
                                        echo '<li data-id="'.$category->id.'"><a href="#">'.$category->name.'<i class="fa fa-times"></i></a></li>';
                                    }
                            }
                        }
                        ?>
                    </ul>
                </div>  
                <div class="col-xs-12 col-sm-3">
                    <a href="#" class="btn btn-success btn-block btn-accept-types"><?= Yii::t('app', 'Apply selection'); ?></a>
                </div>
            </div>  
        </div>  
    </div>  

    <div class="categories-dropdown-litter"></div>    
</div>

<div class="categories-dropdown-litter"></div>    