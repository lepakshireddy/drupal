<?php

/**
 * @file
 * Admin settings for the ribo events module.
 */

/**
 * Display Janssen ribo events configuration form.
 */
function jnj_veeva_ribo_events_settings_form($form, $form_state) {

  if (!empty($form_state['input'])) {
    $jnj_veeva_ribo_events_settings = $form_state['input'];
  }
  else {
    $jnj_veeva_ribo_events_settings = drupal_json_decode(variable_get('jnj_veeva_ribo_events_settings'));
  }

  $email_details = $jnj_veeva_ribo_events_settings['rsvp_email'];
  $ribo_details = $jnj_veeva_ribo_events_settings['ribo_events_settings'];
  $email_rsvp_mail_to_host = $jnj_veeva_ribo_events_settings['rsvp_mail_to_host'];
  $form['service_url'] = array(
    '#title' => 'Service URL',
    '#type' => 'textfield',
    '#required' => TRUE,
    '#default_value' => $jnj_veeva_ribo_events_settings['service_url'],
  );
  $form['iconnect_country_code'] = array(
    '#title' => 'iConnect Country code',
    '#type' => 'textfield',
    '#default_value' => $jnj_veeva_ribo_events_settings['iconnect_country_code'],
  );
  $form['site_cc_email'] = array(
    '#type' => 'textfield',
    '#title' => t('CC email to the all emails'),
    '#default_value' => $jnj_veeva_ribo_events_settings['site_cc_email'],
    '#required' => FALSE,
  );
  $form['#tree'] = TRUE;
  $form['vertical_tabs'] = array(
    '#type' => 'vertical_tabs',
  );
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
  $form['ribo_events_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Ribo Events Settings'),
    '#group' => 'vertical_tabs',
  );
  $form['ribo_events_settings']['ribo_event_names'] = array(
    '#type' => 'textarea',
    '#title' => t('Event Names'),
    '#description' => t('Enter the ribo event name that to be displayed . Enter one per line.'),
    '#default_value' => $ribo_details['ribo_event_names'],
    '#rows' => 15,
    '#required' => TRUE,
  );
  $form['ribo_events_settings']['ribo_event_description'] = array(
    '#type' => 'textarea',
    '#title' => t('Event Description on event list page'),
    '#rows' => 15,
    '#default_value' => $ribo_details['ribo_event_description'],
    '#required' => TRUE,
  );

  $form['ribo_events_settings']['ribo_event_bannerhead'] = array(
    '#type' => 'textfield',
    '#title' => t('Main heading on banner in event list page'),
    '#maxlength' => 180,
    '#default_value' => $ribo_details['ribo_event_bannerhead'],
    '#required' => TRUE,
  );

  $form['ribo_events_settings']['ribo_event_subhead'] = array(
    '#type' => 'textfield',
    '#title' => t('Event list page sub heading'),
    '#maxlength' => 180,
    '#default_value' => $ribo_details['ribo_event_subhead'],
    '#required' => TRUE,
  );

  $form['ribo_events_settings']['ribo_parking_instruction'] = array(
    '#type' => 'textfield',
    '#title' => t('Event detail page parking instructions for Melbourne events'),
    '#maxlength' => 180,
    '#default_value' => $ribo_details['ribo_parking_instruction'],
    '#required' => TRUE,
  );

  $form['ribo_events_settings']['ribo_mail'] = array(
    '#type' => 'textfield',
    '#title' => t('Email ids for sending Ribo Event status'),
    '#default_value' => $ribo_details['ribo_mail'],
    '#maxlength' => 180,
    '#required' => FALSE,
  );

  $form['Submit'] = array(
    '#type' => 'submit',
    '#value' => 'Save Configuration',
  );
  return $form;
}

/**
 * Form submit call back for event settings.
 */
function jnj_veeva_ribo_events_settings_form_submit($form, $form_state) {
  form_state_values_clean($form_state);
  variable_set('jnj_veeva_ribo_events_settings', drupal_json_encode($form_state['values']));
  drupal_set_message(t("Settings saved successfully"));
}
