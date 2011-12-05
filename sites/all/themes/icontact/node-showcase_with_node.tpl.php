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
<?php if (!$page): ?>
  <h2 class="title">
    <a href="<?php print $node_url; ?>" title="<?php print $title ?>"><?php print $title; ?></a>
  </h2>
<?php endif; ?>
<div class="content">
  <?php print $content; ?>
</div>
