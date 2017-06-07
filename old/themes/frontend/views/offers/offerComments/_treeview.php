<?php
    foreach ($comments as $comment) {
        $this->renderPartial('/offerComments/_view', array('data' => $comment));
    }

