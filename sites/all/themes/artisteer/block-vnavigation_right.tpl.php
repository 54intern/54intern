<div class="clear-block block block-<?php print $block->module ?>" id="block-<?php print $block->module ."-". $block->delta; ?>"><?php art_vmenu_output(isset($block->subject) ? $block->subject : '', isset($block->content) ? $block->content : '');?></div>