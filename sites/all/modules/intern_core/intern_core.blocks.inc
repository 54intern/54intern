<?php
/**
 * @file
 *   All block-related functions of intern_core
 */
/**
 * Callback for hook_block_view()
 */
function _intern_core_block($op = 'list', $delta = 0, $edit = array()) {
  switch ($op) {
    case 'list':
      $function = "_intern_core_block_list";
      break;
    case 'view':
    case 'configure':
    case 'save':
      $function = "_intern_core_{$delta}_block_{$op}";
      break;
  }
  
  if ($function && function_exists($function)) {
    return call_user_func($function, $edit); 
  }
}

/**
 * Declare a list of all the available blocks
 */
function _intern_core_block_list() {
  $blocks = array();
  $blocks['create_company'] = array(
    'info' => t('Create a company'),
    'cache' => BLOCK_CACHE_GLOBAL,
  );
  return $blocks;
}

/**
 * Display the "create a company" block
 */
function _intern_core_create_company_block_view() {
  // Check permissions
  if (node_access('create', 'company')) {
    module_load_include('inc', 'intern_core', 'intern_core.form');
    return array(
      'subject' => '',
      'content' => drupal_get_form('intern_core_create_company_form'),
    );
  }

  return NULL;
}