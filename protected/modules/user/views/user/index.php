                                
                                <div class="bar_right pro">
                                    <h1>Каталог подрядчиков</h1>  

                                    <?php $this->widget('zii.widgets.CListView', array(
                                        'dataProvider'=>$dataProvider,
                                        'itemView'=>'/user/_view',
                                        'summaryText'=>false,
                                    )); ?>
                                </div>                                

                                <div class="bar_left pro">
                                    <h5>Фильтры</h5>
                                    <ul>
                                        <li class="active"><?php echo CHtml::link('Общий список', array('/users'), array('class'=>'black')); ?></li>
                                        <li class="select"><?php echo CHtml::link('Каталог', array('/categories'), array('class'=>'black')); ?></li>
                                    </ul>                                    
                                </div>

