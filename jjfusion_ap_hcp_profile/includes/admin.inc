<?php

/**
 * @file
 * Admin settings for the Janssen HCP profile module.
 */

/**
 * Display Janssen HCP Profile Setings Configuration form.
 */
function jnj_veeva_hcp_profile_settings_form($form, $form_state) {

  if (!empty($form_state['input'])) {
    $jnj_veeva_hcp_profile_settings = $form_state['input'];
  }
  else {
    $jnj_veeva_hcp_profile_settings = drupal_json_decode(variable_get('jnj_veeva_hcp_profile_settings', ''));
  }

  $form['#tree'] = TRUE;

  $form['registration_picklist'] = array(
    '#type' => 'fieldset',
    '#title' => t('Registration Picklist'),
  );

  $form['registration_picklist']['update'] = array(
    '#type' => 'submit',
    '#value' => t('Update Picklist'),
    '#submit' => array('jnj_veeva_hcp_profile_update_picklist'),
  );

  $form['service_url'] = array(
    '#title' => 'Service URL',
    '#type' => 'textfield',
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_settings['service_url'],
  );
  $form['iconnect_enable_phase2_features'] = array(
    '#title' => 'Enable Phase 2 features',
    '#type' => 'checkbox',
    '#descrition' => 'Enable Phase 2 features of AU like optin preferences, emailoptout, survey, portal activity',
    '#default_value' => $jnj_veeva_hcp_profile_settings['iconnect_enable_phase2_features'],
  );
  $form['iconnect_disable_auto_verification'] = array(
    '#title' => 'Disable auto verification with iConnect',
    '#type' => 'checkbox',
    '#default_value' => $jnj_veeva_hcp_profile_settings['iconnect_disable_auto_verification'],
  );
  $form['iconnect_country_specific_enabled'] = array(
    '#title' => 'iConnect Country specific code enabled',
    '#type' => 'checkbox',
    '#default_value' => TRUE,
  );
  $form['iconnect_country_specific_enabled']['#default_value'] = $jnj_veeva_hcp_profile_settings['iconnect_country_specific_enabled'];
  $form['iconnect_country_code'] = array(
    '#title' => 'iConnect Country code',
    '#type' => 'textfield',
    '#default_value' => $jnj_veeva_hcp_profile_settings['iconnect_country_code'],
  );
  $form['site_cc_email'] = array(
    '#type' => 'textfield',
    '#title' => t('CC email to the all emails'),
    '#default_value' => $jnj_veeva_hcp_profile_settings['site_cc_email'],
    '#required' => FALSE,
  );
  $form['no_of_registraion_steps'] = array(
    '#title' => 'No of Registration steps',
    '#type' => 'textfield',
    '#default_value' => $jnj_veeva_hcp_profile_settings['no_of_registraion_steps'],
  );
  $form['redirect_url_login'] = array(
    '#title' => 'Redirect URL after Login/Registration success',
    '#type' => 'textfield',
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_settings['redirect_url_login'],
  );

  if (!(isset($_ENV['AH_PRODUCTION']) && $_ENV['AH_PRODUCTION'])) {
    // p($registration_picklist);
    $registration_picklist = drupal_json_decode(variable_get('janssen_hcp_registration_picklist', ''));
    if (!is_array($registration_picklist['portals'])) {
      $registration_picklist['portals'] = array($registration_picklist['portals']);
    }
    $form['veeva_service_portal'] = array(
      '#title' => 'Veeva Service Portal',
      '#type' => 'select',
      '#options' => (is_array($registration_picklist['portals']) ? drupal_map_assoc($registration_picklist['portals']) : array()),
      '#empty_option' => 'Select',
      '#default_value' => $jnj_veeva_hcp_profile_settings['veeva_service_portal'],
    );
  }
  $form['consent_text'] = array(
    '#title' => 'Consent Text',
    '#type' => 'textarea',
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_settings['consent_text'],
  );
  $form['help_icon_text'] = array(
    '#title' => 'Help Icon Text',
    '#type' => 'textarea',
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_settings['help_icon_text'],
  );

  $form['jnj_veeva_hcp_exclude_extlogin_user_roles'] = array(
    '#title' => 'Exclude user roles from External Login',
    '#type' => 'checkboxes',
    '#options' => user_roles(),
    '#default_value' => isset($jnj_veeva_hcp_profile_settings['jnj_veeva_hcp_exclude_extlogin_user_roles']) ? $jnj_veeva_hcp_profile_settings['jnj_veeva_hcp_exclude_extlogin_user_roles'] : array(3),
  );
  $form['jnj_veeva_hcp_all_therapy_area_value'] = array(
    '#title' => '"All Therapy areas" option value to check in registration',
    '#type' => 'textfield',
    '#default_value' => isset($jnj_veeva_hcp_profile_settings['jnj_veeva_hcp_all_therapy_area_value']) ? $jnj_veeva_hcp_profile_settings['jnj_veeva_hcp_all_therapy_area_value'] : 'All Therapy Areas',
  );
  $form['home_page_header'] = array(
    '#title' => 'Home page header',
    '#type' => 'textarea',
    '#default_value' => $jnj_veeva_hcp_profile_settings['home_page_header'],
  );

  $form['Submit'] = array(
    '#type' => 'submit',
    '#value' => 'Save Configuration',
  );
  return $form;
}

