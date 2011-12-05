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

function phptemplate_settings($saved_settings) {
  // Get the node types
  $node_types = node_get_types('names');

/**
 * The default values for the theme variables. Make sure $defaults exactly
 * matches the $defaults in the template.php file.
 */
  $defaults = array(
    'icontact_style' => 'brightblue',
    'icontact_layout'=> 'layout',
  );

  // Make the default content-type settings the same as the default theme settings,
  // so we can tell if content-type-specific settings have been altered.
  $defaults = array_merge($defaults, theme_get_settings());

  // Merge the saved variables and their default values
  $settings = array_merge($defaults, $saved_settings);

  // Create theme settings form widgets using Forms API

  // TNT Fieldset
  $form['tnt_container'] = array(
    '#type' => 'fieldset',
    '#title' => t('General settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['tnt_container']['style_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Contact theme specific setting'),
    '#description' => t('Use color & layout setting to change default style for your theme.'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
	'#attributes' => array('class' => 'style_settings'),
  );

  $form['tnt_container']['style_settings']['icontact_style'] = array(
    '#type' => 'select',
    '#title' => t('Color'),
    '#default_value' => $settings['icontact_style'],
    '#options' => array(
      'brightblue' => t('Bright Blue'),
	  'orange'     => t('Orange'),
      'green'      => t('Green'),
      'blue'       => t('Blue'),
      'red'        => t('Red'),
    ),
  ); 

  $form['tnt_container']['style_settings']['icontact_layout'] = array(
    '#type' => 'select',
    '#title' => t('Layout'),
    '#default_value' => $settings['icontact_layout'],
    '#options' => array(
      'layout' => t('Content + Left + Right'),
      'layout_lrc' => t('Left + Right + Content'),
	  'layout_lcr' => t('Left + Content + Right'),
    )
  );
 
  // Return theme settings form
  return $form;
}  

?>