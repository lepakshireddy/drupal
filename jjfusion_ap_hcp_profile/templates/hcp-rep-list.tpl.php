<?php

/**
 * @file
 * Hcp rep list template.
 */
global $theme;
$jnj_veeva_hcp_profile_messages = drupal_json_decode(variable_get('jnj_veeva_hcp_profile_messages'));

?>
    
    <header class="tall" style="background-image:url(<?php  print '/' . drupal_get_path('theme', $theme)?>/images/header_contact.jpg);">
      <h1><?php print t('My Janssen contacts'); ?></h1>
   <!--   <p style="left: 366px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vitae tellus ex.</p> -->
    </header>
    
    <div class="contacts rep_details">
    <?php foreach($data as $rep_role => $rep_list_by_roles): ?>
    
    <div class="col">
        <h3 class="blue"><?php print ($rep_role == 'AP_Core_Sales' ? 'Janssen Representative' : 'Medical Scientific Liaison'); ?></h3>
        <?php foreach($rep_list_by_roles as $rep_list): ?>    
    <div class="content">
      <?php if(isset($rep_list['repImage'])){ ?>
    <?php print $rep_list['repImage']; ?>
      <?php
      }?>
    <div class="details" style="padding-top:0px;padding-bottom:0px;">
            <h4><?php print $rep_list['repName']; ?></h4>
            <p><a href="mailto:<?php print $rep_list['repEmail']; ?>"><?php print $rep_list['repEmail']; ?></a></p>
            <p><a href="tel:<?php print $rep_list['repPhone']; ?>"><?php print $rep_list['repPhone']; ?></a></p>
          </div>
<?php if($rep_list['disable_request_call']){?>
          <a href="javascript:void(0);" class="btn request requested"><?php print t('Call requested'); ?></a>
          <?php
}else {?>
          <a id="<?php print $rep_list['repID']; ?>"href="/hcp-request-visit/nojs/<?php print $rep_list['repID']; ?>" class="use-ajax btn request" class="btn request"><?php print t('Request a Call'); ?></a>
          <?php
}?>
        </div>
        <?php
        endforeach; ?>
    </div>    
        
    <?php
    endforeach; ?>    
    </div>
    <h2 class="heading"><?php print t('Company contact details');?></h2>
    <div class="contacts three-columns">
      <!--div class="col">
          <h3 class="blue">Janssen Med Info</h3>
        <div class="content details">
        <p><a href="mailto:medinfo@janau.jnj.com "> medinfo@janau.jnj.com </a></p>
        </div>
        <h3 class="blue">Janssen Corporate</h3>
        <div class="content details">
          <p><a href="mailto:info@janau.jnj.com">info@janau.jnj.com</a></p>
          <p>Address: 1-5 Khartoum Rd,<br>North Ryde NSW 2113 Australia</p>
          <p>Ph. <a href="tel:1800 226 334">1800 226 334</a></p>
          <p>Fax: +61 2 9815 3300</p>
        </div>
      </div-->

          <?php
          print render($jnj_veeva_hcp_profile_messages['hcp_contactuspage_message']); ?>
<div class="wide-col col">
      <?php
    $webform_id = '';
  if(function_exists('janssenpro_webform_block_id_by_name')) {$webform_id = janssenpro_webform_block_id_by_name('Request Clinical Paper');
  }
    $block = module_invoke('webform', 'block_view', 'client-block-' . $webform_id);
        print render($block['content']);
      ?>
      </div>
      </div>
