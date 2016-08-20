<?php

/**
 * @file
 * Templates.
 */
if (!isset($data['statusCode'])) {
  unset($_SESSION['event-details']);
  $_SESSION['event-details'] = $data;
}
/* $stringmel ="Melbourne"; */
$stringweb = "Webinar";
$_SESSION['speaker-tour-list-id'] = ($data['sp_arg'] ? $data['sp_arg'] : arg(2));
/* Parking Requirements */
$speakerListcontent = node_load($_SESSION['speaker-tour-list-id']);
foreach ($speakerListcontent->field_related_content[LANGUAGE_NONE] as $id) {
  $parkingListId[] = $id['target_id'];
}
$placeName = $data['eventName'];
$placeName = substr($placeName, strpos($placeName, "-") + 1);
$placeName = trim($placeName);
$parTa = taxonomy_get_term_by_name("Parking instructions");
$words_term = current($parTa);
$parTatid = $words_term->tid;
$parkingData = array();
$relatedParkingID = array();
foreach ($parkingListId as $key) {
  $parkingData[$key] = node_load($key);
  foreach ($parkingData[$key]->field_general_tags[LANGUAGE_NONE] as $val) {
    if ($val['tid'] == $parTatid) {
      $relatedParkingID[] = $key;
    }
  }
}
foreach ($relatedParkingID as $value) {
  foreach ($parkingData[$value]->field_general_tags[LANGUAGE_NONE] as $val) {
    $tName = taxonomy_term_load($val['tid']);
    $tagName = $tName->name;
    if (strtolower($placeName) == strtolower($tagName)) {
      $speakerevent_parking_instruction = $parkingData[$value]->body[LANGUAGE_NONE][0]['value'];
      $_SESSION['speaker-details'] = 1;
    }
  }
}
?>
<?php if (count(views_get_view_result('event_banner_images', 'block_1')) > 0) { ?>
  <div class="product-single">
      <header class="slider desktop">
          <h1 style="background:rgba(0, 0, 0, 0.3) none repeat scroll 0 0;border-top: 1px solid rgba(212, 212, 212, 0.4);padding: 25px; margin: 0;"><?php print $data['eventName']; ?></h1>
          <?php print views_embed_view('event_banner_images', 'block_1'); ?>
      </header>
  </div>
  <?php unset($_SESSION['speaker-tour-list-id']);
}
?>
<div class = "events event speaker-tour-event">
    <?php
    if (isset($_SESSION['event-image'][$data['eventID']])) {
      $eventImage = node_load($_SESSION['event-image'][$data['eventID']]);
    }
    else {
      $eventImage = node_load(jc_ap_hcp_event_detail_images());
    }
    ?>
    <section>
        <div class="header">
            <h2><?php print t('You have been invited to this event by Janssen'); ?></h2>
            <h3 class="blue"><?php print t('My RSVP'); ?></h3>
            <div class="actions">
                <?php
                if (strtotime($data['eventDate']) > strtotime("today")) {
                  $accept_selectd_class = ($data['eventStatus'] == RsvpStatus::KEYWORD_ACCEPTED ? 'join selected' : 'join');
                  $accept_selectd = ($data['eventStatus'] == RsvpStatus::KEYWORD_ACCEPTED ? 'selected' : '');
                  $maybe_selectd = ($data['eventStatus'] == RsvpStatus::KEYWORD_TENTATIVE ? 'selected' : '');
                  $maybe_href = '/event-rsvp/nojs/' . $data['eventID'] . '/3';
                  $cancel_selectd = ($data['eventStatus'] == RsvpStatus::KEYWORD_DECLINED ? 'selected' : '');
                  $cancel_href = '/event-rsvp/nojs/' . $data['eventID'] . '/2';
                  ?>
                  <div class="event-actions">
                      <a href="#" class="btn join <?php print $accept_selectd_class; ?>" data-selected="<?php print $accept_selectd; ?>"><?php print t('Join'); ?></a>
                      <a href="<?php print $maybe_href; ?>" class="btn no maybe use-ajax <?php print $maybe_selectd; ?>" data-selected="<?php print $maybe_selectd; ?>"><?php print t('Maybe'); ?></a>
                      <a href="<?php print $cancel_href; ?>" class="btn no decline use-ajax <?php print $cancel_selectd; ?>" data-selected="<?php print $cancel_selectd; ?>"><?php print t('Decline'); ?></a>
                  </div>
                  <div class="confirmation" id="rsvp-status"></div>
                  <?php
                }
                ?>
            </div>
            <div class="content">
                <p><?php print $data['eventDescription']; ?></p>
            </div>
        </div>
        <div class="col">
            <h3 class="blue"><?php print t('Key speakers'); ?></h3>
            <div class="speakers">
                <ul>
