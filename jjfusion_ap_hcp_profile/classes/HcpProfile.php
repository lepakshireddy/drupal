<?php

/**
 * @file
 * Hcp Profile Make all service request.
 */

/**
 * Services call for all profile module.
 */
class HcpProfile {

  /**
   * Service request call.
   */
  private function serviceRequest($url, $params = array(), $method = 'GET', $response_type = 'json') {

    $jnj_veeva_hcp_profile_settings = drupal_json_decode(variable_get('jnj_veeva_hcp_profile_settings', ''));

    $serviceurl = $jnj_veeva_hcp_profile_settings['service_url'];
    $params['countryCode'] = 'ANZ';
    if ($jnj_veeva_hcp_profile_settings['iconnect_country_code'] != '') {
      $params['countryCode'] = $jnj_veeva_hcp_profile_settings['iconnect_country_code'];
    }
    if ($url == 'getPicklistValues' && $jnj_veeva_hcp_profile_settings['iconnect_country_specific_enabled']) {
      $url = $url . $params['countryCode'];
    }

    $service_response = '';
    $headers = array('Content-Type' => 'application/json');
    // p(drupal_json_encode($params));exit;
    $starttime = time();
    $serviceResponse = drupal_http_request($serviceurl . '/' . $url, array(
      'headers' => $headers,
      'method' => $method,
      'data' => drupal_json_encode($params),
    )
    );
    $endtime = time();
    $message = ($endtime - $starttime) . "avg time with starttime" . $starttime . "== endtime" . $endtime . "of the service: " . $url;
    watchdog('service-' . $url, $message);
    if ($serviceResponse && $serviceResponse->code == 200) {
      $service_response = $serviceResponse->data;
    }
    if (!$service_response) {
      return 'error';
    }
    return $service_response;
  }

  /**
   * User authentication service.
   */
  public function userAuthentication($email, $password) {
    $params = array(
      'email' => $email,
      'portal' => SERVICE_PORTAL_URL,
      'password' => $password,
      'ipAddress' => ip_address(),
    );
    $response = $this->serviceRequest(ServiceUrl::SERVICE_AUTH_HCP_USER, $params, 'POST');

    $jnj_veeva_hcp_profile_messages = drupal_json_decode(variable_get('jnj_veeva_hcp_profile_messages', array()));
    if ($response != 'error') {

      $response_decoded = drupal_json_decode($response);
      if ($response_decoded['statusCode'] == ServiceStatusCodes::SUCCESSFULL_LOGIN) {
        return array('status' => TRUE, 'userData' => $response_decoded);
      }
      elseif ($response_decoded['statusCode'] == ServiceStatusCodes::EMAIL_EXIST_DIFF_SECURITY) {
        form_set_error('name', $jnj_veeva_hcp_profile_messages['invalid_login_email_exist_diff_security']);
        return FALSE;
      }
      elseif ($response_decoded['statusCode'] == ServiceStatusCodes::AUTHENTICATION_FAILED) {
        form_set_error('name', $jnj_veeva_hcp_profile_messages['invalid_login_email_not_exist']);
      }
    }
    form_set_error('name', $jnj_veeva_hcp_profile_messages['invalid_login_email_not_exist']);
    return FALSE;
  }

  /**
   * To create new user profile in Veeva.
   *
   * @param array $params
   *   Input elements for service.
   *
   * @return array
   *   Json Data.
   */
  public function createProfile($params = array()) {

    try {
      $params['ipAddress'] = ip_address();
      $serviceRequest = $this->serviceRequest(ServiceUrl::SERVICE_CREATE_PROFILE, $params, 'POST');
      $responseData = drupal_json_decode($serviceRequest);
      return $responseData;
    }
    catch (Exception $e) {
      return $e;
    }
  }

  /**
   * To check auto verification.
   *
   * @param array $params
   *   Input elements.
   *
   * @return mixed
   *   Json Data.
   */
  public function autoVerificationRegistration($params) {

    $serviceRequest = $this->serviceRequest(ServiceUrl::SERVICE_AUTO_VERIFICATION, $params, 'POST');
    $responseData = drupal_json_decode($serviceRequest);
    return $responseData;
  }

