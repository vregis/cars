<?php
    if (isset($date)) 
        $date_cur = new DateTime($date);
    else
        $date_cur = new DateTime(date('Y-m-d'));
    
    $day_is_free = true;
?>
    <h5 class="text-center">Schedule on <span><?= $date_cur->format('jS, F') ?></span></h5>
    <?php
    if (!empty($blocks)) {
        foreach ($blocks as $block) {
            $since = new DateTime($block->date_since);
            $for = new DateTime($block->date_for);
                    
            $cur_since = new DateTime($date_cur->format('Y-m-d').' 00:00:00');
            $cur_for = new DateTime($date_cur->format('Y-m-d').' 23:59:59');

            if (
                ($since <= $cur_since && $for > $cur_for) || 
                ($since >= $cur_since && $since <= $cur_for) || 
                ($for > $cur_since && $for <= $cur_for)
            ) {
                echo '<p>';
                echo 'Blocked period<span class="text-muted">'.$since->format('j, F Y, H:i').' &ndash; '.$for->format('j, F Y, H:i').'</span>';
                echo '<small>'.CHtml::link(
                    '[ remove ]', 
                    array('delete', 'id' => $block->id), 
                    array(
                        'class' => 'delete-link no-decor',
                        'data-block-id' => $block->id
                    )
                ).'</small>';
                echo '</p>';
                $day_is_free = false;
            }
        }
        
        if ($day_is_free)
            echo '<p class="text-center">Day is free.</p>';
    } else
        echo '<p class="text-center">Day is free.</p>';
    ?>  