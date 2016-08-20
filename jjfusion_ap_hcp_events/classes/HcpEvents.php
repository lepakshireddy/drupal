<?php

/**
 * @file
 * Hcp Events Make all service request.
 */

/**
 * Hcp Events.
 */
class HcpEvents {

  /**
   * HCPEvents.
   */
  private function serviceRequest($url, $params = array(), $method = 'GET', $response_type = 'json') {

    $jc_ap_hcp_events_settings = drupal_json_decode(variable_get('jc_ap_hcp_events_settings', ''));

    $serviceurl = $jc_ap_hcp_events_settings['service_url'] . '/' . $url;
    $params['countryCode'] = 'ANZ';
    if ($jc_ap_hcp_events_settings['iconnect_country_code'] != '') {
      $params['countryCode'] = $jc_ap_hcp_events_settings['iconnect_country_code'];
    }

    $service_response = '';
    // p(drupal_json_encode($params));
    $headers = array('Content-Type' => 'application/json');
    $starttime = time();
    $serviceResponse = drupal_http_request($serviceurl, array(
      'headers' => $headers,
      'method' => $method,
      'data' => drupal_json_encode($params),
    )
    );
    $endtime = time();
    $message = ($endtime - $starttime) . "avg time with starttime" . $starttime . "== endtime" . $endtime . "of the service: " . $url;
    watchdog('service-' . $url, $message);
    // echo"<pre>";print_r($serviceResponse);exit;
    if ($serviceResponse && $serviceResponse->code == 200) {
      $service_response = $serviceResponse->data;
    }

    if (!$service_response) {
      return 'error';
    }
    return $service_response;
  }

  /**
   * To get all the event list.
   *
   * @param array $params
   *   Parameters.
   *
   * @return array
   *   return.
   */
  public function getEventList($params) {

    try {

      $serviceRequest = $this->serviceRequest(EventAPIService::SERVICE_EVENT_LIST, $params, 'POST');
      $responseData = drupal_json_decode($serviceRequest);
      return $responseData;
    }
    catch (Exception $e) {

    }
  }

  /**
   * To get all the event list.
   *
   * @param array $params
   *   Parameters.
   *
   * @return array
   *   return.
   */
  public function getEventDetail($params) {

    try {

      $serviceRequest = $this->serviceRequest(EventAPIService::SERVICE_EVENT_DETAIL, $params, 'POST');
      $responseData = drupal_json_decode($serviceRequest);
      return $responseData;
    }
    catch (Exception $e) {

    }
  }

  /**
   * To get all the event list.
   *
   * @param array $params
   *   Parameters.
   *
   * @return array
   *   return.
   */
  public function registerEvent($params) {

    try {

      $serviceRequest = $this->serviceRequest(EventAPIService::SERVICE_EVENT_REGISTER, $params, 'POST');
      $responseData = drupal_json_decode($serviceRequest);
      return $responseData;
    }
    catch (Exception $e) {

    }
  }

  /**
   * To get all the event list.
   *
   * @param array $params
   *   Parameters.
   *
   * @return array
   *   return.
   */
  public function getSurvey($params) {

    try {

      $serviceRequest = $this->serviceRequest(EventAPIService::SERVICE_EVENT_GET_SERVEY . '/' . arg(1), $params, 'GET');
      $responseData = drupal_json_decode($serviceRequest);
      return $responseData;
    }
    catch (Exception $e) {

    }
  }

  /**
   * To get all the event list.
   *
   * @param array $params
   *   Parameters.
   *
   * @return array
   *   Return.
   */
  public function saveSurvey($params) {

    try {

      $serviceRequest = $this->serviceRequest(EventAPIService::SERVICE_EVENT_SAVE_SERVEY, $params, 'POST');
      $responseData = drupal_json_decode($serviceRequest);
      // p($responseData);
      return $responseData;
    }
    catch (Exception $e) {

    }
  }

  /**
   * Service to fetch picklist values from veeva.
   *
   * @return JsonSerializable
   *   Return.
   */
  public function getTransparencyReportList($params) {

    try {
      $response = $this->serviceRequest(EventAPIService::SERVICE_TRANSPARENCY_REPORT, $params, 'POST');

      if ($response != 'error') {
        $responseData = drupal_json_decode($response);
        return $responseData;
      }
    }
    catch (Exception $e) {

    }
  }

  /**
   * Service to fetch picklist values from veeva.
   *
   * @return JsonSerializable
   *   Return.
   */
  public function getTransparencyReportListAdmin($params) {

    try {
      set_time_limit(0);
      $response = $this->serviceRequest(EventAPIService::SERVICE_TRANSPARENCY_REPORT_ADMIN, $params, 'POST');
      // p($response);
      if ($response != 'error') {
        // p($responseData);
        $responseData = drupal_json_decode($response);
        return $responseData;
      }
    }
    catch (Exception $e) {

    }
  }

  /**
   * Service to fetch picklist values from veeva.
   *
   * @return JsonSerializable
   *   Return.
   */
  public function submitTransparencyReport($params) {

    try {
      $response = $this->serviceRequest(EventAPIService::SERVICE_TRANSPARENCY_REPORT_SUBMIT, $params, 'POST');
      if ($response != 'error') {
        $responseData = drupal_json_decode($response);
        return $responseData;
      }
    }
    catch (Exception $e) {

    }
  }

}
