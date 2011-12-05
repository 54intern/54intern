<?php

/**
 * Implementation of hook_strongarm().
 */
function intern_company_strongarm() {
  $export = array();
  $strongarm = new stdClass;
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'comment_anonymous_company';
  $strongarm->value = 0;

  $export['comment_anonymous_company'] = $strongarm;
  $strongarm = new stdClass;
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'comment_company';
  $strongarm->value = '2';

  $export['comment_company'] = $strongarm;
  $strongarm = new stdClass;
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'comment_controls_company';
  $strongarm->value = '3';

  $export['comment_controls_company'] = $strongarm;
  $strongarm = new stdClass;
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'comment_default_mode_company';
  $strongarm->value = '4';

  $export['comment_default_mode_company'] = $strongarm;
  $strongarm = new stdClass;
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'comment_default_order_company';
  $strongarm->value = '1';

  $export['comment_default_order_company'] = $strongarm;
  $strongarm = new stdClass;
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'comment_default_per_page_company';
  $strongarm->value = '50';

  $export['comment_default_per_page_company'] = $strongarm;
  $strongarm = new stdClass;
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'comment_form_location_company';
  $strongarm->value = '0';

  $export['comment_form_location_company'] = $strongarm;
  $strongarm = new stdClass;
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'comment_preview_company';
  $strongarm->value = '1';

  $export['comment_preview_company'] = $strongarm;
  $strongarm = new stdClass;
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'comment_subject_field_company';
  $strongarm->value = '1';

  $export['comment_subject_field_company'] = $strongarm;
  $strongarm = new stdClass;
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'content_extra_weights_company';
  $strongarm->value = array(
    'title' => '-5',
    'body_field' => '2',
    'revision_information' => '6',
    'author' => '5',
    'options' => '7',
    'comment_settings' => '10',
    'menu' => '-2',
    'path' => '8',
    'attachments' => '9',
    'og_description' => '-3',
    'og_selective' => '1',
    'og_register' => '0',
    'og_directory' => '3',
    'og_language' => '-1',
    'og_private' => '4',
  );

  $export['content_extra_weights_company'] = $strongarm;
  $strongarm = new stdClass;
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'language_content_type_company';
  $strongarm->value = '0';

  $export['language_content_type_company'] = $strongarm;
  $strongarm = new stdClass;
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'node_options_company';
  $strongarm->value = array(
    0 => 'status',
  );

  $export['node_options_company'] = $strongarm;
  $strongarm = new stdClass;
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'og_content_type_usage_company';
  $strongarm->value = 'group';

  $export['og_content_type_usage_company'] = $strongarm;
  $strongarm = new stdClass;
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'upload_company';
  $strongarm->value = '1';

  $export['upload_company'] = $strongarm;
  return $export;
}
