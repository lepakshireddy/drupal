<?php

/**
 * @file
 * Templates.
 */

/**
 * Templates.
 */
if(!isset($data['statusCode'])) {
    unset($_SESSION['event-details']);
    $_SESSION['event-details'] = $data;
}
?>
<div class = "events event">
<?php
if(isset($_SESSION['event-image'][$data['eventID']])){
    $eventImage = node_load($_SESSION['event-image'][$data['eventID']]);
}else{
    $eventImage = node_load(jc_ap_hcp_event_detail_images());
}
?>
    <header class="tall event-detail-image" style="background-image:url(<?php print file_create_url($eventImage->field_gallery_images[LANGUAGE_NONE][1]['uri']) ?>)">
        <h1><?php print $data['eventName']; ?></h1>
    </header>
    <section>
        <div class="header">
            <h2><?php print t('You have been invited to this event by Janssen'); ?></h2>
            <h3 class="blue"><?php print t('My RSVP'); ?></h3>

            <div class="actions">
                <?php if (strtotime($data['eventDate']) > strtotime("today")) {
                  $accept_selectd_class = ($data['eventStatus'] == RsvpStatus::KEYWORD_ACCEPTED ? 'join selected' : 'join');
                  $accept_selectd = ($data['eventStatus'] == RsvpStatus::KEYWORD_ACCEPTED ? 'selected' : '');
                  $maybe_selectd = ($data['eventStatus'] == RsvpStatus::KEYWORD_TENTATIVE ? 'selected' : '');
                  $maybe_href = '/event-rsvp/nojs/' . $data['eventID'] . '/3';
                  $cancel_selectd = ($data['eventStatus'] == RsvpStatus::KEYWORD_DECLINED ? 'selected' : '');
                  $cancel_href = '/event-rsvp/nojs/' . $data['eventID'] . '/2';
                  ?>
                <div class="event-actions">
                    <a href="#" class="btn join <?php print $accept_selectd_class; ?>" data-selected="<?php print $accept_selectd; ?>"><?php print t('Join');?></a>
                    <a href="<?php print $maybe_href;?>" class="btn no maybe use-ajax <?php print $maybe_selectd; ?>" data-selected="<?php print $maybe_selectd; ?>"><?php print t('Maybe');?></a>
                    <a href="<?php print $cancel_href; ?>" class="btn no decline use-ajax <?php print $cancel_selectd; ?>" data-selected="<?php print $cancel_selectd; ?>"><?php print t('Decline'); ?></a>
                </div>
                    <div class="confirmation" id="rsvp-status"></div>
                    <?php
                }
                ?>
            </div>


            <div class="content">
                <p><?php print $data['eventDescription'];?></p>
            </div>
        </div>

        <div class="col">
            <h3 class="blue"><?php print t('Event hosts'); ?></h3>
            <div class="hosts">
                <ul>
                    <?php for ($i = 1; $i <= 3; $i++): ?>
                      <li>
                          <?php if(isset($data['rsvpInfo']['rsvp' . $i . 'Image']) && $data['rsvpInfo']['rsvp' . $i . 'Image'] != '') {?>
                          <img src="<?php print $data['rsvpInfo']['rsvp' . $i . 'Image']; ?>" alt="">
                          <?php }?>
                          <div class="contact-details">
                              <h4><?php if (isset($data['rsvpInfo']['rsvp' . $i . 'Name'])): ?>
                                    <?php print $data['rsvpInfo']['rsvp' . $i . 'Name']; ?>
                             <?php endif; ?></h4>
                              <p class="title">
                                  <?php if (isset($data['rsvpInfo']['rsvp' . $i . 'Title'])): ?>
                                    <?php print $data['rsvpInfo']['rsvp' . $i . 'Title']; ?>
                                  <?php endif; ?></p>
                              <p><a href="mailto:"><?php print $data['rsvpInfo']['rsvp' . $i . 'Email']; ?></a></p>
                              <p><a href="tel:">
                                      <?php if (isset($data['rsvpInfo']['rsvp' . $i . 'Mobile'])): ?>
                                        <?php print $data['rsvpInfo']['rsvp' . $i . 'Mobile']; ?>
                                      <?php endif; ?></a></p>
                          </div>
                      </li>
                    <?php endfor; ?>
                </ul>
            </div>

            <h3 class="blue"><?php print t('Key speakers'); ?></h3>
            <div class="speakers">
                <ul>
                    <?php if (isset($data['speaker']['speakerName1'])): ?>
                      <li>
                          <div class="contact-details">
                              <h4><?php print $data['speaker']['speakerName1']; ?></h4>
                              <p class="title"><?php if (isset($data['speaker']['speakerCredential1'])): ?><?php print $data['speaker']['speakerCredential1']; ?><?php
                             endif; ?></p>
                          </div>
                          <p><?php if (isset($data['speaker']['speakerBio1'])): ?><?php print $data['speaker']['speakerBio1']; ?><?php
                         endif; ?></p>
                      </li>
                    <?php endif; ?>
                    <?php if (isset($data['speaker']['speakerName2'])): ?>
                      <li>
                          <div class="contact-details">
                              <h4><?php print $data['speaker']['speakerName2']; ?></h4>
                              <p class="title"><?php if (isset($data['speaker']['speakerCredential2'])): ?><?php print $data['speaker']['speakerCredential2']; ?><?php
                             endif; ?></p>
                          </div>
                          <p><?php if (isset($data['speaker']['speakerBio2'])): ?><?php print $data['speaker']['speakerBio2']; ?><?php
                         endif; ?></p>
                      </li>
                    <?php endif; ?>
                    <?php if (isset($data['speaker']['speakerName3'])): ?>
                      <li>
                          <div class="contact-details">
                              <h4><?php print $data['speaker']['speakerName3']; ?></h4>
                              <p class="title"><?php if (isset($data['speaker']['speakerCredential3'])): ?><?php print $data['speaker']['speakerCredential3']; ?><?php
                             endif; ?></p>
                          </div>
                          <p><?php if (isset($data['speaker']['speakerBio3'])): ?><?php print $data['speaker']['speakerBio3']; ?><?php
                         endif; ?></p>
                      </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="col">
            <h3 class="blue"><?php print t('Event details');?></h3>
            <div class="details">
                <p class="time"><?php print $data['formatEventTime']; ?>, <?php print $data['formatEventDate']; ?></p>
                <p class="location"><?php print $data['venueName']; ?>, <?php print $data['venueStreet1']; ?>, <?php print $data['venueSuburb']; ?>, <?php print $data['venueState']; ?> <?php print $data['venuePostCode']; ?></p>

                <div id="map-canvas" class="google-map"><iframe
                        width="100%"
                        height="100%"
                        frameborder="0" style="border:0"
                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDgkBnnXnbSOr_s-CjM9PSbxdji8BXpJC4
                        &q=<?php print urlencode($data['formatMapAddress']); ?>
                        &attribution_source=Google+Maps+Embed+API">
                    </iframe></div>
            </div>
            <?php if(count($data['agenda']) > 0) {?>
            <h3 class="blue"><?php print t('Event Agenda');?></h3>
        <div class="information">
            <?php foreach($data['agenda'] as $moreinfo) {
              print "<p>" . $moreinfo . "</p>";
            } ?>          
        </div>
            <?php }?>
        </div>
    </section>
</div>
