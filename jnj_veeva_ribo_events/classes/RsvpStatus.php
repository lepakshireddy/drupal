<?php

/**
 * @file
 * Event API Make all service request.
 */

/**
 * Base class for all event service.
 */
class RsvpStatus {

  const CODE_INVITED = 0;
  const CODE_ACCEPTED = 1;
  const CODE_DECLINED = 2;
  const CODE_TENTATIVE = 3;
  const KEYWORD_INVITED = "Invited";
  const KEYWORD_ACCEPTED = "Accepted";
  const KEYWORD_DECLINED = "Declined";
  const KEYWORD_TENTATIVE = "Tentative";

  /**
   * Get rsvp code.
   */
  public static function getRsvpStatusByCode($code) {

    switch ($code) {
      case RsvpStatus::CODE_INVITED:
        return RsvpStatus::KEYWORD_INVITED;

      case RsvpStatus::CODE_ACCEPTED:
        return RsvpStatus::KEYWORD_ACCEPTED;

      case RsvpStatus::CODE_DECLINED:
        return RsvpStatus::KEYWORD_DECLINED;

      case RsvpStatus::CODE_TENTATIVE:
        return RsvpStatus::KEYWORD_TENTATIVE;
    }
  }

}
