<?php 
	$vars = get_defined_vars();
	$view = get_artx_drupal_view();

	$message = $view->get_incorrect_version_message();
	if (!empty($message)) {
		print $message;
		die();
	}
?>

<div id="node-<?php print $node->nid; ?>" class="node<?php if(!empty($type)) { echo ' '.$type; } if ($sticky) { echo ' sticky'; } if ($promote) { print ' promote'; } if (!$status) { print ' node-unpublished'; } ?>">
<div class="art-box art-post">
    <div class="art-box-body art-post-body">
<div class="art-post-inner art-article">
  <?php $logo = $node->field_company_logo[0];?>
  <a class="imagecache left framed" href="<?php print $node_url; ?>">
    <img class="imagecache-company_logo_list" src="<?php print(base_path().'sites/default/files/imagecache/company_logo_list/pictures/company/'.$logo[filename]);?>"/>
  </a>
<h3 class="art-postheader"><?php echo art_node_title_output($title, $node_url, $page); ?>
</h3>
<?php ob_start(); ?>
<?php if ($submitted): ?>
<div class="art-postheadericons art-metadata-icons">
<?php echo art_submitted_worker($date, $name); ?>

</div>
<?php endif; ?>
<?php $metadataContent = ob_get_clean(); ?>
<?php if (trim($metadataContent) != ''): ?>
<div class="art-postmetadataheader">
<?php echo $metadataContent; ?>

</div>
<?php endif; ?>
<div class="art-postcontent">
<div class="art-article"><?php echo strip_tags($node->og_description); ?>
<?php if (isset($node->links['node_read_more'])) { echo '<div class="read_more">'.get_html_link_output($node->links['node_read_more']).'</div>'; }?></div>

</div>
<div class="cleared"></div>

</div>
		<div class="cleared"></div>
    </div>
</div>
</div>