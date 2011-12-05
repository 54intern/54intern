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

/**
 * Initialize theme settings
 */
if (is_null(theme_get_setting('user_notverified_display'))) {
  global $theme_key;
  // Get node types
  $node_types = node_get_types('names');
  
  /**
   * The default values for the theme variables. Make sure $defaults exactly
   * matches the $defaults in the theme-settings.php file.
   */
  $defaults = array(
    'flexsys_style' => 'blue',
  );
  
  // Make the default content-type settings the same as the default theme settings,
  // so we can tell if content-type-specific settings have been altered.
  $defaults = array_merge($defaults, theme_get_settings());
    
  // Get default theme settings.
  $settings = theme_get_settings($theme_key);  
  
  // Don't save the toggle_node_info_ variables
  if (module_exists('node')) {
    foreach (node_get_types() as $type => $name) {
      unset($settings['toggle_node_info_'. $type]);
    }
  }

  // Save default theme settings
  variable_set(
    str_replace('/', '_', 'theme_'. $theme_key .'_settings'),
    array_merge($defaults, $settings)
  );
  // Force refresh of Drupal internals
  theme_get_setting('', TRUE);
}

function get_flexsys_style() {
  $style = theme_get_setting('flexsys_style');
  return $style;
}

drupal_add_css(drupal_get_path('theme', 'flexsys') . '/css/' . get_flexsys_style() . '.css', 'theme');

