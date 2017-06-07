<?php
/* @var $this ParametersCategoriesController */
/* @var $model ParametersCategories */

    $this->breadcrumbs=array(
        'Управление категориями'=>array('/categories/admin'),
        'Редактирование категории «'.$category->name.'»'=>array('/categories/update', 'id'=>$category->id),
        'Параметры'
    );

    $this->pageTitle = 'Параметры категории — '.Yii::app()->name;

    $this->title = 'Категории';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Параметры категории</h5>
        
        <div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
            <a class="close-link">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
    <div class="ibox-content">
        <form action="" method="POST">
            <div class="row form-group">
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <?php 
                        if (!empty($parameters_1))
                            foreach ($parameters_1 as $parameter) {
                                echo '<div class="checkbox i-checks"><label>';
                                echo '<input type="checkbox" name="parameters[]" value="'.$parameter->id.'" '.((in_array($parameter->id, $selected_parameters))?(' checked'):('')).'>&nbsp;&nbsp;&nbsp; '.$parameter->name;
                                echo '</label></div>';
                            }
                    ?>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <?php 
                        if (!empty($parameters_2))
                            foreach ($parameters_2 as $parameter) {
                                echo '<div class="checkbox i-checks"><label>';
                                echo '<input type="checkbox" name="parameters[]" value="'.$parameter->id.'" '.((in_array($parameter->id, $selected_parameters))?(' checked'):('')).'>&nbsp;&nbsp;&nbsp; '.$parameter->name;
                                echo '</label></div>';
                            }
                    ?>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <?php 
                        if (!empty($parameters_3))
                            foreach ($parameters_3 as $parameter) {
                                echo '<div class="checkbox i-checks"><label>';
                                echo '<input type="checkbox" name="parameters[]" value="'.$parameter->id.'" '.((in_array($parameter->id, $selected_parameters))?(' checked'):('')).'>&nbsp;&nbsp;&nbsp; '.$parameter->name;
                                echo '</label></div>';
                            }
                    ?>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;&nbsp; Применить изменения</button>
            </div>
        </form>
    </div>
</div>