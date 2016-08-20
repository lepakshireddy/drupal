<?php

/**
 * @file
 * Hcp Events Make all service request.
 */

/**
 * Define constants.
 */
class EventAPITrackService {

  const SERVICE_TRACK_EVENT_LIST = 'mCActivityBulkLoad';

  /**
   * To Track the event.
   *
   * @param array $params
   *   Service request params with accid.
   *
   * @return array
   *   JsonData.
   */
  public function trackGaEvent($params) {

    try {

      $serviceRequest = $this->serviceRequest(EventAPITrackService::SERVICE_TRACK_EVENT_LIST, $params, 'POST');
      $responseData = drupal_json_decode($serviceRequest);
      return $responseData;
    }
    catch (Exception $e) {
      return $e;
    }
  }

}

/**
 * Define class for track event service calls.
 */
class TrackEvents {

  /**
   * Service request for all track events services.
   */
  private function serviceRequest($url, $params = array(), $method = 'POST', $response_type = 'json') {

    $jnj_veeva_hcp_profile_settings = drupal_json_decode(variable_get('jnj_veeva_hcp_profile_settings', ''));

    $serviceurl = $jnj_veeva_hcp_profile_settings['service_url'] . '/' . $url;
    $params['countryCode'] = 'ANZ';
    if ($jnj_veeva_hcp_profile_settings['iconnect_country_code'] != '') {
      $params['countryCode'] = $jnj_veeva_hcp_profile_settings['iconnect_country_code'];
    }

    $service_response = '';
    $headers = array('Content-Type' => 'application/json');
    // p(drupal_json_encode($params));
    $serviceResponse = drupal_http_request($serviceurl, array(
      'headers' => $headers,
      'method' => $method,
      'data' => drupal_json_encode($params),
    )
    );
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
   * To Track the event.
   *
   * @param array $params
   *   Service request params with accid.
   *
   * @return array
   *   JsonData.
   */
  public function trackGaEvent($params) {

    try {

      $serviceRequest = $this->serviceRequest(EventAPITrackService::SERVICE_TRACK_EVENT_LIST, $params, 'POST');
      // p($serviceRequest);exit;
      $responseData = drupal_json_decode($serviceRequest);
      // p($responseData);exit;
      return $responseData;
    }
    catch (Exception $e) {
      return $e;
    }
  }

}