/**
 * Save Janssen HCP Profile Setings Configuration form.
 */
function jnj_veeva_hcp_profile_settings_form_submit($form, $form_state) {

  form_state_values_clean($form_state);
  variable_set('jnj_veeva_hcp_profile_settings', drupal_json_encode($form_state['values']));
  drupal_set_message(t("Settings saved successfully"));
}

/**
 * Display Janssen HCP Profile Signup Configuration(Label & Error) form.
 */
function jnj_veeva_hcp_profile_signup_settings_form($form, &$form_state) {

  if (isset($form_state['values'])) {
    $jnj_veeva_hcp_profile_signup_settings = $form_state['values'];
  }
  else {
    $jnj_veeva_hcp_profile_signup_settings = drupal_json_decode(variable_get('jnj_veeva_hcp_profile_signup_settings', ''));
  }
  // echo"<pre>";print_r($jnj_veeva_hcp_profile_signup_settings);exit;
  for ($i = 1; $i <= 5; $i++) {
    $form['step' . $i] = array(
      '#type' => 'fieldset',
      '#title' => check_plain(t('step') . ' ' . $i),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    );

    $form_state['storage']['step'] = $i;
    $registration_form = jnj_veeva_hcp_profile_registration(array(), $form_state);
    foreach ($registration_form['userProfile']['step' . $i] as $key => $val) {
      if ($val != '' && is_array($val) && isset($val['#type']) && $val['#type'] != 'markup') {
        $title = (isset($val['#title']) ? $val['#title'] : $val['#attributes']['placeholder']);
        $form['step' . $i][$key . '_set'] = array(
          '#type' => 'fieldset',
          '#title' => check_plain($title),
        );
        if (isset($title)) {
          $form['step' . $i][$key . '_set'][$key . '_label'] = array(
            '#type' => 'textfield',
            '#title' => 'Title/Placeholder Label',
            '#size' => 60,
            '#maxlength' => 255,
            '#default_value' => isset($jnj_veeva_hcp_profile_signup_settings[$key . '_label']) ? $jnj_veeva_hcp_profile_signup_settings[$key . '_label'] : NULL,
          );
        }
        if (isset($val['#required_error'])) {
          $form['step' . $i][$key . '_set'][$key . '_req_error'] = array(
            '#type' => 'textfield',
            '#title' => 'Required Validation Messsage',
            '#size' => 60,
            '#maxlength' => 255,
            '#default_value' => isset($jnj_veeva_hcp_profile_signup_settings[$key . '_req_error']) ? $jnj_veeva_hcp_profile_signup_settings[$key . '_req_error'] : NULL,
          );
        }

        if (isset($val['#rules'])) {
          foreach ($val['#rules'] as $rule) {
            $form['step' . $i][$key . '_set'][$rule['rule'] . '_other_error'] = array(
              '#type' => 'textfield',
              '#title' => check_plain(ucfirst($rule['rule']) . ' ' . t('Validation Messsage')),
              '#size' => 60,
              '#maxlength' => 255,
              '#default_value' => isset($jnj_veeva_hcp_profile_signup_settings[$rule['rule'] . '_other_error']) ? $jnj_veeva_hcp_profile_signup_settings[$rule['rule'] . '_other_error'] : NULL,
            );
          }
        }
      }
    }
  }
  $form['Submit'] = array(
    '#type' => 'submit',
    '#value' => 'Submit',
  );

  return $form;
}

