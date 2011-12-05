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

<div class="<?php print $classes; ?>"><div class="comment-inner clear-block">
  <?php if ($title): ?>
    <h3 class="title"><!--<?php print $title; ?>--></h3> 
  <?php endif; ?>

  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>
  
  <?php print $picture;?>
  <?php if ($links): ?>
    <div class="links"><?php print $links; ?></div>
  <?php endif; ?>
  <div class="submitted"><span class="author"><?php print $author; ?></span><span class="date"><?php print $date; ?></span></div>
  <div class="content">
    <?php if ($picture): ?>
	  <div class="content-inner">
        <?php print $content; ?>
	  </div>
	<?php else: ?>
      <?php print $content; ?>
    <?php endif; ?> 
    <?php if ($signature): ?>
      <div class="user-signature clear-block">
        <?php print $signature; ?>
      </div>
    <?php endif; ?> 
  </div>
</div></div> <!-- /comment-inner, /comment -->
