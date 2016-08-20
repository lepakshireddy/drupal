<?php

/**
 * @file
 * Templates.
 */

/**
 * Templates.
 */
if(count($events) > 0){?>
<div class="upcoming-events widget">
    <h2><?php print t('Upcoming events'); ?></h2>
    <ul>
        <?php foreach($events as $event) { ?>
        <li class="star">
            <?php if(isset($event['eventType']) && $event['eventType'] == 'industry') {?>
            <h3><a target="_blank" href="<?php print $event['eventURL'];?>"><?php print $event['eventName']; ?></a></h3>
            <p><?php print $event['eventDate']; ?></p>
            <?php }else { ?>
            <h3><a href="/event-detail/<?php print $event['eventID']; ?>"><?php print $event['eventName']; ?></a></h3>
            <p><?php print date("l d/m/Y", strtotime($event['eventDate'])); ?></p>
            <?php }?>
        </li>
        <?php }?>
    </ul>
    <a class="btn" href="/event-list"><?php print t('See all'); ?></a>
</div>
<?php }?>