/**
 * Save Janssen HCP Profile Signup Configuration(Label & Error) form.
 */
function jnj_veeva_hcp_profile_signup_settings_form_submit($form, &$form_state) {
  form_state_values_clean($form_state);
  variable_set('jnj_veeva_hcp_profile_signup_settings', drupal_json_encode($form_state['values']));
  drupal_set_message(t("Data saved successfully"));
}

/**
 * Display Janssen HCP Profile Message Configuration form.
 */
function jnj_veeva_hcp_profile_message_form($form, $form_state) {

  if (!empty($form_state['input'])) {
    $jnj_veeva_hcp_profile_messages = $form_state['input'];
  }
  else {
    $jnj_veeva_hcp_profile_messages = drupal_json_decode(variable_get('jnj_veeva_hcp_profile_messages'));
  }

  $form['profile_created_success'] = array(
    '#type' => 'textarea',
    '#title' => t('Profile Created Success'),
    '#maxlength' => 256,
    '#rows' => 2,
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_messages['profile_created_success'],
  );
  $form['invalid_registration_code'] = array(
    '#type' => 'textarea',
    '#title' => t('Invalid Registration Code'),
    '#maxlength' => 256,
    '#rows' => 2,
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_messages['invalid_registration_code'],
  );
  $form['profile_already_exist_same_security'] = array(
    '#type' => 'textarea',
    '#title' => t('Profile Already Exist Same Security'),
    '#maxlength' => 256,
    '#rows' => 2,
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_messages['profile_already_exist_same_security'],
  );
  $form['profile_already_exist_diff_security'] = array(
    '#type' => 'textarea',
    '#title' => t('Profile Already Exist Different Security'),
    '#maxlength' => 256,
    '#rows' => 2,
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_messages['profile_already_exist_diff_security'],
  );
  $form['profile_already_exist_in_progress'] = array(
    '#type' => 'textarea',
    '#title' => t('Profile Already Exist In Progress'),
    '#maxlength' => 256,
    '#rows' => 2,
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_messages['profile_already_exist_in_progress'],
  );
  $form['profile_general_failure_heading'] = array(
    '#type' => 'textarea',
    '#title' => t('Profile General Error Heading'),
    '#maxlength' => 256,
    '#rows' => 2,
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_messages['profile_general_failure_heading'],
  );
  $form['profile_general_failure'] = array(
    '#type' => 'textarea',
    '#title' => t('Profile General error message'),
    '#maxlength' => 256,
    '#rows' => 2,
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_messages['profile_general_failure'],
  );
  $form['invalid_login_email_not_exist'] = array(
    '#type' => 'textarea',
    '#title' => t('Invalid Login - Email not exist'),
    '#maxlength' => 256,
    '#rows' => 2,
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_messages['invalid_login_email_not_exist'],
  );
  $form['invalid_login_email_exist_diff_security'] = array(
    '#type' => 'textarea',
    '#title' => t('Invalid Login - Email Exist with Different Security'),
    '#maxlength' => 256,
    '#rows' => 2,
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_messages['invalid_login_email_exist_diff_security'],
  );

  $form['forgot_password_valid_email'] = array(
    '#type' => 'textarea',
    '#title' => t('Forgot Password Valid Email'),
    '#maxlength' => 256,
    '#rows' => 2,
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_messages['forgot_password_valid_email'],
  );
  $form['forgot_password_invalid_email'] = array(
    '#type' => 'textarea',
    '#title' => t('Forgot Password Invalid Email'),
    '#maxlength' => 256,
    '#rows' => 2,
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_messages['forgot_password_invalid_email'],
  );
  $form['forgot_email_security_question_does_not_match'] = array(
    '#type' => 'textarea',
    '#title' => t('Forgot Email - Security Question Does Not Match'),
    '#maxlength' => 256,
    '#rows' => 2,
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_messages['forgot_email_security_question_does_not_match'],
  );
  $form['reset_pwd_vercode_not_valid'] = array(
    '#type' => 'textarea',
    '#title' => t('Profile Email Verification Code Invalid'),
    '#maxlength' => 256,
    '#rows' => 2,
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_messages['reset_pwd_vercode_not_valid'],
  );
  $form['password_update_success'] = array(
    '#type' => 'textarea',
    '#title' => t('Profile Password Update Success'),
    '#maxlength' => 256,
    '#rows' => 2,
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_hcp_profile_messages['password_update_success'],
  );
  $form['hcp_contactuspage_message'] = array(
    '#type' => 'textarea',
    '#title' => t('Contact Us Page Message'),
    '#default_value' => $jnj_veeva_hcp_profile_messages['hcp_contactuspage_message'],
    '#rows' => 10,
  );
  $form['Submit'] = array(
    '#type' => 'submit',
    '#value' => 'Save Configuration',
  );
  return $form;
}

