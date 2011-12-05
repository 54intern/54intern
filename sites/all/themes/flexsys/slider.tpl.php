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

<?php if ($valid_slider): ?>
  <div id="sliderwrapper">
    <div id="slider" class="clear-block">
      <?php if ($tabs_position): ?>
        <div class="scroll">
          <div class="scrollContainer">
            <?php print $slider_content_formatted ?>
          </div>
        </div>
        <?php print $tabs_formatted ?>
      <?php else: ?>
        <?php print $tabs_formatted ?>
        <div class="scroll">
          <div class="scrollContainer">
            <?php print $slider_content_formatted ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
<?php else: ?>
  <div id="sliderwrapper">
    <?php print t('An error has occurred while trying to create this slider.') ?>
  </div>
<?php endif; ?>
