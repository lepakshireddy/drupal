<?php

/**
 * @file
 * Event API Make all service request.
 */

/**
 * Base class for all event service.
 */
class ServiceStatusCodes {

  const PROFILE_CREATED_SUCCESS = "STS-RGN-101";
  const INVALID_REGISTRATION_CODE = "STS-RGN-102";
  const PROFILE_ALREADY_EXIST_SAME_SECURITY = "STS-RGN-103";
  const PROFILE_ALREADY_EXIST_DIFF_SECURITY = "STS-RGN-104";
  const PROFILE_ALREADY_EXIST_IN_PROGRESS = "STS-RGN-105";
  const AUTO_VERIFICATION_SUCCESS = "STS-AVN-101";
  const AUTO_VERIFICATION_FAIL = "STS-AVN-102";
  const INVALID_EMAIL_LOGIN = "STS-LGN-101";
  const EMAIL_EXIST_DIFF_SECURITY = "STS-LGN-102";
  const SUCCESSFULL_LOGIN = "STS-LGN-103";
  const SUCCESS_USER_LOG = "STS-LGN-104";
  const SECURITY_QUES_DOESNT_MATCH = "STS-FEL-101";
  const SECURITY_QUES_MATCH = "STS-FEL-102";
  const FORGOT_PWD_INVALID_EMAIL = "STS-FPD-101";
  const FORGOT_PWD_VALID_EMAIL = "STS-FPD-102";
  const EMAIL_VERCODE_NOT_VALID = "STS-RPD-101";
  const EMAIL_VERCODE_VALID = "STS-RPD-102";
  const PASSWORD_UPDATE_SUCCESS = "STS-RPD-103";
  const SUCCESS_UPDATE_PROFILE = "STS-UHP-101";

}