/**
 * Save Janssen HCP Profile Message Configuration form.
 */
function jnj_veeva_hcp_profile_message_form_submit($form, $form_state) {
  form_state_values_clean($form_state);
  variable_set('jnj_veeva_hcp_profile_messages', drupal_json_encode($form_state['values']));
  drupal_set_message(t("Messages saved successfully"));
}

/**
 * Display Janssen HCP Profile Email Configuration form.
 */
function jnj_veeva_hcp_profile_email_templates_form($form, $form_state) {

  if (!empty($form_state['input'])) {
    $jnj_veeva_hcp_profile_email_templates = $form_state['input'];
  }
  else {
    $jnj_veeva_hcp_profile_email_templates = drupal_json_decode(variable_get('jnj_veeva_hcp_profile_email_templates'));
  }

  $form['#tree'] = TRUE;

  $form['hcp_email_templates'] = array(
    '#type' => 'item',
    '#title' => t('HCP Email Templates'),
  );

  $form['vertical_tabs'] = array(
    '#type' => 'vertical_tabs',
  );

  $form['registration'] = array(
    '#type' => 'fieldset',
    '#title' => t('Registration Success'),
    '#description' => t('Edit the welcome e-mail messages sent to new user.'),
    '#group' => 'vertical_tabs',
  );
  $form['registration']['subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Subject'),
    '#default_value' => $jnj_veeva_hcp_profile_email_templates['registration']['subject'],
    '#maxlength' => 180,
    '#required' => TRUE,
  );
  $form['registration']['body'] = array(
    '#type' => 'textarea',
    '#title' => t('Body'),
    '#default_value' => $jnj_veeva_hcp_profile_email_templates['registration']['body'],
    '#rows' => 15,
    '#required' => TRUE,
  );
  $form['registration_auto_fail_admin'] = array(
    '#type' => 'fieldset',
    '#title' => t('Registration Auto Verification fail to Admin'),
    '#description' => t('If auto verification fail send mail to Admin'),
    '#group' => 'vertical_tabs',
  );
  $form['registration_auto_fail_admin']['subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Subject'),
    '#default_value' => $jnj_veeva_hcp_profile_email_templates['registration_auto_fail_admin']['subject'],
    '#maxlength' => 180,
    '#required' => TRUE,
  );
  $form['registration_auto_fail_admin']['body'] = array(
    '#type' => 'textarea',
    '#title' => t('Body'),
    '#default_value' => $jnj_veeva_hcp_profile_email_templates['registration_auto_fail_admin']['body'],
    '#rows' => 15,
    '#required' => TRUE,
  );
  $form['registration_auto_fail_hcp'] = array(
    '#type' => 'fieldset',
    '#title' => t('Registration Auto Verification fail to HCP'),
    '#description' => t('If auto verification fail send mail to HCP'),
    '#group' => 'vertical_tabs',
  );
  $form['registration_auto_fail_hcp']['subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Subject'),
    '#default_value' => $jnj_veeva_hcp_profile_email_templates['registration_auto_fail_hcp']['subject'],
    '#maxlength' => 180,
    '#required' => TRUE,
  );
  $form['registration_auto_fail_hcp']['body'] = array(
    '#type' => 'textarea',
    '#title' => t('Body'),
    '#default_value' => $jnj_veeva_hcp_profile_email_templates['registration_auto_fail_hcp']['body'],
    '#rows' => 15,
    '#required' => TRUE,
  );
  $form['forgot_password'] = array(
    '#type' => 'fieldset',
    '#title' => t('Forgot Password'),
    '#description' => t('Edit the e-mail messages sent to users who request a new password.'),
    '#group' => 'vertical_tabs',
  );
  $form['forgot_password']['subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Subject'),
    '#default_value' => $jnj_veeva_hcp_profile_email_templates['forgot_password']['subject'],
    '#maxlength' => 180,
    '#required' => TRUE,
  );
  $form['forgot_password']['body'] = array(
    '#type' => 'textarea',
    '#title' => t('Body'),
    '#default_value' => $jnj_veeva_hcp_profile_email_templates['forgot_password']['body'],
    '#rows' => 12,
    '#required' => TRUE,
  );

  $form['reset_password'] = array(
    '#type' => 'fieldset',
    '#title' => t('Reset Password'),
    '#description' => t('Edit the e-mail messages sent to users who updated the password.'),
    '#group' => 'vertical_tabs',
  );
  $form['reset_password']['subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Subject'),
    '#default_value' => $jnj_veeva_hcp_profile_email_templates['reset_password']['subject'],
    '#maxlength' => 180,
    '#required' => TRUE,
  );
  $form['reset_password']['body'] = array(
    '#type' => 'textarea',
    '#title' => t('Body'),
    '#default_value' => $jnj_veeva_hcp_profile_email_templates['reset_password']['body'],
    '#rows' => 12,
    '#required' => TRUE,
  );

  $form['hcp_request_visit'] = array(
    '#type' => 'fieldset',
    '#title' => t('HCP Request Visit'),
    '#description' => t('Edit the e-mail messages sent to users who updated the password.'),
    '#group' => 'vertical_tabs',
  );
  $form['hcp_request_visit']['subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Subject'),
    '#default_value' => $jnj_veeva_hcp_profile_email_templates['hcp_request_visit']['subject'],
    '#maxlength' => 180,
    '#required' => TRUE,
  );
  $form['hcp_request_visit']['body'] = array(
    '#type' => 'textarea',
    '#title' => t('Body'),
    '#default_value' => $jnj_veeva_hcp_profile_email_templates['hcp_request_visit']['body'],
    '#rows' => 12,
    '#required' => TRUE,
  );
  $form['hcp_optin_preferences'] = array(
    '#type' => 'fieldset',
    '#title' => t('HCP Optin Preferences'),
    '#description' => t('Optin preferences email to the subject'),
    '#group' => 'vertical_tabs',
  );
  $form['hcp_optin_preferences']['subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Subject'),
    '#default_value' => $jnj_veeva_hcp_profile_email_templates['hcp_optin_preferences']['subject'],
    '#maxlength' => 180,
    '#required' => TRUE,
  );
  $form['hcp_optin_preferences']['body'] = array(
    '#type' => 'textarea',
    '#title' => t('Body'),
    '#default_value' => $jnj_veeva_hcp_profile_email_templates['hcp_optin_preferences']['body'],
    '#rows' => 12,
    '#required' => TRUE,
  );

  $form['Submit'] = array(
    '#type' => 'submit',
    '#value' => 'Save Templates',
  );

  return $form;
}

