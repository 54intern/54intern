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

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"><div class="node-inner blog clear-block">
  <div id="blog-date">
    <span class="date"><?php echo date("d", $created);?></span>
	<span class="month"><?php echo date("M", $created);?></span>
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

  <?php if ($submitted or $terms): ?>
    <div class="meta">
      <?php if (!$teaser): ?>	
        <?php print $links; ?>
      <?php endif; ?>
      <?php if ($terms): ?>		
	     <div class="terms terms-inline"><?php print t('') . $terms; ?></div>
      <?php endif; ?>	  
    </div> 
  <?php endif; ?>
  <?php if ($submitted && !$teaser): ?>
<!-- JiaThis Button BEGIN -->
<div id="ckepop">
	<span class="jiathis_txt">分享到：</span>
	<a class="jiathis_button_tools_1"></a>
	<a class="jiathis_button_tools_2"></a>
	<a class="jiathis_button_tools_3"></a>
	<a class="jiathis_button_tools_4"></a>
	<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank">更多</a>
	<a class="jiathis_counter_style"></a>
</div>
<!-- JiaThis Button END -->
  <?php endif; ?>

  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

  <div class="content">
    <?php print $content; ?>
  </div>

</div></div></div> <!-- /node-inner, /node -->
<?php if ($submitted && !$teaser): ?>
<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js" charset="utf-8"></script>
<?php endif; ?>