function phptemplate_preprocess_page(&$vars) {
  
  // Add conditional stylesheets.
  if (!module_exists('conditional_styles')) {
    $vars['styles'] .= $vars['conditional_styles'] = variable_get('conditional_styles_' . $GLOBALS['theme'], '');
  }

  // Classes for body element. Allows advanced theming based on context
  // (home page, node of certain type, etc.)
  $classes = split(' ', $vars['body_classes']);
  // Remove the mostly useless page-ARG0 class.
  if ($index = array_search(preg_replace('![^abcdefghijklmnopqrstuvwxyz0-9-_]+!s', '', 'page-'. drupal_strtolower(arg(0))), $classes)) {
    unset($classes[$index]);
  }
  if (!$vars['is_front']) {
    // Add unique class for each page.
    $path = drupal_get_path_alias($_GET['q']);
    $classes[] = flexsys_id_safe('page-' . $path);
    // Add unique class for each website section.
    list($section, ) = explode('/', $path, 2);
    if (arg(0) == 'node') {
      if (arg(1) == 'add') {
        $section = 'node-add';
      }
      elseif (is_numeric(arg(1)) && (arg(2) == 'edit' || arg(2) == 'delete')) {
        $section = 'node-' . arg(2);
      }
    }
    $classes[] = flexsys_id_safe('section-' . $section);
  }
 
  $vars['body_classes_array'] = $classes;
  $vars['body_classes'] = implode(' ', $classes); // Concatenate with spaces.
  
  // Add content top & postscript classes with number of active sub-regions
  $region_list = array(
    'headlines' => array('headline', 'subheadline'), 
    'main_bottom' => array('main_bottom_one', 'main_bottom_two', 'main_bottom_three', 'main_bottom_four'), 
    'footer' => array('footer_one', 'footer_two', 'footer_three', 'footer_four')
  );

  foreach ($region_list as $sub_region_key => $sub_region_list) {
    $active_regions = array();
    foreach ($sub_region_list as $region_item) {
      if ($vars[$region_item]) {
        $active_regions[] = $region_item;
      }
    }
    $vars[$sub_region_key] = $sub_region_key .'-'. strval(count($active_regions));
  }
  
  // Generate menu tree from source of primary links
  $vars['primary_links_tree'] = menu_tree(variable_get('menu_primary_links_source', 'primary-links'));
  
// Use grouped import setting to avoid 30 stylesheet limit in IE
  if (!variable_get('preprocess_css', FALSE)) {
    $css = drupal_add_css();
    $style_count = substr_count($vars['setting_styles'] . $vars['ie6_styles'] . $vars['ie7_styles'] . $vars['ie8_styles'] . $vars['local_styles'], '<link');
    if (flexsys_css_count($css) > (30 - $style_count)) {
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
function flexsys_css_count($array) {
  $count = 0;
  foreach ($array as $item) {
    $count = (is_array($item)) ? $count + flexsys_css_count($item) : $count + 1;
  }
  return $count;
}

/**
 * Preprocess the slider variables.
 */
function flexsys_preprocess_slider(&$vars) {
  // abort if the slider has no nodes
  $valid = $vars['node']->field_slider_content[0]['nid'] != NULL;
  $vars['valid_slider'] = $valid ? TRUE : FALSE;
  if (!$valid) {
    return;
  }

  $num_slides = count($vars['node']->field_slider_content);

  $vars['tab'] = array();
  $vars['slide_content'] = array();

  for ($i = 0; $i < $num_slides; $i++) {
    $slide_node = node_load($vars['node']->field_slider_content[$i]['nid']);
    if (!$slide_node) {
      // node not found!
      continue;
    }

    // add the tabs
    $slide_id = "slider-nid$slide_node->nid";
    $slide_classes = 'slidetab';
    if ($i == 0) {
      $slide_classes .= ' slidetab-active';
    }
    $slide_options = array(
      'attributes' => array('class' => $slide_classes),
      'fragment'   => $slide_id,
	  'html' => TRUE,
    );
    $slide_title = '<span class="title">'.$slide_node->title.'</span><span class="subtitle">'.$slide_node->field_subtitle[0]['value'].'</span>';
    // if the slider node is set to the front page, do some special processing
    // set the link to be empty.
    $link = $_GET['q'];
    if (drupal_is_front_page() && empty($_SERVER['QUERY_STRING'])) {
      $link = '';
    }

    $vars['tabs'][$i] = array(
      'data' => l($slide_title, $link, $slide_options),
      'class' => 'tabtitle-' . $vars['node']->nid . '-' . $slide_node->nid,
    );

    // add the contents of each slide
    $slide_node_view = node_view($slide_node, FALSE, TRUE, FALSE);
    $vars['slide_content'][] = "<div class=\"panel\" id=\"$slide_id\">" . $slide_node_view . '</div>';
  }

  // theme nicely
  $vars['tabs_formatted'] = theme('item_list', $vars['tabs'], NULL, 'ul', array('class' => 'slidenav'));
  $vars['slider_content_formatted'] = implode("\n", $vars['slide_content']);

  // above or below
  $vars['tabs_position'] = variable_get("slider_tabs_position", 0);
}

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function flexsys_preprocess_node(&$vars, $hook) {
  // Special classes for nodes
  $classes = array('node');
  if ($vars['sticky']) {
    $classes[] = 'sticky';
  }
  if (!$vars['status']) {
    $classes[] = 'node-unpublished';
    $vars['unpublished'] = TRUE;
  }
  else {
    $vars['unpublished'] = FALSE;
  }
  if ($vars['uid'] && $vars['uid'] == $GLOBALS['user']->uid) {
    $classes[] = 'node-mine'; // Node is authored by current user.
  }
  if ($vars['teaser']) {
    $classes[] = 'node-teaser'; // Node is displayed as teaser.
  }
  // Class for node type: "node-type-page", "node-type-story", "node-type-my-custom-type", etc.
  $classes[] = flexsys_id_safe('node-type-' . $vars['type']);
  $vars['classes'] = implode(' ', $classes); // Concatenate with spaces
}

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function flexsys_preprocess_block(&$vars, $hook) {
  $block = $vars['block'];

  // Special classes for blocks.
  $classes = array('block');
  $classes[] = 'block-' . $block->module;
  $classes[] = 'region-' . $vars['block_zebra'];
  $classes[] = $vars['zebra'];
  $classes[] = 'region-count-' . $vars['block_id'];
  $classes[] = 'count-' . $vars['id']; 

  // Render block classes.
  $vars['classes'] = implode(' ', $classes);
}

function flexsys_preprocess_comment(&$vars, $hook) {
  // Add an "unpublished" flag.
  $vars['unpublished'] = ($vars['comment']->status == COMMENT_NOT_PUBLISHED);

  // If comment subjects are disabled, don't display them.
  if (variable_get('comment_subject_field_' . $vars['node']->type, 1) == 0) {
    $vars['title'] = '';
  }

  // Special classes for comments.
  $classes = array('comment');
  if ($vars['comment']->new) {
    $classes[] = 'comment-new';
  }
  $classes[] = $vars['status'];
  $classes[] = $vars['zebra'];
  if ($vars['id'] == 1) {
    $classes[] = 'first';
  }
  if ($vars['id'] == $vars['node']->comment_count) {
    $classes[] = 'last';
  }
  if ($vars['comment']->uid == 0) {
    // Comment is by an anonymous user.
    $classes[] = 'comment-by-anon';
  }
  else {
    if ($vars['comment']->uid == $vars['node']->uid) {
      // Comment is by the node author.
      $classes[] = 'comment-by-author';
    }
    if ($vars['comment']->uid == $GLOBALS['user']->uid) {
      // Comment was posted by current user.
      $classes[] = 'comment-mine';
    }
  }
  $vars['classes'] = implode(' ', $classes);
}

/**
* Display the simple view of rows one after another
*/
function flexsys_preprocess_views_view_unformatted(&$vars) {
$view     = $vars['view'];
$rows     = $vars['rows'];

$vars['classes'] = array();
// Set up striping values.
foreach ($rows as $id => $row) {
   $vars['classes'][$id] = 'views-row views-row-' . ($id + 1);
   $vars['classes'][$id] .= ' views-row-' . ($id % 2 ? 'even' : 'odd');
   if ($id == 0) {
     $vars['classes'][$id] .= ' views-row-first';
   }
}
$vars['classes'][$id] .= ' views-row-last';
}

/**
* Override the search block form so we can change the label
* @return 
* @param $form Object
*/
function phptemplate_search_block_form($form) {
  $output = '';
  
  // the search_block_form element is the search's text field, it also happens to be the form id, so can be confusing
  $form['search_block_form']['#title'] = t('');
  $form['submit']['#value'] = '';

  $output .= drupal_render($form);
  return $output;
}

function flexsys_links($links, $attributes = array('class' => 'links')) {
  $output = '';

  if (count($links) > 0) {
    $output = '<ul'. drupal_attributes($attributes) .'>';

    $num_links = count($links);
    $i = 1;

    foreach ($links as $key => $link) {
      $class = $key;

      // Add first, last and active classes to the list of links to help out themers.
      if ($i == 1) {
        $class .= ' first';
      }
      if ($i == $num_links) {
        $class .= ' last';
      }
      
      if (isset($link['href']) && $link['href'] == $_GET['q']) {
        $class .= ' active';
      }

	  $output .= '<li class="'. $class .'">';

     // Is the title HTML?
      $html = isset($link['html']) && $link['html'];

      // Initialize fragment and query variables.
      $link['query'] = isset($link['query']) ? $link['query'] : NULL;
      $link['fragment'] = isset($link['fragment']) ? $link['fragment'] : NULL;

      if (isset($link['href'])) {
        $link_options = array('attributes'  => $link['attributes'],
                              'query'       => $link['query'],
                              'fragment'    => $link['fragment'],
                              'absolute'    => FALSE,
                              'html'        => $html);
        $output .= l($link['title'], $link['href'], $link_options);
      }

      else if (!empty($link['title'])) {
        // Some links are actually not links, but we wrap these in <span> for adding title and class attributes
        if (empty($link['html'])) {
          $link['title'] = check_plain($link['title']);
        }
        $span_attributes = '';
        if (isset($link['attributes'])) {
          $span_attributes = drupal_attributes($link['attributes']);
        }
        $output .= '<span'. $span_attributes .'>'. $link['title'] .'</span>';
      }

      $i++;
      $output .= "</li>";
      $output .= " \n";
    }
    $output .= '</ul>';
  }
  return $output;
}



function flexsys_menu_item_link($link) {
  if (empty($link['options'])) {
    $link['options'] = array();
  }

  // If an item is a LOCAL TASK, render it as a tab
  if ($link['type'] & MENU_IS_LOCAL_TASK) {
    $link['title'] = '<span class="tab">' . check_plain($link['title']) . '</span>';
    $link['options']['html'] = TRUE;
  }

  if (empty($link['type'])) {
    $true = TRUE;
  }
  
  // Do special stuff for PRIMARY LINKS here
  if ($link['menu_name'] == 'primary-links') {
    $link['title'] = '<span>' . check_plain($link['title']) . '</span>';
    $link['options']['html'] = TRUE;
  }

  return l($link['title'], $link['href'], $link['options']);
}

/**
 * Converts a string to a suitable html ID attribute.
 *
 * http://www.w3.org/TR/html4/struct/global.html#h-7.5.2 specifies what makes a
 * valid ID attribute in HTML. This function:
 *
 * - Ensure an ID starts with an alpha character by optionally adding an 'id'.
 * - Replaces any character except alphanumeric characters with dashes.
 * - Converts entire string to lowercase.
 *
 * @param $string
 *   The string
 * @return
 *   The converted string
 */
function flexsys_id_safe($string) {
  // Replace with dashes anything that isn't A-Z, numbers, dashes, or underscores.
  $string = strtolower(preg_replace('/[^a-zA-Z0-9-]+/', '-', $string));
  // If the first character is not a-z, add 'id' in front.
  if (!ctype_lower($string{0})) { // Don't use ctype_alpha since its locale aware.
    $string = 'id' . $string;
  }
  return $string;
}

/*
* Override filter.module's theme_filter_tips() function to disable tips display.
*/
function flexsys_filter_tips($tips, $long = FALSE, $extra = '') {
  return '';
}

function flexsys_filter_tips_more_info () {
  return '';
}

// Override theme_button 
function phptemplate_button($element) { 
  // Make sure not to overwrite classes. 
  if (isset($element['#attributes']['class'])) { 
    $element['#attributes']['class'] = 'form-'. $element['#button_type'] .' '. $element['#attributes']['class']; 
  }
  else { 
    $element['#attributes']['class'] = 'form-'. $element['#button_type']; 
  } 
  
  if(!empty($element['#name']) && ($element['#name']=='photo' ||$element['#name']=='link')){
  	return '<input type="submit" '. (empty($element['#name']) ? '' : 'name="'. $element['#name'] .'" ') .'id="'. $element['#id'].'" value="'. check_plain($element['#value']) .'" '. drupal_attributes($element['#attributes']) ." />\n";
  }
  // We here wrap the output with a couple span tags 
  return '<span class="button"><input type="submit" '. (empty($element['#name']) ? '' : 'name="'. $element['#name'] .'" ') .'id="'. $element['#id'].'" value="'. check_plain($element['#value']) .'" '. drupal_attributes($element['#attributes']) ." /></span>\n"; 
}

function flexsys_thumb_user_picture ($picture, $imagecache_preset, $user_name, $user_uid) {
  if (!isset($picture) || $picture == '') {
    $picture = variable_get('user_picture_default', '');
  }
    
  $img = theme('imagecache', $imagecache_preset, $picture, $user_name, $user_name);  
  
  if (user_access('access user profiles')) {
    return l($img, "user/{$user_uid}", array('html' => TRUE));
  }
  else { 
    return $img;
  }
}
