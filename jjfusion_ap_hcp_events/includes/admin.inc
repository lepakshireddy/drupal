<?php

/**
 * @file
 * Settings form.
 */

/**
 * Settings form.
 */
function jc_ap_hcp_events_settings_form($form, $form_state) {

  if (!empty($form_state['input'])) {
    $jc_ap_hcp_events_settings = $form_state['input'];
  }
  else {
    $jc_ap_hcp_events_settings = drupal_json_decode(variable_get('jc_ap_hcp_events_settings'));
  }
  // ~ print_r($jc_ap_hcp_events_settings); exit;.
  $email_details = $jc_ap_hcp_events_settings['rsvp_email'];
  $email_details_past = $jc_ap_hcp_events_settings['past_event_mail'];
  $email_rsvp_mail_to_host = $jc_ap_hcp_events_settings['rsvp_mail_to_host'];
  $email_details_transparency = $jc_ap_hcp_events_settings['transparency_user_email'];

  // Echo $info_mail_send;.
  $form['service_url'] = array(
    '#title' => 'Service URL',
    '#type' => 'textfield',
    '#required' => TRUE,
    '#default_value' => $jc_ap_hcp_events_settings['service_url'],
  );
  $form['iconnect_country_code'] = array(
    '#title' => 'iConnect Country code',
    '#type' => 'textfield',
    '#default_value' => $jc_ap_hcp_events_settings['iconnect_country_code'],
  );
  $form['site_cc_email'] = array(
    '#type' => 'textfield',
    '#title' => t('CC email to the all emails'),
    '#default_value' => $jc_ap_hcp_events_settings['site_cc_email'],
    '#required' => FALSE,
  );
  $form['info_mail'] = array(
    '#type' => 'textfield',
    '#title' => t('Detils to be send  here'),
    '#default_value' => $jc_ap_hcp_events_settings['info_mail'],
    '#maxlength' => 180,
    '#required' => FALSE,
  );
  $form['transparency_to_email'] = array(
    '#type' => 'textfield',
    '#title' => t('Transparency to Email'),
    '#default_value' => $jc_ap_hcp_events_settings['transparency_to_email'],
    '#maxlength' => 180,
    '#required' => TRUE,
  );
  $form['trasparency_report_filter'] = array(
    '#title' => 'Transparency Report Filter',
    '#type' => 'textarea',
    '#description' => t('Each line is each filter option seperated as key and value with <b>"||"</b>. Ex: 2015-10-01/2016-04-30||1 OCT 2015 - 30 APR 2016 (please review by 3/8/16)'),
    '#default_value' => $jc_ap_hcp_events_settings['trasparency_report_filter'],
  );
  $form['#tree'] = TRUE;
  $form['vertical_tabs'] = array('#type' => 'vertical_tabs');
  $form['transparency_user_email'] = array(
    '#type' => 'fieldset',
    '#title' => t('Transparency user Email'),
    '#description' => t('Edit the  Transparency e-mail messages sent to user.'),
    '#group' => 'vertical_tabs',
  );

  $form['transparency_user_email']['subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Email Subject'),
    '#default_value' => $email_details_transparency['subject'],
    '#maxlength' => 180,
    '#required' => TRUE,
  );
  $form['transparency_user_email']['body'] = array(
    '#type' => 'textarea',
    '#title' => t('Email Body'),
    '#default_value' => $email_details_transparency['body'],
    '#rows' => 15,
    '#required' => TRUE,
  );
  $form['#tree'] = TRUE;
  $form['vertical_tabs'] = array('#type' => 'vertical_tabs');
  $form['rsvp_email'] = array(
    '#type' => 'fieldset',
    '#title' => t('RSVP Email'),
    '#description' => t('Edit the  Enquiry e-mail messages sent to user.'),
    '#group' => 'vertical_tabs',
  );

  $form['rsvp_email']['subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Email Subject'),
    '#default_value' => $email_details['subject'],
    '#maxlength' => 180,
    '#required' => TRUE,
  );
  $form['rsvp_email']['body'] = array(
    '#type' => 'textarea',
    '#title' => t('Email Body'),
    '#default_value' => $email_details['body'],
    '#rows' => 15,
    '#required' => TRUE,
  );
  $form['rsvp_mail_to_host'] = array(
    '#type' => 'fieldset',
    '#title' => t('RSVP mail to Event host'),
    '#description' => t('Email subject and body of the CC email to the event host'),
    '#group' => 'vertical_tabs',
  );

  $form['rsvp_mail_to_host']['subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Email Subject'),
    '#default_value' => $email_rsvp_mail_to_host['subject'],
    '#maxlength' => 180,
    '#required' => FALSE,
  );
  $form['rsvp_mail_to_host']['body'] = array(
    '#type' => 'textarea',
    '#title' => t('Email Body'),
    '#default_value' => $email_rsvp_mail_to_host['body'],
    '#rows' => 15,
    '#required' => FALSE,
  );

  $form['past_event_mail'] = array(
    '#type' => 'fieldset',
    '#title' => t('Past Events Email'),
    '#description' => t('Edit the  Enquiry e-mail messages sent to user.'),
    '#group' => 'vertical_tabs',
  );

  $form['past_event_mail']['subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Email Subject'),
    '#default_value' => $email_details_past['subject'],
    '#maxlength' => 180,
    '#required' => FALSE,
  );
  $form['past_event_mail']['body'] = array(
    '#type' => 'textarea',
    '#title' => t('Email Body'),
    '#default_value' => $email_details_past['body'],
    '#rows' => 15,
    '#required' => FALSE,
  );

  $form['past_event_mail']['thankyou_msg'] = array(
    '#type' => 'textarea',
    '#title' => t('thank you message after sending mail'),
    '#default_value' => $email_details_past['thankyou_msg'],
    '#rows' => 15,
    '#required' => FALSE,
  );

  $form['Submit'] = array(
    '#type' => 'submit',
    '#value' => 'Save Configuration',
  );
  return $form;
}

/**
 * Settings Form submit.
 */
function jc_ap_hcp_events_settings_form_submit($form, $form_state) {
  $_SESSION['past_event_setting'] = $form_state['values'];
  form_state_values_clean($form_state);
  variable_set('jc_ap_hcp_events_settings', drupal_json_encode($form_state['values']));
  drupal_set_message(t("Settings saved successfully"));
}
