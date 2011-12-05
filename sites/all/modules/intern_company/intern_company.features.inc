<?php

/**
 * Implementation of hook_ctools_plugin_api().
 */
function intern_company_ctools_plugin_api() {
  list($module, $api) = func_get_args();
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => 1);
  }
}

/**
 * Implementation of hook_node_info().
 */
function intern_company_node_info() {
  $items = array(
    'company' => array(
      'name' => t('公司'),
      'module' => 'features',
      'description' => t('A company which member contents(Jobs) can be part of.'),
      'has_title' => '1',
      'title_label' => t('公司名称'),
      'has_body' => '1',
      'body_label' => t('公司介绍'),
      'min_word_count' => '0',
      'help' => '',
    ),
  );
  return $items;
}
