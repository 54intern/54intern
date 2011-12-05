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
<h2 class="art-postheader"><?php echo art_node_title_output($title, $node_url, $page); ?>
</h2>
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
<div class="art-article"><?php echo $content; ?>
<?php if (isset($node->links['node_read_more'])) { echo '<div class="read_more">'.get_html_link_output($node->links['node_read_more']).'</div>'; }?></div>

</div>
<div class="cleared"></div>
<?php if (is_art_links_set($node->links) || !empty($terms)):
$output = art_node_worker($node); 
if (!empty($output)):	?>
<div class="art-postfootericons art-metadata-icons">
<?php echo $output; ?>

</div>
<?php endif; endif; ?>

</div>

		<div class="cleared"></div>
    </div>
</div>

<?php
	$view->print_comment_node($vars);
?>
</div>