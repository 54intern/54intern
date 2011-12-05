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

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"><div class="node-inner clear-block">
  <?php print $picture ?>
  <?php if (!$page): ?>
    <h2 class="title">
      <a href="<?php print $node_url; ?>" title="<?php print $title ?>"><?php print $title; ?></a>
    </h2>
  <?php endif; ?>

  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>
  <?php if ($submitted): ?>
    <div>
        <span class="submitted"><?php print $name; ?></span>
	    <span class="submitted-date"><?php echo date("F j, Y, g:i a", $created);?></span>
	    <?php if ($terms): ?>		
	      <div class="terms terms-inline"><?php print t('') . $terms; ?></div>
        <?php endif; ?>
    </div>
  <?php endif; ?>
  <?php if ($submitted && !$teaser): ?>

  <?php endif; ?>
  <div class="content">    
    <?php print $content; ?>
  </div>
  <?php if ($submitted && !$teaser): ?>
    <div class="meta">	      
      <?php print $links; ?>
    </div>
  <?php endif; ?>
</div></div> <!-- /node-inner, /node -->
