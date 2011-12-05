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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">

<head>
  <title><?php print $head_title; ?></title>
  <?php print $head; ?>
  <?php print $styles; ?>
  <!--[if lte IE 7]>
  <link type="text/css" rel="stylesheet" href="<?php print base_path().path_to_theme(); ?>/css/ie.css" media="screen">
  <![endif]-->
  <?php print $scripts; ?>
</head>
<body class="<?php print $body_classes; ?>">
  <div id="page">
    <div id="header"><div id="header-inner" class="clear-block">
      <div id="secondary">
        <?php print theme('links', $secondary_links); ?>
      </div> <!-- /#secondary -->
      <?php if ($logo || $site_name || $site_slogan): ?>
        <div id="logo-title">
          <?php if ($logo): ?>
            <div id="logo"><a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" id="logo-image" /></a></div>
          <?php endif; ?>
          <?php if ($site_name): ?>  
		    <div id="site-name">
              <h1><a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><?php print $site_name; ?></a></h1>
			</div>
          <?php endif; ?>
          <?php if ($site_slogan): ?>
            <div id="site-slogan"><?php print $site_slogan; ?></div>
          <?php endif; ?>
        </div> <!-- /#logo-title -->
      <?php endif; ?>
	  <?php if ($header): ?>
        <div id="header-blocks" class="region region-header">
          <?php print $header; ?>
        </div> <!-- /#header-blocks -->
      <?php endif; ?>
    </div></div> <!-- /#header-inner, /#header -->

	<?php if ($primary_links || $navbar ): ?>
      <div id="navbar"><div id="navbar-inner" class="clear-block">
        <?php if ($primary_links): ?>
          <div id="primary">
            <?php print menu_tree($menu_name = 'primary-links'); ?>
          </div>
        <?php endif; ?> <!-- /#primary -->
        <?php print $navbar; ?>
      </div></div> <!-- /#navbar-inner, /#navbar -->
    <?php endif; ?> 

    <?php if ($showcase): ?>
      <div id="showcase"><div id="showcase-inner" class="clear-block">
        <?php print $showcase; ?>
      </div></div><!-- /#showcase-inner, /#showcase -->
    <?php endif; ?>

    <div id="main"><div id="main-inner" class="clear-block">
	  <div id="breadcrumb"><?php print $breadcrumb; ?></div>
	  <?php if ($main_top_one || $main_top_two || $main_top_three || $main_top_four ): ?>
        <div id="main-top"><div id="main-top-inner" class="<?php print $main_top; ?> clear-block">
          <?php if ($main_top_one): ?>
            <div id="main-top-one" class="column">
              <?php print $main_top_one; ?>
            </div><!-- /main-top-one -->
          <?php endif; ?>
          <?php if ($main_top_two): ?>
            <div id="main-top-two" class="column">
              <?php print $main_top_two; ?>
            </div><!-- /main-top-two -->
          <?php endif; ?>
	      <?php if ($main_top_three): ?>
            <div id="main-top-three" class="column">
              <?php print $main_top_three; ?>
            </div><!-- /main-top-three -->
          <?php endif; ?>
	      <?php if ($main_top_four): ?>
            <div id="main-top-four" class="column">
              <?php print $main_top_four; ?>
            </div><!-- /main-top-four -->
          <?php endif; ?>
        </div></div> 
      <?php endif; ?>
      <div id="content">
	  	<?php if ($content_top): ?>
          <div id="content-top">
            <?php print $content_top; ?>
          </div> <!-- /#content-top -->
        <?php endif; ?>	 
        <div id="content-main">
  		  <?php if ($title || $tabs || $help || $messages): ?>
            <div id="content-header">
              <?php if ($title): ?>
                <h1 class="title"><?php print $title; ?></h1>
              <?php endif; ?>
              <?php print $messages; ?>
              <?php if ($tabs): ?>
                <div class="tabs"><?php print $tabs; ?></div>
              <?php endif; ?>
              <?php print $help; ?>
            </div> <!-- /#content-header -->
          <?php endif; ?> 
          <?php print $content; ?>
        </div>
	  	<?php if ($content): ?>
          <div id="content-bottom">
            <?php print $content; ?>
          </div> <!-- /#content-bottom -->
        <?php endif; ?>
      </div> <!-- /#content -->

      <?php if ($sidebar_first): ?>
        <div id="sidebar-left">
          <?php print $sidebar_first; ?>
        </div> <!-- /#sidebar-left -->
      <?php endif; ?>

      <?php if ($sidebar_last): ?>
        <div id="sidebar-right">
          <?php print $sidebar_last; ?>
        </div> <!-- /#sidebar-right -->
      <?php endif; ?>
	</div></div> <!-- /#main-inner, /#main --> 

	<?php if ($footer_one || $footer_two || $footer_three || $footer_four ): ?>
      <div id="footer"><div id="footer-inner" class="<?php print $footer; ?> clear-block">	
        <?php if ($footer_one): ?>
          <div id="footer-one" class="column">
            <?php print $footer_one; ?>
          </div><!-- /footer-one -->
        <?php endif; ?>
        <?php if ($footer_two): ?>
          <div id="footer-two" class="column">
            <?php print $footer_two; ?>
          </div><!-- /footer-two -->
        <?php endif; ?>
	    <?php if ($footer_three): ?>
          <div id="footer-three" class="column">
            <?php print $footer_three; ?>
          </div><!-- /footer-three -->
        <?php endif; ?>
	    <?php if ($footer_four): ?>
          <div id="footer-four" class="column">
            <?php print $footer_four; ?>
          </div><!-- /footer-four -->
        <?php endif; ?>
      </div></div> <!-- /#footer-inner, /#footer -->
    <?php endif; ?>

    <div id="closure"><div id="closure-inner" class="clear-block"><div id="designed-by"><small><a href="http://www.antsin.com" title="Drupal theme" target="blank">Designed by Antsin.com</a></small></div><?php print $closure_region; ?></div></div>
  </div> <?php print $closure; ?><!-- /#page -->
</body>
</html>
