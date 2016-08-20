<?php

/**
 * @file
 * Templates.
 */
if(!isset($data['statusCode'])) {unset($_SESSION['event-details']);
    $_SESSION['event-details'] = $data;
}
?>
<?php
unset($_SESSION['eventNid']);
         $query = new EntityFieldQuery();
          $entities = $query->entityCondition('entity_type', 'node')->propertyCondition('type', 'article')->propertyCondition('title', $data['eventName'])->propertyCondition('status', 1)->range(0, 1)->execute();

          if (!empty($entities['node'])) {$node = node_load(array_shift(array_keys($entities['node'])));
          }
$_SESSION['eventNid'] = $node->nid;
?>
<div class="product-single">
    <header class="slider desktop">
        <h1 style="background:rgba(0, 0, 0, 0.3) none repeat scroll 0 0;border-top: 1px solid rgba(212, 212, 212, 0.4);padding: 25px; margin: 0;"><?php print $data['eventName']; ?></h1>
        <?php print views_embed_view('event_banner_images');?> 
    </header>
</div>
<div class = "events event">
<?php
$eventImage = $node->field_article_image;
?>
   
    <section>
        <div class="header">
            <div class="content">
                <p><?php print $data['eventDescription'];?></p>
            </div>
        </div>
            <!-- Key Speakers -->
            <?php
                $genPage = taxonomy_get_term_by_name("Show Speakers");
                $words_term = current($genPage);
                $genPage_tid = $words_term->tid;
                $tax = array();
                foreach ($node->field_general_tags[LANGUAGE_NONE] as $key => $value) {$tax[] = $value['tid'];
                }
// Check the event attendee status -- if that is yes enter in to below section.
                if (in_array($genPage_tid, $tax)) {
                    if($data['attended'] == "true"){

            ?>
            <div class="KeySpeakers">            
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
                        <?php
                        endif; ?>
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
                        <?php
                        endif; ?>
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
                        <?php
                        endif; ?>
                    </ul>
                </div>
           
            </div>
<?php
                    }
                }
            else{ ?>
                <div class="KeySpeakers">            
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
                        <?php
                        endif; ?>
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
                        <?php
                        endif; ?>
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
                        <?php
                        endif; ?>
                    </ul>
                </div>
           
            </div>
                
<?php
            }
            ?>
            <div class="HeroContent">
            <h3 class="blue"><?php print t('Hero Content'); ?></h3>
            <div class="details">
            <?php  print render($node->body[LANGUAGE_NONE][0]['value']); ?>
            </div>
            </div>
            <?php
            $genPage = taxonomy_get_term_by_name("Show assets");
            $words_term = current($genPage);
            $genPage_tid = $words_term->tid;
            $tax = array();
            foreach ($node->field_general_tags[LANGUAGE_NONE] as $key => $value) {$tax[] = $value['tid'];
            }
            if (in_array($genPage_tid, $tax)) {if($data['attended'] == "true"){
            ?>        
                <div class="page-links">
                    <h2><?php print t('Assets Related to') . ' ' . $data['eventName']; ?></h2>
                    <?php print views_embed_view('past_event_assets');?> 
                </div>
                <?php
                $video = $node->body[LANGUAGE_NONE][0]['summary'];
                if($video){print render(field_view_field('node', $node, 'body', array('label' => 'hidden', 'type' => 'text_summary_or_trimmed')));
                }
            }
            }
            else{
            ?>
                <div class="page-links">
                    <h2><?php print t('Assets Related to') . ' ' . $data['eventName']; ?></h2>
                    <?php print views_embed_view('past_event_assets');?> 
                </div>
                <?php $video = $node->body[LANGUAGE_NONE][0]['summary'];
                if($video){print render(field_view_field('node', $node, 'body', array('label' => 'hidden', 'type' => 'text_summary_or_trimmed')));
                }
            }
            ?>        
    </section>
</div>
