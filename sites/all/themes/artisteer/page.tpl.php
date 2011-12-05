<?php
	$vars = get_defined_vars();
	$view = get_artx_drupal_view();
	$view->print_head($vars);

	if (isset($page))
		foreach (array_keys($page) as $name)
				$$name = & $page[$name];
	$art_sidebar_left = isset($sidebar_left) && !empty($sidebar_left) ? $sidebar_left : NULL;
	$art_sidebar_last = isset($sidebar_last) && !empty($sidebar_last) ? $sidebar_last : NULL;
	if (!isset($vnavigation_left)) $vnavigation_left = NULL;
	if (!isset($vnavigation_right)) $vnavigation_right = NULL;
	$tabs = (isset($tabs) && !(empty($tabs))) ? '<ul class="arttabs_primary">'.render($tabs).'</ul>' : NULL;
	$tabs2 = (isset($tabs2) && !(empty($tabs2))) ?'<ul class="arttabs_secondary">'.render($tabs2).'</ul>' : NULL;
?>

<div id="art-page-background-glare-wrapper">
    <div id="art-page-background-glare"></div>
</div>
<div id="art-main">
    <div class="cleared reset-box"></div>
<div class="art-box art-sheet">
    <div class="art-box-body art-sheet-body">
<div class="art-header">
<div class="art-headerobject"></div>
<div class="art-logo">
     <?php   if (!empty($site_name)) { echo '<h1 class="art-logo-name"><a href="'.check_url($front_page).'" title = "'.$site_name.'">'.$site_name.'</a></h1>'; } ?>
     <?php   if (!empty($site_slogan)) { echo '<h2 class="art-logo-text">'.$site_slogan.'</h2>'; } ?>
</div>

</div>
<div class="cleared reset-box"></div>
<?php if (!empty($navigation) || !empty($extra1) || !empty($extra2)): ?>
<div class="art-bar art-nav">
<div class="art-nav-outer">
    <?php if (!empty($extra1)) : ?>
    <div class="art-hmenu-extra1"><?php echo render($extra1); ?></div>
    <?php endif; ?>
    <?php if (!empty($extra2)) : ?>
    <div class="art-hmenu-extra2"><?php echo render($extra2); ?></div>
    <?php endif; ?>
    <?php if (!empty($navigation)) : ?>
    <?php echo render($navigation); ?>
    <?php endif; ?>
</div>
</div>
<div class="cleared reset-box"></div>
<?php endif;?>
<?php if (!empty($banner1)) { echo '<div id="banner1">'.render($banner1).'</div>'; } ?>
<?php echo art_placeholders_output(render($top1), render($top2), render($top3)); ?>
<div class="art-layout-wrapper">
    <div class="art-content-layout">
        <div class="art-content-layout-row">
<?php if (!empty($art_sidebar_left) || !empty($vnavigation_left))
echo art_get_sidebar($art_sidebar_left, $vnavigation_left, 'art-sidebar1'); ?>
<div class="<?php echo art_get_content_cell_style($art_sidebar_left, $vnavigation_left, $art_sidebar_last, $vnavigation_right, $content); ?>">
<?php if (!empty($banner2)) { echo '<div id="banner2">'.render($banner2).'</div>'; } ?>
<?php if ((!empty($user1)) && (!empty($user2))) : ?>
<table class="position" cellpadding="0" cellspacing="0" border="0">
<tr valign="top"><td class="half-width"><?php echo render($user1); ?></td>
<td><?php echo render($user2); ?></td></tr>
</table>
<?php else: ?>
<?php if (!empty($user1)) { echo '<div id="user1">'.render($user1).'</div>'; }?>
<?php if (!empty($user2)) { echo '<div id="user2">'.render($user2).'</div>'; }?>
<?php endif; ?>
<?php if (!empty($banner3)) { echo '<div id="banner3">'.render($banner3).'</div>'; } ?>
<?php if (!empty($breadcrumb)): ?>
<div class="art-box art-post">
    <div class="art-box-body art-post-body">
<div class="art-post-inner art-article">
<div class="art-postcontent">
<?php { echo $breadcrumb; } ?>

</div>
<div class="cleared"></div>

</div>

		<div class="cleared"></div>
    </div>
</div>
<?php endif; ?>
<?php if (($is_front) || (isset($node) && isset($node->nid))): ?>              
<?php if (!empty($tabs) || !empty($tabs2)): ?>
<div class="art-box art-post">
    <div class="art-box-body art-post-body">
<div class="art-post-inner art-article">
<div class="art-postcontent">
<?php if (!empty($tabs)) { echo $tabs.'<div class="cleared"></div>'; }; ?>
<?php if (!empty($tabs2)) { echo $tabs2.'<div class="cleared"></div>'; } ?>

