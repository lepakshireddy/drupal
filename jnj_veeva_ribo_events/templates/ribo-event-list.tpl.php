<?php

/**
 * @file
 * Event Details.
 */
global $theme;
$jnj_veeva_ribo_events_settings = drupal_json_decode(variable_get('jnj_veeva_ribo_events_settings'));
$ribo_details = $jnj_veeva_ribo_events_settings['ribo_events_settings'];
$ribo_event_desc = $ribo_details['ribo_event_description'];
$ribo_event_bannerhead = $ribo_details['ribo_event_bannerhead'];
$ribo_event_subhead = $ribo_details['ribo_event_subhead'];
?>
<div class = "events events-ribo">
    <header class="short" style="background-image:url(<?php print '/' . drupal_get_path('theme', $theme) ?>/images/Ribomustin-Dreyling-Web-Banner_event_list.jpg);height:350px;">
<?php print $ribo_event_bannerhead; ?>
    </header>
        <?php if (!empty($data)): ?>
      <?php if (!empty($data['futureEvents'])): ?>   
        <?php print $ribo_event_desc; ?>
        <?php print $ribo_event_subhead; ?>
        <section class="event-list three-columns">

    <?php foreach ($data['futureEvents'] as $event): ?>

              <article class="col">
                  <div class="heading">
                      <img src="<?php print jc_ap_hcp_events_images($event['eventID']); ?>" alt="">
                      <h3 class="blue"><?php print $event['eventName']; ?></h3>
                  </div>
                  <div class="content">
                      <p class="time"><?php print date("l d/m/Y", strtotime($event['eventDate'])); ?></p>
                      <p class="location"><?php print $event['venueName']; ?></p>
                      <a href="/ribo-event-detail/<?php print $event['eventID']; ?>" class="btn rsvp"><?php print t('Read more &amp; RSVP'); ?></a>
                  </div>
              </article>

    <?php endforeach; ?>
            <span class="more-events"><?php print t('More Janssen events will be announced shortly, check back soon.'); ?></span>
        </section>
      <?php endif; ?>

    <?php else: ?>
      <?php print $ribo_event_subhead; ?>
      <section class="event-list three-columns">
          <h4><?php print t('There are currently no events for you, check back soon.'); ?></h4>
      </section>

    <?php endif; ?>
</div>
