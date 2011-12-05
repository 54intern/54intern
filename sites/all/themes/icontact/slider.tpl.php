<?php
// $Id$

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

<?php if ($valid_slider): ?>
  <div id="sliderwrapper">
    <div id="slider">
	  <?php print $tabs_formatted ?>
      <div class="scroll">
        <div class="scrollContainer">
          <?php print $slider_content_formatted ?>
        </div>
      </div>
    </div>
  </div>
<?php else: ?>
  <div id="sliderwrapper">
    <?php print t('An error has occurred while trying to create this slider.') ?>
  </div>
<?php endif; ?>