</div>
<div class="cleared"></div>

</div>

		<div class="cleared"></div>
    </div>
</div>
<?php endif; ?>
                <?php if (!empty($mission) || !empty($help) || !empty($messages) || !empty($action_links)): ?>
<div class="art-box art-post">
    <div class="art-box-body art-post-body">
<div class="art-post-inner art-article">
<div class="art-postcontent">
<?php if (isset($mission) && !empty($mission)) { echo '<div id="mission">'.$mission.'</div>'; }; ?>
<?php if (!empty($help)) { echo render($help); } ?>
<?php if (!empty($messages)) { echo $messages; } ?>
<?php if (isset($action_links) && !empty($action_links)): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>

</div>
<div class="cleared"></div>

</div>

		<div class="cleared"></div>
    </div>
</div>
<?php endif; ?>
                <?php $art_post_position = strpos(render($content), "art-post"); ?>
<?php if ($art_post_position === FALSE): ?>
<div class="art-box art-post">
    <div class="art-box-body art-post-body">
<div class="art-post-inner art-article">
<div class="art-postcontent">
<?php endif; ?>
<?php echo art_content_replace(render($content)); ?>
<?php if ($art_post_position === FALSE): ?>

</div>
<div class="cleared"></div>

</div>

		<div class="cleared"></div>
    </div>
</div>
<?php endif; ?>
<?php else: ?>
<div class="art-box art-post">
    <div class="art-box-body art-post-body">
<div class="art-post-inner art-article">
<div class="art-postcontent">
<?php if (!empty($title)): print '<h2'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h2>'; endif; ?>
                    <?php if (!empty($tabs)) { echo $tabs.'<div class="cleared"></div>'; }; ?>
<?php if (!empty($tabs2)) { echo $tabs2.'<div class="cleared"></div>'; } ?>
<?php if (isset($mission) && !empty($mission)) { echo '<div id="mission">'.$mission.'</div>'; }; ?>
<?php if (!empty($help)) { echo render($help); } ?>
<?php if (!empty($messages)) { echo $messages; } ?>
<?php if (isset($action_links) && !empty($action_links)): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
<?php echo art_content_replace(render($content)); ?>

</div>
<div class="cleared"></div>

</div>

		<div class="cleared"></div>
    </div>
</div>
<?php endif; ?>
<?php if (!empty($banner4)) { echo '<div id="banner4">'.render($banner4).'</div>'; } ?>
<?php if (!empty($user3) && !empty($user4)) : ?>
<table class="position" cellpadding="0" cellspacing="0" border="0">
<tr valign="top"><td class="half-width"><?php echo render($user3); ?></td>
<td><?php echo render($user4); ?></td></tr>
</table>
<?php else: ?>
<?php if (!empty($user3)) { echo '<div id="user1">'.render($user3).'</div>'; }?>
<?php if (!empty($user4)) { echo '<div id="user2">'.render($user4).'</div>'; }?>
<?php endif; ?>
<?php if (!empty($banner5)) { echo '<div id="banner5">'.render($banner5).'</div>'; } ?>
</div>
<?php if (!empty($art_sidebar_last) || !empty($vnavigation_right))
echo art_get_sidebar($art_sidebar_last, $vnavigation_right, 'art-sidebar2'); ?>

        </div>
    </div>
</div>
<div class="cleared"></div>

<?php echo art_placeholders_output(render($bottom1), render($bottom2), render($bottom3)); ?>
<?php if (!empty($banner6)) { echo '<div id="banner6">'.render($banner6).'</div>'; } ?>
<div class="art-footer">
    <div class="art-footer-body">
        <?php 
            if (!empty($feed_icons)) {
                echo $feed_icons;
            }
            else {
                echo '<a href="'.url("rss.xml").'" class="art-rss-tag-icon"></a>';
            }
        ?>
                <div class="art-footer-text">
                        <?php
                    $footer = render($footer_message);
                    if (!empty($footer) && (trim($footer) != '')) {
                        echo $footer;
                    }
                    else {
                        ob_start(); ?>
<p><a href="#">Link1</a> | <a href="#">Link2</a> | <a href="#">Link3</a></p><p>Copyright © 2011. All Rights Reserved.</p>

                        <?php echo str_replace('%YEAR%', date('Y'), ob_get_clean());
                    }
                ?>
                <?php if (!empty($copyright)) { echo '<div id="copyright">'.render($copyright).'</div>'; } ?>
                </div>
		<div class="cleared"></div>
    </div>
</div>
		<div class="cleared"></div>
    </div>
</div>
<div class="cleared"></div>
<p class="art-page-footer"></p>

    <div class="cleared"></div>
</div>


<?php $view->print_closure($vars); ?>