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

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"><div class="node-inner clear-block">
  <?php if (!$page): ?>
    <h2 class="title">
      <a href="<?php print $node_url; ?>" title="<?php print $title ?>"><?php print $title; ?></a>
    </h2>
  <?php endif; ?>

  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

  <div class="meta">
    <?php if ($submitted): ?>
	  <div>
        <span class="submitted"><?php print t('By ') . $name; ?></span>
	    <span class="date"><?php echo date("F j, Y, g:i a", $created);?></span>
	  </div>
    <?php endif; ?>
    <?php print $links; ?>
	<?php if ($terms): ?>		
      <div class="terms terms-inline"><?php print t('') . $terms; ?></div>
    <?php endif; ?>
  </div>

  <div class="content">
    <?php print $content; ?>
  </div>

</div></div> <!-- /node-inner, /node -->