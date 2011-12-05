<?php

/* Drupal 6 methods definitons */

/**
 * Override or insert PHPTemplate variables into the templates.
 */
function phptemplate_preprocess_page(&$vars) {
  $view = get_artx_drupal_view();
  $message = $view->get_incorrect_version_message();
  if (!empty($message)) {
	drupal_set_message($message, 'error');
  }

  $vars['tabs'] = menu_primary_local_tasks();
  $vars['tabs2'] = menu_secondary_local_tasks();

  // Use grouped import setting to avoid 30 stylesheet limit in IE
  if (!variable_get('preprocess_css', FALSE)) {
    $css = drupal_add_css();
    $style_count = substr_count($vars['setting_styles'] . $vars['ie6_styles'] . $vars['ie7_styles'] . $vars['ie8_styles'] . $vars['local_styles'], '<link');
    if (artisteer_css_count($css) > (30 - $style_count)) {
      $styles = '';
      $suffix = "\n".'</style>'."\n";
      foreach ($css as $media => $types) {
        $prefix = '<style type="text/css" media="'. $media .'">'."\n";
        $imports = array();
        foreach ($types as $files) {
          foreach ($files as $file => $preprocess) {
            $imports[] = '@import "'. base_path() . $file .'";';
            if (count($imports) == 30) {
              $styles .= $prefix . implode("\n", $imports) . $suffix;
              $imports = array();
            }
          }
        }
        $styles .= (count($imports) > 0) ? ($prefix . implode("\n", $imports) . $suffix) : '';
      }
      $vars['styles'] = $styles;
    }
  }
}

/**
 * CSS count function
 * Counts the total number of CSS files in $vars['css']
 */
function artisteer_css_count($array) {
  $count = 0;
  foreach ($array as $item) {
    $count = (is_array($item)) ? $count + artisteer_css_count($item) : $count + 1;
  }
  return $count;
}

/**
 * Generate the HTML output for a single local task link.
 *
 * @ingroup themeable
 */
 
function artisteer_menu_local_task($link, $active = FALSE) {
  $active_class = "";
  if ($active) {
    $active_class .= "active ";
  }
  $output = preg_replace('~<a href="([^"]*)"[^>]*>([^<]*)</a>~',
    '<span class="'.$active_class.'art-button-wrapper">'.
    '<span class="art-button-l"></span>'.
    '<span class="art-button-r"></span>'.
    '<a href="$1" class="'.$active_class.'art-button">$2</a></span>', $link);
  return '<li>'.$output.'</li>';
}

/**
 * Return code that emits an feed icon.
 *
 * @param $url
 *   The url of the feed.
 * @param $title
 *   A descriptive title of the feed.
  */
function artisteer_feed_icon($url, $title) {
  return '<a href="'. check_url($url) .'" class="art-rss-tag-icon" title="' . $title . '"></a>';
}

/**
 * Add a "Comments" heading above comments except on forum pages.
 */
function artisteer_preprocess_comment_wrapper(&$vars) {
  if (!isset($vars['content'])) return;
  
  ob_start();?>
<div class="art-box art-post">
      <div class="art-box-body art-post-body">
  <div class="art-post-inner art-article">
  
  <?php $result .= ob_get_clean();
   
  if ($vars['node']->type != 'forum') {
    $result .= '<h2 class="art-postheader comments">' . t('Comments') . '</h2>';
  }
  
  ob_start();?>
<div class="art-postcontent">
  
  <?php $result .= ob_get_clean();
  
  $result .= $vars['content'];
  ob_start();?>

  </div>
  <div class="cleared"></div>
  
  <?php $result .= ob_get_clean();
  
  ob_start();?>

  </div>
  
  		<div class="cleared"></div>
      </div>
  </div>
  
  <?php $result .= ob_get_clean();
  
  $vars['content'] = $result;
}

/**
 * Allow themable wrapping of all breadcrumbs.
 */
function artisteer_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return '<div class="breadcrumb art-postcontent">'. implode(' | ', $breadcrumb) .'</div>';
  }
}

function artisteer_service_links_node_format($links) {
  return '<div class="service-links"><div class="service-label">'. t('Bookmark/Search this post with: ') .'</div>'. art_links_woker($links) .'</div>';
}

/**
 * Theme a form button.
 *
 * @ingroup themeable
 */
function artisteer_button($element) {
  // Make sure not to overwrite classes.
  if (isset($element['#attributes']['class'])) {
    $element['#attributes']['class'] = 'form-'.$element['#button_type'].' '.$element['#attributes']['class'].' art-button';
  }
  else {
    $element['#attributes']['class'] = 'form-'.$element['#button_type'].' art-button';
  }
   	
  return '<span class="art-button-wrapper">'.
    '<span class="art-button-l"></span>'.
    '<span class="art-button-r"></span>'.
    '<input type="submit" '. (empty($element['#name']) ? '' : 'name="'. $element['#name']
         .'" ')  .'id="'. $element['#id'].'" value="'. check_plain($element['#value']) .'" '. drupal_attributes($element['#attributes']).'/>'.
	'</span>';
}

