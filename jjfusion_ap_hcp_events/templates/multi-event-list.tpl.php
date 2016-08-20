<?php

/**
 * @file
 * Templates.
 */
if(count($events) > 0){      ?>
<?php if(!empty($events['futureEvents'])): ?>
<section class="event-list three-columns">
<?php foreach($events['futureEvents'] as $event): ?>

    <article class="col" style=" padding-top: 35px;">
        <div class="heading">         
          <img class="" src="<?php print jc_ap_hcp_events_images($event['eventID']);?>" alt="">          
          <h3 class="blue"><?php print $event['eventName']; ?></h3>
        </div>
        <div class="content">
          <p class="time"><?php print date("l d/m/Y", strtotime($event['eventDate'])); ?></p>
          <p class="location"><?php print $event['venueName']; ?></p>
          <a href="/speaker-tour/<?php print $event['eventID']; ?>/<?php print $_SESSION['speaker-tour-list-id'];?>" class="btn rsvp"><?php print t('Read more &amp; RSVP');?></a>
        </div>
      </article>
    
<?php endforeach; ?>
<span class="more-events"><?php print t('More Janssen events will be announced shortly, check back soon.');?></span>
</section>
<?php endif; ?>
<!-- Check if past events has assets -->
<?php
    /*Get TID values of Taxonomy */
    $pastEventAsset = taxonomy_get_term_by_name("Show Assets");
    $pastEventAsset_term = current($pastEventAsset);
    $pastEventAsset_tid = $pastEventAsset_term->tid;
    $pastEventSpeaker = taxonomy_get_term_by_name("Show Speakers");
    $pastEventSpeaker_term = current($pastEventSpeaker);
    $pastEventSpeaker_tid = $pastEventSpeaker_term->tid;
    /*Get node details of Past Events */
    $pas_event = taxonomy_get_term_by_name("Past Events");
    $words_term = current($pas_event);
    $pas_event_tid = $words_term->tid;
    $pasteventids = array();
    $pasteventids = taxonomy_select_nodes($pas_event_tid, $pager = FALSE);
    $pasteventData = array();
    $pasteventTitle = array();
    $pasteventTags = array();
    foreach($pasteventids as $id){
        $pasteventData[$id] = node_load($id);
        $pasteventTitle[$id] = $pasteventData[$id]->title;
    }
?>
<?php if(!empty($events['pastEvents']) && count($events['pastEvents']) > 0): ?>
    <h2 class="heading past"><?php print t('Janssen Past events');?></h2>
    <p><?php print t('You were invited to the following events that occurred in the past.');?></p>
    <section class="past-events">
    <?php $jc_ap_hcp_profile_settings = drupal_json_decode(variable_get('jc_ap_hcp_profile_settings', ''));
                    $suvey_events = jc_ap_hcp_events_list_with_survey(); ?>
    <?php foreach($events['pastEvents'] as $event):?>
             <article>
                <div class="heading">        
                    <img src="<?php print jc_ap_hcp_events_images($event['eventID']);?>" alt="">
                </div>
                <div class="content" style="clear:none;"> 
                    <h3 class="blue"><?php print $event['eventName']; ?></h3>
                    <p class="time"><?php print date("l d/m/Y", strtotime($event['eventDate'])); ?></p>                    
                    <p><?php print $event['eventDescription'] . '&nbsp;'; ?></p>
                     <?php
                        if(in_array($event['eventName'], $pasteventTitle)){
                            $pastnodeid = array_search($event['eventName'], $pasteventTitle);
                            $_SESSION['eventNid'] = $pastnodeid;
                            if(count(views_get_view_result('past_event_assets')) > 0) { ?>
                                <a href="/past-event/<?php print $event['eventID']; ?>" class="btn rsvp" style="float:right;"><?php print t('Read more');?></a>
                                <?php unset($_SESSION['eventNid']);
                            }
                        }
                              ?>
                    <?php
                        if($jc_ap_hcp_profile_settings['iconnect_enable_phase2_features']) {?>
                        <a href="#" class="btn past-events-disp more-info" data-eventid="<?php print $event['eventID'];?>" style="padding:8px 48px;"><?php print t('Request Content');?></a>
                        <?php  if(in_array($event['eventID'], $suvey_events)){ ?>
                        <a href="/event-survey/<?php print $event['eventID'];?>" class="btn more-info" style="padding:8px 69px;"><?php print t('SURVEY FORM');?></a>
                        <?php }
                        }?>
                </div>
            </article>
    <?php endforeach; ?>
    </section>
<?php endif; ?>
<?php } ?>
