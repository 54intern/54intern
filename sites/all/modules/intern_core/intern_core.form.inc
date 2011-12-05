<?php

/**
 * @file
 *   Form building and altering functions
 */
/**
 * Provide the form for the "create a company" block
 */
function intern_core_create_company_form() {
  // Permissions should be check before renderings this form
  $form = array();
  $form['#action'] = url('node/add/company');
  $form['create'] = array(
    '#type' => 'submit',
    '#value' => t('Create a company'),
  );
  return $form;
}

