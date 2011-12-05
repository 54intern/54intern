<?php
// $Id$

/*
+----------------------------------------------------------------+
|   Flexsys for Dupal 6.x - Version 1.0                          |
|   Copyright (C) 2009 Antsin.com All Rights Reserved.           |
|   @license - Copyrighted Commercial Software                   |
|----------------------------------------------------------------|
|   Theme Name: Flexsys                                          |
|   Description: Flexsys by Antsin                               |
|   Author: Antsin.com                                           |
|   Date: 7th November 2009                                      |
|   Website: http://www.antsin.com/                              |
|----------------------------------------------------------------+
|   This file may not be redistributed in whole or               |
|   significant part.                                            |
+----------------------------------------------------------------+
*/ 
?>
<?php 
$comment_link = l(t('Add new comment'), 'comment/reply/'. $node->nid, array('fragment' => 'comment-form'));
?>


<?php if ($content): ?>
  <div id="comments">
    <?php if (user_access('post comments')) :?>
      <div class="quote"><?php print($comment_link);?></div>
    <?php endif;?>
    <?php if ($node->type != 'forum'): ?>
      <h2 class="title"><?php print t('Comments'); ?></h2>
    <?php endif; ?>
    <?php print $content; ?>  

  </div>
<?php endif; ?>


