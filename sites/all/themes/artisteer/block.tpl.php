<?php $region = $block->region;
$enabled_blockRegion = $region != 'content' && $region != 'Menu' && $region != 'vnavigation_left' && $region != 'vnavigation_right'
					&& $region != "banner1" && $region != "banner2" && $region != "banner3"
					&& $region != "banner4" && $region != "banner5" && $region != "banner6"
					&& $region != "extra1" && $region != "extra2" && $region != "footer_message";  ?>
<div class="clear-block block block-<?php print $block->module ?>" id="block-<?php print $block->module ."-". $block->delta; ?>">
<?php if ($enabled_blockRegion) :?>
<div class="art-box art-block">
      <div class="art-box-body art-block-body">
  
<?php endif;?>
    

	    <?php if (!empty($block->subject)): ?>
			
			<?php if ($enabled_blockRegion) :?>
<div class="art-bar art-blockheader">
				    <h3 class="t subject">
			<?php endif;?>
			
			<?php echo $block->subject; ?>
			
			<?php if ($enabled_blockRegion) :?>
</h3>
				</div>
				
			<?php endif;?>

	    <?php endif; ?>


	<?php if ($enabled_blockRegion) :?>
<div class="art-box art-blockcontent">
		    <div class="art-box-body art-blockcontent-body">
		<div class="content">
		
	<?php endif;?>
		
<?php echo $block->content; ?>

	<?php if($enabled_blockRegion) :?>

		</div>
				<div class="cleared"></div>
		    </div>
		</div>
		

				<div class="cleared"></div>
		    </div>
		</div>
		
	<?php endif;?>
</div>