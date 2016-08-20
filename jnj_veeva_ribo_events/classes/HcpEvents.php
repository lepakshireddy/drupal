<?php

/**
 * @file
 * Event API Make all service request.
 */

/**
 * Hcp Events make all service requests.
 */
class HcpEvents {

  /**
   * Service request.
   */
  private function serviceRequest($url, $params = array(), $method = 'GET', $response_type = 'json') {

    $jnj_veeva_ribo_events_settings = drupal_json_decode(variable_get('jnj_veeva_ribo_events_settings', ''));

    $serviceurl = $jnj_veeva_ribo_events_settings['service_url'] . '/' . $url;
    $params['countryCode'] = 'ANZ';
    if ($jnj_veeva_ribo_events_settings['iconnect_country_code'] != '') {
      $params['countryCode'] = $jnj_veeva_ribo_events_settings['iconnect_country_code'];
    }

    $service_response = '';
    $headers = array('Content-Type' => 'application/json');
    $serviceResponse = drupal_http_request($serviceurl, array(
      'headers' => $headers,
      'method' => $method,
      'data' => drupal_json_encode($params),
    )
    );
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
   * To register the event.
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
   * To register the event.
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
   * To register the event.
   */
  public function saveSurvey($params) {

    try {

      $serviceRequest = $this->serviceRequest(EventAPIService::SERVICE_EVENT_SAVE_SERVEY, $params, 'POST');
      $responseData = drupal_json_decode($serviceRequest);
      return $responseData;
    }
    catch (Exception $e) {
    }
  }

  /**
   * Service to fetch picklist values from veeva.
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
   */
  public function getTransparencyReportListAdmin($params) {

    try {
      $response = $this->serviceRequest(EventAPIService::SERVICE_TRANSPARENCY_REPORT_ADMIN, $params, 'POST');

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
