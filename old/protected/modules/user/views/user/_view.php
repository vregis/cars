                                    <div class="detailed float_left">                                
                                        <?php echo CHtml::image(Yii::app()->request->hostInfo.'/resources/'.$data->profile->userpic, '', array('height'=>'64', 'class'=>'float_left')); ?>
                                        <p class="float_left date">
                                            <?php echo CHtml::link($data->profile->lastname.' '.$data->profile->firstname.' ('.$data->username.')', array('/user/user/view', 'username'=>$data->username)); ?><br />
                                            В сервисе: <span class="bold"><?php echo $this->ms2days(time() - $data->createtime);?></span><br /> 
                                            Работ в портфолио: <?php if (count($data->portfolios) > 0) echo CHtml::link(count($data->portfolios), array('/portfolios/userView', 'username'=>$data->username)); else echo 0; ?>
                                            <!--Отзывы: <a href="#">12</a> Рейтинг: <span class="bold green">37</span>-->
                                        </p>
                                        <p class="reports first"></p>
                                    </div>