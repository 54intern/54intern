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

<div id="block-<?php print $block->module .'-'. $block->delta. '_'.$block->region; ?>" class="block block-<?php print $block->module ?> <?php if (function_exists(block_class)) print block_class($block); ?>">
 
  <?php if ($block->region =='sidebar_last'): ?>
    <div class="box-top-left"><div class="box-top-right"><div class="box-top"></div></div></div>
  <?php endif; ?>

  <div class="block-inner clear-block">
    <?php if ($block->subject): ?>
      <?php if ($block->region =='sidebar_first'): ?>
        <div class="header-wrapper"><div class="header-wrapper-inner">
      <?php endif; ?>
      <h2 class="title"><?php print $block->subject; ?></h2>
      <?php if ($block->region =='sidebar_first'): ?>
        </div></div>
      <?php endif; ?>
    <?php endif; ?>
	<div class="content">
      <?php print $block->content; ?>
    </div>
	<?php print $edit_links; ?>
  </div>

  <?php if ($block->region =='sidebar_last'): ?>
    <div class="box-bottom-left"><div class="box-bottom-right"><div class="box-bottom"></div></div></div>
  <?php endif; ?>

</div> <!-- /block-inner, /block -->
