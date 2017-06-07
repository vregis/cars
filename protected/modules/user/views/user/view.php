                                <div class="bar_right">
                                    <?php
                                    if (Yii::app()->user->id != $model->id) {
                                    ?>
                                    <div class="button">
                                        <?php echo CHtml::image(Yii::app()->request->hostInfo.'/images/button_purple_pro_left.jpg', '', array('class'=>'float_left')); ?>
                                            <?php echo CHtml::link('Написать письмо', array('/mailMessages/create', 'id'=>$model->id), array('class'=>'profile float_left'));?>
                                        <?php echo CHtml::image(Yii::app()->request->hostInfo.'/images/button_purple_pro_right.jpg', '', array('class'=>'float_left')); ?>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <h2><?php echo $profile->lastname.'&nbsp;'.$profile->firstname.'&nbsp;('.$model->username.')';?></h2>                                    
                                    <div class="profile_owner">
                                        <p>
                                        <?php echo nl2br(CHtml::encode($profile->about));?>
                                        </p>
                                    </div>
                                    <div class="foto">
                                        <?php if (!empty($profile->userpic)) echo CHtml::image(Yii::app()->request->hostInfo.'/resources/'.$profile->userpic, '', array('width'=>'200')); ?>
                                        <!--<h3>Рейтинг: <span class="<?php if ($model->rating >= 0) echo 'green'; else echo 'red';?>"><?php echo $model->rating;?></span></h3>-->
                                    </div>
                                </div>
                                
                                
                                <div class="bar_left">
                                    <?php 
                                    if ($model->is_approved == '1') {
                                    ?>
                                    <h5>Аккаунт подтвержден</h5>
                                    <p>Предоставлена разрешающая документация по соответствующим видам работ.</p>
                                    <?php
                                    }
                                    ?>
                                    <h5>Контактная информация</h5>
                                    <ul>
                                        <?php if (!empty($profile->phone)) { ?><li class="black"><span class="bold">Телефон: </span> <?php echo $profile->phone;?></li> <?php } ?>
                                        <?php if (!empty($profile->skype)) { ?><li class="black"><span class="bold">Skype: </span> <?php echo $profile->skype;?></li> <?php } ?>
                                        <?php if (!empty($profile->icq)) { ?><li class="black"><span class="bold">ICQ: </span> <?php echo $profile->icq;?></li> <?php } ?>
                                        <li class="black"><span class="bold">В сервисе: </span> <?php echo $this->ms2days(time() - $model->createtime);?></li>
                                    </ul>
                                    <h5>Общая информация</h5>
                                    <ul>
                                        <?php if (Yii::app()->user->id == $model->id) echo '<li class="select">'.CHtml::link('Редактировать профиль', array('/user/profile/edit'), array('class'=>'black')).'</li>';?>
                                        <?php echo '<li class="active">'.CHtml::link('Персональные данные', array('/user/profile'), array('class'=>'black')).'</li>';?>
                                        <?php echo '<li class="select">'.CHtml::link('Портфолио', array('/portfolios/userView', 'username' => $model->username), array('class'=>'black')).'</li>';?>
                                        <?php //echo '<li class="select">'.CHtml::link('Отзывы: 7/<span class="red">1</span>', array('/user/reports'), array('class'=>'black')).'</li>';?>
                                    </ul>                                    
                                </div>