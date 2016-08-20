<?php

/**
 * @file
 * Event detail template.
 */
?>
<style>
#edit-event-details span {
    display: inline-block;
    margin-left: 10px;
    vertical-align: top;
}
</style>
<div id="event-confirmation-form">
<div class="inner_wrap" style="display: block;">
<div id="edit-event-details" class="form-item form-type-item">
<h3><?php print t('Event Name'); ?></h3>
<p style="display: block;"><?php print $data['eventName']; ?></p>
<h3><?php print t('Event Date'); ?></h3>
<p style="display: block;"><?php print $data['formatEventDate']; ?></p>
<h3><?php print t('Event Time'); ?></h3>
<p style="display: block;"><?php print $data['formatEventTime']; ?></p>
<h3><?php print t('Venue'); ?></h3>
<p style="display: block;"><?php print $data['venueName']; ?>, <?php print $data['venueStreet1']; ?>, <?php print $data['venueSuburb']; ?>, <?php print $data['venueState']; ?> <?php print $data['venuePostCode']; ?> </p>
<h3><?php print t('Speakers'); ?></h3>
<ul>
<?php foreach ($data['speaker'] as $speaker): ?>
<li><?php print $speaker; ?></li>
<?php endforeach;?>
</ul>
<h3><?php print t('Event Hosts'); ?></h3>
<?php for($i = 1; $i <= 3; $i++): ?>
    <p style="display: block;">
        <?php if(isset($data['rsvpInfo']['rsvp' . $i . 'Image'])):?><span><?php print $data['rsvpInfo']['rsvp' . $i . 'Image']; ?></span><?php
        endif;?>
        <span>
          <?php if(isset($data['rsvpInfo']['rsvp' . $i . 'Name'])):?>
            <?php print $data['rsvpInfo']['rsvp' . $i . 'Name']; ?><br>
          <?php endif;?>
          <?php if(isset($data['rsvpInfo']['rsvp' . $i . 'Title'])):?>
            <?php print $data['rsvpInfo']['rsvp' . $i . 'Title']; ?><br>
          <?php endif;?>
          <?php if(isset($data['rsvpInfo']['rsvp' . $i . 'Email'])):?>
          <a href="mailto:<?php print $data['rsvpInfo']['rsvp' . $i . 'Email']; ?>"><?php print $data['rsvpInfo']['rsvp' . $i . 'Email']; ?></a><br>
          <?php endif;?>
          <?php if(isset($data['rsvpInfo']['rsvp' . $i . 'Mobile'])):?>
            <?php print $data['rsvpInfo']['rsvp' . $i . 'Mobile']; ?>
          <?php endif;?>
        </span>
    </p>
<?php endfor;?>
<p>
<iframe
    width="650"
    height="300"
    frameborder="0" style="border:0"
    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDgkBnnXnbSOr_s-CjM9PSbxdji8BXpJC4
      &q=<?php print $data['formatMapAddress']; ?>
      &attribution_source=Google+Maps+Embed+API">
  </iframe>
</p>
<h3><?php print t('Your RSVP'); ?></h3>
<div id="rsvp-status">
<?php if(strtotime($data['eventDate']) > strtotime("today")): ?>
    <?php if($data['eventStatus'] == RsvpStatus::KEYWORD_INVITED): ?>
      <a href="/event-rsvp/nojs/<?php print $data['eventID']; ?>/1" class="ctools-use-modal">Yes</a>
      <a href="/event-rsvp/nojs/<?php print $data['eventID']; ?>/2" class="use-ajax">No</a>
      <a href="/event-rsvp/nojs/<?php print $data['eventID']; ?>/3" class="ctools-use-modal">Maybe</a>
     <?php else: ?>
         <?php if($data['eventStatus'] == RsvpStatus::KEYWORD_DECLINED): ?>
             You are currently <b>not attending</b> this event </br> If you would like to attend this event, <a href="/event-rsvp/nojs/<?php print $data['eventID']; ?>/1" class="ctools-use-modal">you can submit an RSVP here.</a>
         <?php elseif($data['eventStatus'] == RsvpStatus::KEYWORD_TENTATIVE): ?>
             You are tentatively <b>attending</b> this event </br> If you can no longer attend this event, <a href="/event-rsvp/nojs/<?php print $data['eventID']; ?>/2" class="use-ajax">you can cancel your attendance.</a>
         <?php elseif($data['eventStatus'] == RsvpStatus::KEYWORD_ACCEPTED): ?>
             You are currently <b>attending</b> this event </br> If you can no longer attend this event, <a href="/event-rsvp/nojs/<?php print $data['eventID']; ?>/2" class="use-ajax">you can cancel your attendance.</a>
         <?php endif; ?>
     <?php endif; ?>
<?php else: ?>
    <?php print $data['eventStatus']; ?>
<?php endif; ?>
</div>

</div>	
</div>
</div>