/**
 * Save Janssen HCP Profile Email Configuration form.
 */
function jnj_veeva_hcp_profile_email_templates_form_submit($form, $form_state) {

  form_state_values_clean($form_state);
  unset($form_state['values']['vertical_tabs']);
  variable_set('jnj_veeva_hcp_profile_email_templates', drupal_json_encode($form_state['values']));
  drupal_set_message(t("Email templates saved successfully"));
}

/**
 * Profile success templates.
 */
function jnj_hcp_profile_success_templates_form($form, $form_state) {

  if (!empty($form_state['input'])) {
    $hcp_success_templates = $form_state['input'];
  }
  else {
    $hcp_success_templates = drupal_json_decode(variable_get('hcp_register_messages'));
  }

  $form['#tree'] = TRUE;

  $form['hcp_success_templates'] = array(
    '#type' => 'item',
    '#title' => t('HCP Success Page Templates'),
  );

  $form['vertical_tabs'] = array(
    '#type' => 'vertical_tabs',
  );

  $form['hcp_success_forgot_password'] = array(
    '#type' => 'fieldset',
    '#title' => t('Forgot Password Success'),
    '#description' => t('Forgot Password Success Page'),
    '#group' => 'vertical_tabs',
  );
  $form['hcp_success_forgot_password']['title'] = array(
    '#type' => 'textfield',
    '#title' => t('Title'),
    '#default_value' => isset($hcp_success_templates['hcp_success_forgot_password']['title']) ? $hcp_success_templates['hcp_success_forgot_password']['title'] : NULL,
    '#maxlength' => 180,
    '#required' => TRUE,
  );
  $form['hcp_success_forgot_password']['body'] = array(
    '#type' => 'textarea',
    '#title' => t('Body'),
    '#default_value' => isset($hcp_success_templates['hcp_success_forgot_password']['body']) ? $hcp_success_templates['hcp_success_forgot_password']['body'] : NULL,
    '#required' => TRUE,
  );
  $form['hcp_success_reset_password'] = array(
    '#type' => 'fieldset',
    '#title' => t('Reset Password Success'),
    '#description' => t('Reset Password Success Page'),
    '#group' => 'vertical_tabs',
  );
  $form['hcp_success_reset_password']['title'] = array(
    '#type' => 'textfield',
    '#title' => t('Title'),
    '#default_value' => isset($hcp_success_templates['hcp_success_reset_password']['title']) ? $hcp_success_templates['hcp_success_reset_password']['title'] : NULL,
    '#maxlength' => 180,
    '#required' => TRUE,
  );
  $form['hcp_success_reset_password']['body'] = array(
    '#type' => 'textarea',
    '#title' => t('Body'),
    '#default_value' => isset($hcp_success_templates['hcp_success_reset_password']['body']) ? $hcp_success_templates['hcp_success_reset_password']['body'] : NULL,
    '#required' => TRUE,
  );

  $form['Submit'] = array(
    '#type' => 'submit',
    '#value' => 'Save Templates',
  );

  return $form;
}

