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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">

<head>
  <title><?php print $head_title; ?></title>
  <?php print $head; ?>
  <?php print $styles; ?>
  <!--[if IE 7]>
  <link type="text/css" rel="stylesheet" href="<?php print base_path().path_to_theme(); ?>/css/ie.css" media="screen">
  <![endif]-->
  <?php print $scripts; ?>
</head>

<body class="<?php print $body_classes; ?>">
  <div id="page"><div id="page-inner">
    <?php if ($secondary_links): ?>
      <div id="secondary"><div id="secondary-wrapper"><div id="secondary-inner">
        <?php print theme('links', $secondary_links); ?>
      </div></div></div> <!-- /#secondary-inner, /#secondary -->
    <?php endif; ?>
    <div id="header"><div id="header-inner" class="clear-block">
      <?php if ($logo || $site_name || $site_slogan): ?>
        <div id="logo-title">
          <?php if ($logo): ?>
            <div id="logo"><a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" id="logo-image" /></a></div>
          <?php endif; ?>
		  <div id="site-name-slogan">
            <?php if ($site_name): ?>
              <h1 id="site-name">
                <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><?php print $site_name; ?></a>
              </h1>
            <?php endif; ?>
            <?php if ($site_slogan): ?>
              <span id="site-slogan"><?php print $site_slogan; ?></span>
            <?php endif; ?>
		  </div>
        </div> <!-- /#logo-title -->
      <?php endif; ?>
	  <?php if ($header): ?>
        <div id="header-blocks" class="region region-header">
          <?php print $header; ?>
        </div> <!-- /#header-blocks -->
      <?php endif; ?>
    </div></div> <!-- /#header-inner, /#header -->

	<?php if ($primary_links || $navbar): ?>
      <div id="navbar"><div id="navbar-wrapper"><div id="navbar-inner" class="clear-block">
        <?php if ($primary_links): ?>
          <div id="primary">
            <?php print menu_tree($menu_name = 'primary-links'); ?>
          </div>
        <?php endif; ?> <!-- /#primary -->

        <?php print $navbar; ?>

      </div></div>
    <?php if ($user_meta): ?>
       <div id="user_meta" class="column">
          <?php print $user_meta; ?>
       </div><!-- /user_meta -->
    <?php endif; ?>

      </div> <!-- /#navbar-inner, /#navbar -->
    <?php endif; ?>

    <div id="main-top-edge"></div>

	<div id="main">
	  <div id="main-inner">
	    <div class="clear-block">
	      <?php if ($showcase): ?>
            <div id="showcase">
	          <div id="showcase-inner" class="clear-block">
                <?php print $showcase; ?>
		      </div>
	        </div>
          <?php endif; ?>
          <div id="content">
	        <div id="breadcrumb"><div id="breadcrumb-wrapper"><div id="breadcrumb-inner"><?php print $breadcrumb; ?></div></div></div>
		    <?php if ($headline || $subheadline): ?>
              <div id="headlines" class="clear-block">
	            <div id="headlines-inner" class="<?php print $headlines;?> clear-block">
                  <?php if ($headline): ?>
                    <div id="headline" class="column">
                      <?php print $headline; ?>
                    </div><!-- /headline -->
                  <?php endif; ?>
                  <?php if ($subheadline): ?>
                    <div id="subheadline" class="column">
                      <?php print $subheadline; ?>
                    </div><!-- /subheadline -->
                  <?php endif; ?>
		        </div>
	          </div><!-- /#headline-inner, /#headline -->
            <?php endif; ?>

            <?php if ($main_top): ?>
              <div id="main-top"><?php print $main_top; ?></div>
            <?php endif; ?>

            <?php if ($mission): ?>
              <div id="mission"><?php print $mission; ?></div>
            <?php endif; ?>

            <div id="content-inner">
		      <?php if ($title || $tabs || $help || $messages): ?>
                <div id="content-header">
                  <?php if ($title && (!$showcase)): ?>
                    <h1 class="title"><?php print $title; ?></h1>
                  <?php endif; ?>
                  <?php print $messages; ?>
                  <?php if ($tabs): ?>
                    <div class="tabs"><?php print $tabs; ?></div>
                  <?php endif; ?>
                  <?php print $help; ?>
                </div> <!-- /#content-header -->
              <?php endif; ?>
              <div id="content-area">
                <?php print $content; ?>
              </div>
            </div> <!-- /#content-inner -->
            <?php if (main_content): ?>
            <div id="main_content">
              <?php print $main_content; ?>
            </div> <!-- /#main_content -->
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
	    </div>

	    <?php if ($main_bottom_one || $main_bottom_two || $main_bottom_three || $main_bottom_four): ?>
          <div id="main-bottom"><div id="main-bottom-inner" class="<?php print $main_bottom; ?> clear-block">
            <?php if ($main_bottom_one): ?>
              <div id="main-bottom-one" class="column">
                <?php print $main_bottom_one; ?>
              </div><!-- /main-bottom-one -->
            <?php endif; ?>
            <?php if ($main_bottom_two): ?>
              <div id="main-bottom-two" class="column">
                <?php print $main_bottom_two; ?>
              </div><!-- /main-bottom-two -->
            <?php endif; ?>
	        <?php if ($main_bottom_three): ?>
              <div id="main-bottom-three" class="column">
                <?php print $main_bottom_three; ?>
              </div><!-- /main-bottom-three -->
            <?php endif; ?>
		    <?php if ($main_bottom_four): ?>
              <div id="main-bottom-four" class="column">
                <?php print $main_bottom_four; ?>
              </div><!-- /main-bottom-four -->
            <?php endif; ?>
          </div></div>
	    <?php endif; ?>
	  </div>
	</div><!-- /#main-inner, /#main -->
	<div id="main-bottom-edge"></div>

    <?php if ($footer_one || $footer_two || $footer_three || $footer_four): ?>
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

	<div id="closure"><div id="closure-inner"><div id="designed-by"><small><a href="" target="blank">Designed by Edison Chen</a></small></div><?php print $closure_region; ?></div></div>
  </div></div> <!-- /#page-inner, /#page -->
  <?php print $closure; ?>
<!--[if IE]>
	<script type="text/javascript"> Cufon.now(); </script>
<![endif]-->
</body>
</html>

