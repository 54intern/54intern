<?php

/**
 * Implementation of hook_ctools_plugin_api().
 */
function intern_job_ctools_plugin_api() {
  list($module, $api) = func_get_args();
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => 1);
  }
}

/**
 * Implementation of hook_node_info().
 */
function intern_job_node_info() {
  $items = array(
    'job' => array(
      'name' => t('职位'),
      'module' => 'features',
      'description' => t('intern job info'),
      'has_title' => '1',
      'title_label' => t('职位名称'),
      'has_body' => '1',
      'body_label' => t('职位描述'),
      'min_word_count' => '0',
      'help' => '',
    ),
  );
  return $items;
}