/**
 * Profile success template form submit.
 */
function jnj_hcp_profile_success_templates_form_submit($form, $form_state) {
  form_state_values_clean($form_state);
  unset($form_state['values']['vertical_tabs']);
  variable_set('hcp_register_messages', drupal_json_encode($form_state['values']));
  drupal_set_messaget(("Data saved successfully"));
}

/**
 * Function to store/update the picklist value in database.
 */
function jnj_veeva_hcp_profile_update_picklist() {
  $hcp_profile = new HcpProfile();
  $picklist_data = $hcp_profile->getPicklistValues();

  if ($picklist_data != 'error' && $picklist_data != '') {
    variable_set('janssen_hcp_registration_picklist', $picklist_data);
    drupal_set_message(t('Picklist Updated Successfully.'));
  }
  else {
    drupal_set_message(t('Picklist not updated.Please try again'), 'error');
  }
}

/**
 * Function to map the details .
 */
function janssen_redirect_url_settings() {
  global $base_path;
  $redirect_list = variable_get('janssenpro_redirect_info', '');
  foreach ($redirect_list as $key => $url_info) {
    $redirect_list[$key]['action'] = "<a href='" . $base_path . "admin/config/jnj-custom/settings/redirect-url/" . $url_info['name'] . "/edit'>Edit</a> | <a href='" . $base_path . "admin/config/jnj-custom/settings/redirect-url/" . $url_info['name'] . "/delete'>Delete</a>";
    if ($url_info['name'] == arg(5)) {
      $editing_url = $url_info;
    }
  }
  $form = array();
  $form['name'] = array(
    '#type' => 'textfield',
    '#title' => t('Redirect Name'),
    '#required' => TRUE,
    '#default_value' => (isset($editing_url['name']) ? $editing_url['name'] : ''),
  );
  $form['redirect_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Redirect URL'),
    '#required' => TRUE,
    '#default_value' => (isset($editing_url['redirect_url']) ? $editing_url['redirect_url'] : ''),
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => (arg(6) == 'edit' ? 'Update' : (arg(6) == 'delete' ? 'Delete' : 'Submit')),
  );
  $variables['header'] = array('Resource name', 'Redirect URL', 'action');
  $variables['rows'] = $redirect_list;
  $variables['attributes'] = array();
  $variables['sticky'] = FALSE;
  $redirect_details = theme_table($variables);
  $form['information'] = array(
    '#type' => 'markup',
    '#markup' => $redirect_details,
  );
  return $form;
}

