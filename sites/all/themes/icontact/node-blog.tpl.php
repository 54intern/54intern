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

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"><div class="node-inner clearfix">
  <div id="blog-date"><span class="date"><?php echo date("d/m/Y", $created);?></span>
  	<?php if ($submitted): ?>
      <span class="submitted">
        <?php print t('By ') .$name; ?>
      </span>
    <?php endif; ?>
  </div>
  <div id="blog-content">
    <?php if (!$page): ?>
      <h2 class="title">
        <a href="<?php print $node_url; ?>" title="<?php print $title ?>"><?php print $title; ?></a>
      </h2>
    <?php endif; ?>
    <?php if ($unpublished): ?>
      <div class="unpublished"><?php print t('Unpublished'); ?></div>
    <?php endif; ?>
    <div class="meta">
	  <?php print $links; ?>
	  <?php if ($terms): ?>		
	    <div class="terms terms-inline"><?php print t('') . $terms; ?></div>
      <?php endif; ?>
    </div>	 
    <div class="content">
      <?php print $content; ?>
    </div>
  </div>
</div></div> <!-- /node-inner, /node -->
