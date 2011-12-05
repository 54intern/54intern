<?php
/* $Id$ */

/*
+----------------------------------------------------------------+
|   Contact for Dupal 6.x - Version 1.0                          |
|   Copyright (C) 2010 Antsin.com All Rights Reserved.           |
|   @license - Copyrighted Commercial Software                   |
|----------------------------------------------------------------|
|   Theme Name: Contact                                          |
|   Description: Contact by Antsin                               |
|   Author: Antsin.com                                           |
|   Date: 10th February 2010                                     |
|   Website: http://www.antsin.com/                              |
|----------------------------------------------------------------+
|   This file may not be redistributed in whole or               |
|   significant part.                                            |
+----------------------------------------------------------------+
*/  
?>

<div class="<?php print $classes; ?>"><div class="comment-inner clear-block">
  <?php if ($title): ?>
    <h3 class="title"><!--<?php print $title; ?>--></h3> 
  <?php endif; ?>

  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?> 

  <div class="content">
    <div class="content-inner">
	  <?php print $picture;?>
	  <?php if ($links): ?>
        <div class="links"><?php print $links; ?></div>
      <?php endif; ?> 
      <span class="author"><?php print $date; ?> - <?php print $author; ?></span>
      <?php print $content; ?>
	</div>
    <?php if ($signature): ?>
    <div class="user-signature clear-block">
      <?php print $signature; ?>
    </div>
    <?php endif; ?> 
  </div>
</div></div> <!-- /comment-inner, /comment -->
