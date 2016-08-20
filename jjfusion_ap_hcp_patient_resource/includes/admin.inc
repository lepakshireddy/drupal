<?php

/**
 * @file
 * Admin settings for the Janssen HCP profile module.
 */

/**
 * Display Janssen HCP Profile Setings Configuration form.
 */
function jjfusion_ap_hcp_patient_resource_settings_form($form, $form_state) {
  $form['resources_email'] = array(
    '#type' => 'fieldset',
    '#title' => t('Patient Resources Email settings'),
    '#description' => t('Edit the  patient resources e-mail settings.'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  $form['resources_email']['jjfusion_ap_hcp_patient_resource_email_subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Email Subject'),
    '#default_value' => variable_get('jjfusion_ap_hcp_patient_resource_email_subject', ''),
    '#required' => TRUE,
  );
  $form['resources_email']['jjfusion_ap_hcp_patient_resource_header'] = array(
    '#type' => 'textarea',
    '#title' => t('Resources Header'),
    '#default_value' => variable_get('jjfusion_ap_hcp_patient_resource_header', ''),
    '#required' => TRUE,
  );
  $form['resources_email']['jjfusion_ap_hcp_patient_resource_email_body_header'] = array(
    '#type' => 'textarea',
    '#title' => t('Resources Header in email body'),
    '#default_value' => variable_get('jjfusion_ap_hcp_patient_resource_email_body_header', ''),
    '#required' => TRUE,
  );
  $form['resources_email']['jjfusion_ap_hcp_patient_resource_condition_info'] = array(
    '#type' => 'textarea',
    '#title' => t('Condition Information'),
    '#default_value' => variable_get('jjfusion_ap_hcp_patient_resource_condition_info', ''),
    '#required' => TRUE,
  );
  $form['resources_email']['jjfusion_ap_hcp_patient_resource_product_info'] = array(
    '#type' => 'textarea',
    '#title' => t('Product Information'),
    '#default_value' => variable_get('jjfusion_ap_hcp_patient_resource_product_info', ''),
    '#required' => TRUE,
  );
  $form['resources_email']['jjfusion_ap_hcp_patient_resource_email_footer'] = array(
    '#type' => 'textarea',
    '#title' => t('Email Body Footer'),
    '#default_value' => variable_get('jjfusion_ap_hcp_patient_resource_email_footer', ''),
    '#required' => TRUE,
  );
  $form['genric_copy'] = array(
    '#type' => 'fieldset',
    '#title' => t('Generic copy for Product and Condition settings'),
    '#description' => t('Edit Generic copy for Product and Condition settings.'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  $form['genric_copy']['jjfusion_ap_hcp_patient_resource_products_generic_products'] = array(
    '#type' => 'textarea',
    '#title' => t('Products Generic Copy'),
    '#default_value' => variable_get('jjfusion_ap_hcp_patient_resource_products_generic_products', ''),
  );
  $form['genric_copy']['jjfusion_ap_hcp_patient_resource_products_generic_condition'] = array(
    '#type' => 'textarea',
    '#title' => t('conditions Generic Copy'),
    '#default_value' => variable_get('jjfusion_ap_hcp_patient_resource_products_generic_condition', ''),
  );
  $form['patient_login'] = array(
    '#type' => 'fieldset',
    '#title' => t('Patient login settings'),
    '#description' => t('COnfigure the secrect keys of the patient which accessing patient resources.'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  $form['patient_login']['jjfusion_ap_hcp_patient_resource_secret_keys'] = array(
    '#type' => 'textarea',
    '#title' => t('Secret Keys'),
    '#default_value' => variable_get('jjfusion_ap_hcp_patient_resource_secret_keys', ''),
  );
  $form['patient_login']['jjfusion_ap_hcp_patient_resource_patient_username'] = array(
    '#type' => 'textfield',
    '#title' => t('patient username'),
    '#default_value' => variable_get('jjfusion_ap_hcp_patient_resource_patient_username', ''),
  );
  $form['patient_login']['jjfusion_ap_hcp_patient_resource_patient_pages_list'] = array(
    '#type' => 'textarea',
    '#title' => t('List of patient pages'),
    '#default_value' => variable_get('jjfusion_ap_hcp_patient_resource_patient_pages_list', ''),
  );
  return system_settings_form($form);
}