  /**
   * Service for check email/security Q's for forgot password/email.
   *
   * @param array $params
   *   Input elements.
   *
   * @return mixed
   *   Json Data.
   */
  public function forgotPassword($params) {

    $serviceRequest = $this->serviceRequest(ServiceUrl::SERVICE_FORGOT_PWD_EMAIL, $params, 'POST');
    $responseData = drupal_json_decode($serviceRequest);

    return $responseData;
  }

  /**
   * Service for reset the password.
   *
   * @param array $params
   *   Input elements.
   *
   * @return mixed
   *   Json Data.
   */
  public function resetPassword($params) {

    $serviceRequest = $this->serviceRequest(ServiceUrl::SERVICE_RESET_PASSWORD, $params, 'POST');
    $responseData = drupal_json_decode($serviceRequest);

    return $responseData;
  }

  /**
   * Service to fetch picklist values from veeva.
   *
   * @return JsonSerializable
   *   Json Data.
   */
  public function getPicklistValues() {

    try {
      $response = $this->serviceRequest(ServiceUrl::SERVICE_PICKLIST);
      if ($response != 'error') {
        return $response;
      }
    }
    catch (Exception $e) {

    }
  }

  /**
   * Get HCP Rep Lists.
   *
   * @return mixed
   *   Json Data.
   */
  public function getHcpRepList($params) {

    try {

      $serviceRequest = $this->serviceRequest(ServiceUrl::SERVICE_MY_REP, $params, 'POST');
      $responseData = drupal_json_decode($serviceRequest);

      return $responseData;
    }
    catch (Exception $e) {
    }
  }

  /**
   * Update profile service call.
   */
  public function updateHcpProfile($params) {
    try {

      $serviceRequest = $this->serviceRequest(ServiceUrl::SERVICE_UPDATE_PROFILE, $params, 'POST');
      $responseData = drupal_json_decode($serviceRequest);
      return $responseData;

    }
    catch (Exception $e) {
    }
  }

  /**
   * Browse as HCP service call.
   */
  public function browseAsHcp($params) {
    try {

      $serviceRequest = $this->serviceRequest(ServiceUrl::SERVICE_BROWSE_AS, $params, 'POST');
      $responseData = drupal_json_decode($serviceRequest);
      return $responseData;

    }
    catch (Exception $e) {
      return $e;
    }
  }

  /**
   * Get preference service.
   */
  public function getPreferences($params) {
    try {

      $serviceRequest = $this->serviceRequest(ServiceUrl::SERVICE_PREFERENCE_PAGE, $params, 'POST');
      $responseData = drupal_json_decode($serviceRequest);
      return $responseData;

    }
    catch (Exception $e) {
      return $e;
    }
  }

  /**
   * Save preferences.
   */
  public function savePreferences($params) {
    // echo"<pre>";print_r($params);exit;
    try {

      $serviceRequest = $this->serviceRequest(ServiceUrl::SERVICE_SAVE_PREFERENCES, $params, 'POST');
      $responseData = drupal_json_decode($serviceRequest);
      return $responseData;

    }
    catch (Exception $e) {
      return $e;
    }
  }

  /**
   * Email opt out service.
   */
  public function emailOptOut($params) {
    try {

      $serviceRequest = $this->serviceRequest(ServiceUrl::SERVICE_EMAIL_OPTOUT, $params, 'POST');
      $responseData = drupal_json_decode($serviceRequest);
      return $responseData;

    }
    catch (Exception $e) {
      return $e;
    }
  }

  /**
   * Generic service call.
   */
  public function janssenProCall($params, $serviceUrl, $method) {
    try {

      $serviceRequest = $this->serviceRequest($serviceUrl, $params, $method);
      $responseData = drupal_json_decode($serviceRequest);
      return $responseData;

    }
    catch (Exception $e) {
      return $e;
    }
  }

}