/**
 * Image assist module support.
 * Added Artisteer styles in IE
*/
function artisteer_img_assist_page($content, $attributes = NULL) {
  $title = drupal_get_title();
  $output = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
  $output .= '<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">'."\n";
  $output .= "<head>\n";
  $output .= '<title>'. $title ."</title>\n";
  
  // Note on CSS files from Benjamin Shell:
  // Stylesheets are a problem with image assist. Image assist works great as a
  // TinyMCE plugin, so I want it to LOOK like a TinyMCE plugin. However, it's
  // not always a TinyMCE plugin, so then it should like a themed Drupal page.
  // Advanced users will be able to customize everything, even TinyMCE, so I'm
  // more concerned about everyone else. TinyMCE looks great out-of-the-box so I
  // want image assist to look great as well. My solution to this problem is as
  // follows:
  // If this image assist window was loaded from TinyMCE, then include the
  // TinyMCE popups_css file (configurable with the initialization string on the
  // page that loaded TinyMCE). Otherwise, load drupal.css and the theme's
  // styles. This still leaves out sites that allow users to use the TinyMCE
  // plugin AND the Add Image link (visibility of this link is now a setting).
  // However, on my site I turned off the text link since I use TinyMCE. I think
  // it would confuse users to have an Add Images link AND a button on the
  // TinyMCE toolbar.
  // 
  // Note that in both cases the img_assist.css file is loaded last. This
  // provides a way to make style changes to img_assist independently of how it
  // was loaded.
  $output .= drupal_get_html_head();
  $output .= drupal_get_js();
  $output .= "\n<script type=\"text/javascript\"><!-- \n";
  $output .= "  if (parent.tinyMCE && parent.tinyMCEPopup && parent.tinyMCEPopup.getParam('popups_css')) {\n";
  $output .= "    document.write('<link href=\"' + parent.tinyMCEPopup.getParam('popups_css') + '\" rel=\"stylesheet\" type=\"text/css\">');\n";
  $output .= "  } else {\n";
  foreach (drupal_add_css() as $media => $type) {
    $paths = array_merge($type['module'], $type['theme']);
    foreach (array_keys($paths) as $path) {
      // Don't import img_assist.css twice.
      if (!strstr($path, 'img_assist.css')) {
        $output .= "  document.write('<style type=\"text/css\" media=\"{$media}\">@import \"". base_path() . $path ."\";<\/style>');\n";
      }
    }
  }
  $output .= "  }\n";
  $output .= "--></script>\n";
  // Ensure that img_assist.js is imported last.
  $path = drupal_get_path('module', 'img_assist') .'/img_assist_popup.css';
  $output .= "<style type=\"text/css\" media=\"all\">@import \"". base_path() . $path ."\";</style>\n";
  
  $output .= '<link rel="stylesheet" href="'.get_full_path_to_theme().'/style.css" type="text/css" />'."\n";
  $output .= '<!--[if IE 6]><link rel="stylesheet" href="'.get_full_path_to_theme().'/style.ie6.css" type="text/css" /><![endif]-->'."\n";
  $output .= '<!--[if IE 7]><link rel="stylesheet" href="'.get_full_path_to_theme().'/style.ie7.css" type="text/css" /><![endif]-->'."\n";

  $output .= "</head>\n";
  $output .= '<body'. drupal_attributes($attributes) .">\n";
  
  $output .= theme_status_messages();
  
  $output .= "\n";
  $output .= $content;
  $output .= "\n";
  $output .= '</body>';
  $output .= '</html>';
  return $output;
}

/**
 * Display a node preview for display during node creation and editing.
 *
 * @param $node
 *   The node object which is being previewed.
 *
 * @ingroup themeable
 */
function artisteer_node_preview($node) {
  $output = '<div class="preview">';

  $preview_trimmed_version = FALSE;
  // Do we need to preview trimmed version of post as well as full version?
  if (isset($node->teaser) && isset($node->body)) {
    $teaser = trim($node->teaser);
    $body = trim(str_replace('<!--break-->', '', $node->body));

    // Preview trimmed version if teaser and body will appear different;
    // also (edge case) if both teaser and body have been specified by the user
    // and are actually the same.
    if ($teaser != $body || ($body && strpos($node->body, '<!--break-->') === 0)) {
      $preview_trimmed_version = TRUE;
    }
  }

  if ($preview_trimmed_version) {
    drupal_set_message(t('The trimmed version of your post shows what your post looks like when promoted to the main page or when exported for syndication.<span class="no-js"> You can insert the delimiter "&lt;!--break--&gt;" (without the quotes) to fine-tune where your post gets split.</span>'));

	$preview_trimmed_version = t('Preview trimmed version');
	$output .= <<< EOT
<div class="art-box art-post">
        <div class="art-box-body art-post-body">
    <div class="art-post-inner art-article">
    
<div class="art-postcontent">
    
      <h3>
	  $preview_trimmed_version
	  </h3>

    </div>
    <div class="cleared"></div>
    

    </div>
    
    		<div class="cleared"></div>
        </div>
    </div>
    
EOT;
	$output .= node_view(drupal_clone($node), 1, FALSE, 0);
    
	$preview_full_version = t('Preview full version');
	$output .= <<< EOT
<div class="art-box art-post">
        <div class="art-box-body art-post-body">
    <div class="art-post-inner art-article">
    
<div class="art-postcontent">
    
      <h3>
	  $preview_full_version
	  </h3>

    </div>
    <div class="cleared"></div>
    

    </div>
    
    		<div class="cleared"></div>
        </div>
    </div>
    
EOT;

    $output .= node_view($node, 0, FALSE, 0);
  }
  else {
    $output .= node_view($node, 0, FALSE, 0);
  }
  $output .= "</div>\n";

  return $output;
}