/**
 * Redirect URL settings.
 */
function janssen_redirect_url_settings_submit($form, &$form_state) {
  $redirect_list = variable_get('janssenpro_redirect_info', '');
  $info['name'] = $form_state['values']['name'];
  $info['redirect_url'] = $form_state['values']['redirect_url'];
  if (arg(5) != '' || arg(6) != '') {
    foreach ($redirect_list as $key => $url_info) {
      if ($url_info['name'] == arg(5)) {
        if (arg(6) == 'delete') {
          unset($redirect_list[$key]);
        }
        else {
          $redirect_list[$key] = $info;
        }
      }
    }
  }
  else {
    foreach ($redirect_list as $key => $url_info) {
      if ($key == $info['name']) {
        form_set_error('name', t('The name entered is already exist. Please edit the name or enter different name'));
      }
    }
    $redirect_list[] = $info;
  }
  variable_set('janssenpro_redirect_info', $redirect_list);
  drupal_set_message(t('The changes are been saved successfully'));
  menu_rebuild();
  drupal_goto('admin/config/jnj-custom/settings/redirect-url');
}

/**
 * Redirect URL.
 */
function janssen_redirect_url() {
  if (user_is_anonymous()) {
    $_SESSION['userdestination'] = arg(0);
    $options['query'] = drupal_get_query_parameters();
    drupal_goto('', $options);
  }
  $redirect_list = variable_get('janssenpro_redirect_info', '');
  if (arg(0) != '') {
    foreach ($redirect_list as $url_info) {
      if ($url_info['name'] == arg(0)) {
        drupal_goto($url_info['redirect_url']);
      }
    }
  }
}
