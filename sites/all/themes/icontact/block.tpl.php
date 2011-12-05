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

<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="block block-<?php print $block->module ?> <?php if (function_exists(block_class)) print block_class($block); ?>">
  <?php if ($block->region =='sidebar_first'): ?>
    <div class="top-left"><div class="top-right"><div class="top"></div></div></div>
  <?php endif; ?>
  <div id="block-inner" class="clear-block">
    <?php if ($block->subject): ?>
      <div class="block-title">
        <h2><?php print $block->subject ?></h2>
	  </div>
      <?php if (($block->region =='footer_one') || ($block->region =='footer_two') || ($block->region =='footer_three') || ($block->region =='footer_four')): ?>
        <div class="bottom-left"><div class="bottom-right"><div class="bottom"></div></div></div>
      <?php endif; ?>
    <?php endif;?>
    <div class="content">
      <?php print $block->content; ?>
    </div> 
  </div>
</div> <!-- /block -->