<?php if (isset($data['speaker']['speakerName1'])) { ?>
                      <li>
                          <div class="contact-details">
                              <h4><?php print $data['speaker']['speakerName1']; ?></h4>
                              <p class="title"><?php if (isset($data['speaker']['speakerCredential1'])) { ?>
                                    <?php
                                    print $data['speaker']['speakerCredential1'];
                             }
                                  ?>
                              </p>
                          </div>
                          <p><?php if (isset($data['speaker']['speakerBio1'])) { ?><?php
                                    print $data['speaker']['speakerBio1'];
                         }
                                  ?>
                          </p>
                      </li>
  <?php
}
?>
                                <?php if (isset($data['speaker']['speakerName2'])): ?>
                      <li>
                          <div class="contact-details">
                              <h4><?php print $data['speaker']['speakerName2']; ?></h4>
                              <p class="title"><?php if (isset($data['speaker']['speakerCredential2'])) { ?><?php
                                    print $data['speaker']['speakerCredential2'];
                             }
                                  ?>
                              </p>
                          </div>
                          <p><?php if (isset($data['speaker']['speakerBio2'])) { ?><?php print $data['speaker']['speakerBio2']; ?>
                         <?php } ?>
                          </p>
                      </li>
                                <?php endif; ?>
                                <?php if (isset($data['speaker']['speakerName3'])): ?>
                      <li>
                          <div class="contact-details">
                              <h4><?php print $data['speaker']['speakerName3']; ?></h4>
                              <p class="title"><?php if (isset($data['speaker']['speakerCredential3'])) { ?><?php print $data['speaker']['speakerCredential3']; ?>
                             <?php } ?>
                              </p>
                          </div>
                          <p><?php if (isset($data['speaker']['speakerBio3'])) { ?><?php print $data['speaker']['speakerBio3']; ?>
                         <?php } ?>
                          </p>
                      </li>
                                <?php endif; ?>
                </ul>
            </div>
            <?php if ($speakerevent_parking_instruction) { ?>
              <h3 class="blue"><?php print t('Parking Instructions'); ?></h3>
              <div class="hosts">
  <?php print $speakerevent_parking_instruction; ?>
              </div>
            <?php } ?>
                <?php if (count($data['agenda']) > 0) { ?>
              <h3 class="blue"><?php print t('Event Agenda'); ?></h3>
              <div class="information">
              <?php
              foreach ($data['agenda'] as $moreinfo) {
                print "<p>" . $moreinfo . "</p>";
              }
              ?>          
              </div>
  <?php
                }
?>
        </div>
        <div class="col">
            <h3 class="blue"><?php print t('Event details'); ?></h3>
            <div class="details">
                <p class="time"><?php print $data['formatEventTime']; ?>, <?php print $data['formatEventDate']; ?></p>
<?php if (!(substr($data['eventName'], strlen($data['eventName']) - 1) === substr($stringweb, strlen($stringweb) - 1))) { ?>
                  <p class="location"><?php print $data['venueName']; ?>, <?php print $data['venueStreet1']; ?>, <?php print $data['venueSuburb']; ?>, <?php print $data['venueState']; ?> <?php print $data['venuePostCode']; ?></p>
                  <div id="map-canvas" class="google-map"><iframe
                          width="100%"
                          height="100%"
                          frameborder="0" style="border:0"
                          src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDgkBnnXnbSOr_s-CjM9PSbxdji8BXpJC4
                          &q=<?php print urlencode($data['formatMapAddress']); ?>
                          &attribution_source=Google+Maps+Embed+API">
                      </iframe>
                  </div>
<?php } ?>
            </div></div>
    </section>
</div>
<?php unset($_SESSION['speaker-tour-list-id']); ?>
