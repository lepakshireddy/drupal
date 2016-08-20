<?php

/**
 * @file
 * Event list.
 */
global $theme;
$jnj_veeva_ribo_events_settings = drupal_json_decode(variable_get('jnj_veeva_ribo_events_settings'));
$ribo_details = $jnj_veeva_ribo_events_settings['ribo_events_settings'];
$ribo_parking_instruction = $ribo_details['ribo_parking_instruction'];
if (!isset($data['statusCode'])) {
  unset($_SESSION['ribo-event-details']);
  $_SESSION['ribo-event-details'] = $data;
}
$stringmel = "Melbourne";
$stringweb = "Webinar";
?>
<div class = "events event event-ribo">
    <header class="tall" style="background-image:url(<?php print '/' . drupal_get_path('theme', $theme) ?>/images/Ribomustin-Dreyling-Web-Banner-event-detail.jpg);">
        <h1><?php print $data['eventName']; ?></h1>
    </header>
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
  $maybe_href = '/ribo-event-rsvp/nojs/' . $data['eventID'] . '/3';
  $cancel_selectd = ($data['eventStatus'] == RsvpStatus::KEYWORD_DECLINED ? 'selected' : '');
  $cancel_href = '/ribo-event-rsvp/nojs/' . $data['eventID'] . '/2';
  ?>
                  <div class="event-actions">
                      <a href="#" class="btn join <?php print $accept_selectd_class; ?>" data-selected="<?php print $accept_selectd; ?>"><?php print t('Join'); ?></a>
                      <a href="<?php print $maybe_href; ?>" class="btn no maybe use-ajax <?php print $maybe_selectd; ?>" data-selected="<?php print $maybe_selectd; ?>"><?php print t('Maybe'); ?></a>
                      <a href="<?php print $cancel_href; ?>" class="btn no decline use-ajax <?php print $cancel_selectd; ?>" data-selected="<?php print $cancel_selectd; ?>"><?php print t('Decline'); ?></a>
                  </div>
                  <div class="confirmation" id="rsvp-ribo-status"></div>
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
<?php if (isset($data['speaker']['speakerName1'])): ?>
                      <li>
                          <div class="contact-details">
                              <h4><?php print $data['speaker']['speakerName1']; ?></h4>
                              <p class="title"><?php if (isset($data['speaker']['speakerCredential1'])): ?><?php print $data['speaker']['speakerCredential1']; ?>
                             <?php endif; ?></p>
                          </div>
                          <p><?php if (isset($data['speaker']['speakerBio1'])): ?><?php print $data['speaker']['speakerBio1']; ?>
                         <?php endif; ?></p>
                      </li>
<?php endif; ?>
                    <?php if (isset($data['speaker']['speakerName2'])): ?>
                      <li>
                          <div class="contact-details">
                              <h4><?php print $data['speaker']['speakerName2']; ?></h4>
                              <p class="title"><?php if (isset($data['speaker']['speakerCredential2'])): ?><?php print $data['speaker']['speakerCredential2']; ?>
                             <?php endif; ?></p>
                          </div>
                          <p><?php if (isset($data['speaker']['speakerBio2'])): ?><?php print $data['speaker']['speakerBio2']; ?>
                         <?php endif; ?></p>
                      </li>
                    <?php endif; ?>
                    <?php if (isset($data['speaker']['speakerName3'])): ?>
                      <li>
                          <div class="contact-details">
                              <h4><?php print $data['speaker']['speakerName3']; ?></h4>
                              <p class="title"><?php if (isset($data['speaker']['speakerCredential3'])): ?><?php print $data['speaker']['speakerCredential3']; ?>
                             <?php endif; ?></p>
                          </div>
                          <p><?php if (isset($data['speaker']['speakerBio3'])): ?><?php print $data['speaker']['speakerBio3']; ?>
                         <?php endif; ?></p>
                      </li>
                    <?php endif; ?>
                </ul>
            </div>
<?php
if (substr($data['eventName'], strlen($data['eventName']) - 1) === substr($stringmel, strlen($stringmel) - 1)) {
  ?>
              <h3 class="blue"><?php print t('Parking Instructions'); ?></h3>
              <div class="hosts">
  <?php print $ribo_parking_instruction; ?>
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
<?php } ?>
        </div>

        <div class="col">
            <h3 class="blue"><?php print t('Event details'); ?></h3>
            <div class="details">
                <p class="time"><?php print $data['formatEventTime']; ?>, <?php print $data['formatEventDate']; ?></p>
<?php
if (!(substr($data['eventName'], strlen($data['eventName']) - 1) === substr($stringweb, strlen($stringweb) - 1))) {
  ?>
                  <p class="location"><?php print $data['venueName']; ?>, <?php print $data['venueStreet1']; ?>, <?php print $data['venueSuburb']; ?>, <?php print $data['venueState']; ?> <?php print $data['venuePostCode']; ?></p>

                  <div id="map-canvas" class="google-map"><iframe
                          width="100%"
                          height="100%"
                          frameborder="0" style="border:0"
                          src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDgkBnnXnbSOr_s-CjM9PSbxdji8BXpJC4
                          &q=<?php print urlencode($data['formatMapAddress']); ?>
                          &attribution_source=Google+Maps+Embed+API">
                      </iframe></div>
<?php } ?>
            </div>


        </div>

    </section>

</div>
