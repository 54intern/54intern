<?php
/* $Id$ */

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
    'icontact_style' => 'brightblue',
    'icontact_layout'=> 'layout',
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

function get_icontact_style() {
  $style = theme_get_setting('icontact_style');
  return $style;
}

function get_icontact_layout() {
  $style = theme_get_setting('icontact_layout');
  return $style;
}

drupal_add_css(drupal_get_path('theme', 'icontact') . '/css/' . get_icontact_style() . '.css', 'theme');
drupal_add_css(drupal_get_path('theme', 'icontact') . '/css/' . get_icontact_layout() . '.css', 'theme');

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
    $classes[] = icontact_id_safe('page-' . $path);
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
    $classes[] = icontact_id_safe('section-' . $section);
  }
 
  $vars['body_classes_array'] = $classes;
  $vars['body_classes'] = implode(' ', $classes); // Concatenate with spaces.
  
  // Add content top & postscript classes with number of active sub-regions
  $region_list = array(
    'main_top' => array('main_top_one', 'main_top_two', 'main_top_three', 'main_top_four'), 
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
}

/**
 * Preprocess the slider variables.
 */
function icontact_preprocess_slider(&$vars) {
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

	if ($i == 1) {
    $vars['tabs'][$i] = array(
      'data' => l($slide_title, $link, $slide_options),
      'class' => 'tabtitle-' . $vars['node']->nid . '-' . $slide_node->nid .' second', );      
	} elseif ($i == 2) {
    $vars['tabs'][$i] = array(
      'data' => l($slide_title, $link, $slide_options),
      'class' => 'tabtitle-' . $vars['node']->nid . '-' . $slide_node->nid .' third', );      
	} else {
    $vars['tabs'][$i] = array(
      'data' => l($slide_title, $link, $slide_options),
      'class' => 'tabtitle-' . $vars['node']->nid . '-' . $slide_node->nid, );
	}

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
function icontact_preprocess_node(&$vars, $hook) {
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
  if ($vars['id'] == 1) {
    $classes[] = 'node-first';
  }
  if ($vars['teaser']) {
    $classes[] = 'node-teaser'; // Node is displayed as teaser.
  }
  // Class for node type: "node-type-page", "node-type-story", "node-type-my-custom-type", etc.
  $classes[] = icontact_id_safe('node-type-' . $vars['type']);
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
function icontact_preprocess_block(&$vars, $hook) {
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

function icontact_preprocess_comment(&$vars, $hook) {
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
* Override the search theme form so we can change the label
* @return 
* @param $form Object
*/
function phptemplate_search_theme_form($form) {
  $output = '';
  
  $form['search_theme_form']['#title'] = t('');
  $form['submit']['#value'] = '';

  $output .= drupal_render($form);
  return $output;
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

  $output .= drupal_render($form);
  return $output;
}

function icontact_links($links, $attributes = array('class' => 'links')) {
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

function icontact_menu_item_link($link) {
  if (empty($link['options'])) {
    $link['options'] = array();
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
function icontact_id_safe($string) {
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
function icontact_filter_tips($tips, $long = FALSE, $extra = '') {
  return '';
}

function icontact_filter_tips_more_info () {
  return '';
}