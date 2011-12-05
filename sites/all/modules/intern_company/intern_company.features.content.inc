<?php

/**
 * Implementation of hook_content_default_fields().
 */
function intern_company_content_default_fields() {
  $fields = array();

  // Exported field: field_company_logo
  $fields['company-field_company_logo'] = array(
    'field_name' => 'field_company_logo',
    'type_name' => 'company',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'image_plain',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'image_plain',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'image_plain',
        'exclude' => 0,
      ),
      '2' => array(
        'format' => 'image_plain',
        'exclude' => 0,
      ),
      '3' => array(
        'format' => 'image_plain',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'image_plain',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'filefield',
    'required' => '0',
    'multiple' => '0',
    'module' => 'filefield',
    'active' => '1',
    'list_field' => '0',
    'list_default' => 1,
    'description_field' => '0',
    'widget' => array(
      'file_extensions' => 'png gif jpg jpeg',
      'file_path' => 'pictures/company',
      'progress_indicator' => 'bar',
      'max_filesize_per_file' => '',
      'max_filesize_per_node' => '',
      'max_resolution' => '0',
      'min_resolution' => '0',
      'alt' => '',
      'custom_alt' => 0,
      'title' => '',
      'custom_title' => 0,
      'title_type' => 'textfield',
      'default_image' => NULL,
      'use_default_image' => 0,
      'insert' => 0,
      'insert_styles' => array(
        'auto' => 0,
        'link' => 0,
        'image' => 0,
        'imagecache_group_images' => 0,
        'imagecache_group_images_featured' => 0,
        'imagecache_group_images_medium' => 0,
        'imagecache_group_images_showcase' => 0,
        'imagecache_group_images_thumb' => 0,
        'imagecache_member_list_image' => 0,
        'imagecache_profile_pictures' => 0,
        'imagecache_Small' => 0,
        'imagecache_user_picture_meta' => 0,
        'imagecache_Featured' => 0,
      ),
      'insert_default' => 'auto',
      'insert_class' => '',
      'insert_width' => '',
      'label' => '公司Logo',
      'weight' => '-4',
      'description' => '',
      'type' => 'imagefield_widget',
      'module' => 'imagefield',
    ),
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('公司Logo');

  return $fields;
}
