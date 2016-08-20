<?php

/**
 * @file
 * Templates.
 */
$params = drupal_get_query_parameters();
?>
<header class="short clouds">
    <h1><?php print drupal_get_title();?></h1>
</header>
<div class="transparecy-intro intro-text">
  <p><?php print t('As a member of Medicines Australia, Janssen has undertaken to be open and transparent when we provide a reportable payment to a healthcare professional.');?></p>
  <p><?php print t('Please review by <b>16 August, 2016</b> the details below of the reportable payments made to you in the last reporting period to ensure the information is correct. You have previously provided your express consent to Janssen to publicly disclose these payments.');?></p>
  <p><?php print t('The data that you have consented to publicly disclose will be made available on the Janssen Australia website on 31 August, 2016 for three years. After 1 October, 2016 all reportable payments will be publicly disclosed.');?></p>
  <p><?php print t('<b>How to review your data</b>');?></p>
  <p><?php print t('Click on the <b>VIEW</b> button below to see more information about your payment.');?></p>
  <p><?php print t('<b>How to query your data</b>');?></p>
  <p><?php print t('If you have a query for a particular payment, click on the checkbox under <b>Query my payments</b>.<br>Enter your supporting comments in the text box and click on the <b>SUBMIT</b> button.');?></p>
  <p><?php print t('This form <b>should not be used to report an adverse drug experience</b>. To report an adverse drug experience or other drug safety issues, please contact Janssen Drug Safety on +61 2 9815 3260 or <a href="mailto:LSO_AUST@its.jnj.com">LSO_AUST@its.jnj.com</a>');?></p>
</div>

<div class="reporting-period contacts">
    <h3 class="blue">
    <?php print t('Your Details');$user_details = $_SESSION['user-details'];?>
    <span>
    </span>
  </h3>
     <div class="details" style="padding-top:20px;padding-left:25px;">
            <h4><?php print $user_details['title'] . ' ' . $user_details['firstName'] . ' ' . $user_details['lastName'];?></h4>
            <p><?php print $user_details['addressLine1'] . ', ' . $user_details['suburb'] . ', ' . $user_details['state'];?></p>
            <p><?php print $user_details['role'];?></p>            
          </div></div>
<div class="reporting-period">
  
  <h3 class="blue">
    <?php print t('Reporting Period');?>
    <span>
      <?php print drupal_render($form['filter']);?>
    </span>
  </h3>

  <section>

    <ul class="reporting-list">
      
      <?php if(count($form['eventDetails']['#values']) > 0){foreach($form['eventDetails']['#values'] as $key => $trans_report) { ?>
      <li>
        <div class="list-header">
          <div class="list-title"><?php print '<span>'; print $key + 1 . '.</span><span class="event-title-text">' . $trans_report['eventTitle'] . '</span>';?></div>
          <div class="list-date"><?php print ($trans_report['startDate'] != '' ? date("d/m/Y", strtotime($trans_report['startDate'])) : '') . (($trans_report['endDate'] != '' && (date("d/m/Y", strtotime($trans_report['endDate'])) != date("d/m/Y", strtotime($trans_report['startDate'])))) ? ' - ' . date("d/m/Y", strtotime($trans_report['endDate'])) : '');?></div>
          <?php if($trans_report['venueState'] || $trans_report['venueSuburb']) {?>
      <div class="list-location"><?php print $trans_report['venueSuburb'] . ($trans_report['venueState'] && $trans_report['venueSuburb'] ? ', ' : '') . $trans_report['venueState'];?></div>
<?php
          } else {?>
      <div></div>
      <?php
          }?>
          <div class="list-service"><?php print $trans_report['portalTypeEvent'];?></div>
          <div class="list-toggle"></div>
        </div>
        <div class="list-content">
          <div class="service-container">
            <div class="service-type">
                
              <ul>
                <li class="head">
                  <div>
                    <div><?php print t('Service Type');?></div>
                  </div>
                </li>
                <li>
                  <div>
                    <div><?php print $trans_report['portalTypeService'];?></div>
                  </div>
                </li>
              </ul>

            </div>
            <div class="service-info">


                <ul>
                  <li class="head">
                    <div>
                      <div class="type">Payment Type</div>
            <div class="made">Payment Made to</div>
                      <div class="amount">Amount</div>
                      <div class="date">Date Paid</div>
                      <div class="query">Query my payments <div class="help question-mark" title="<?php print t('If you have any questions about this payment please use the check box and submit an explanation in the text box  below.<br> We will respond to your query as quickly as possible.');?>">?</div></div>
                      <div class="consent">Publish by Name?<div class="help question-mark" title="<?php print t('Janssen respects your privacy rights and you can choose to withdraw your consent at any time. If you choose to opt-out, we will disclose your payments on an aggregate and anonymous basis (it will not identify you). After 1 October, 2016 all reportable payments will be publicly disclosed.');?>">?</div></div>
                    </div>
                  </li>
          <?php foreach($trans_report['expenseList'] as $expenseList) { ?>
                  <li>
                    <div>
                      <div class="type"><?php print $expenseList['expenseType'];?></div>
            <div class="made"><?php print $expenseList['paymentMadeTo'];?></div>
                      <div class="amount">$<?php print number_format($expenseList['actualAmount'], 2);?></div>
                      <div class="date"><?php print date("d/m/Y", strtotime($expenseList['datePaid']));?></div>
                      <div class="query">
                <?php print drupal_render($form[$expenseList['budgetID']]['querySelect_' . $expenseList['budgetID']]);?>
                      </div>
                      <div class="consent">
                <?php print drupal_render($form[$expenseList['budgetID']]['publishByName_' . $expenseList['budgetID']]);?>
                      </div>
                    </div>
              <div class="item-query">
                  <?php print drupal_render($form[$expenseList['budgetID']]['comments_' . $expenseList['budgetID']]);?>
                </div>
                  </li>
          <?php }
        ?>
                </ul>

                <div class="item-query submit-button">
                  <div class="query-buttons">
                    <div><?php print drupal_render($form[$trans_report['eventConsultingID']]['submit_' . $trans_report['eventConsultingID']]);?></div>
                  </div>
                </div>


            </div>
          </div>
        </div>
      </li>
      <?php }
      }else { ?>
    <p>There were no reportable items for you during the selected reporting period. If you believe this is incorrect, please contact us on janssenanztransparency@its.jnj.com or 1800 226 334.</p>
<?php
      }?>
    </ul>

  </section>
<?php if(count($form['eventDetails']['#values']) > 0) {?>
  <div class="divide-container">
    <div class="divide-left">
      <h1><?php print t('Preview Your Report');?></h1>
      <span><?php print t('Download a copy of your Transfer of Value report for the current reporting period.');?></span>
    </div>
    <div class="divide-right">
      <a href="/transparency-report-download?filter=<?php print $params['filter'];?>" class="download"><?php print t('Download PDF');?></a>
    </div>
</div>
<?php }?>

  <div class="page-links">
    <h2><?php print t('Questions about transparency');?></h2>
    <div class="links-container">
      <p><?php print t('Read more details about how your Transfer of Value payments are calculated and other useful information.');?></p>
    <p>&nbsp;</p>
    <p><?php print t('Some resources have been produced by independent organisations. These resources are provided for your information only. They may contain content Janssen does not endorse. Janssen is not responsible for the validity of the information on these resources.');?></p>
      <ul>
        <li class="website">
          <a href="https://medicinesaustralia.com.au/code-of-conduct/education-events-reports/">
        <h4><?php print t('Medicines Australia Transparency Reporting');?></h4>
        <p><?php print t('This is a link to information about Transparency Reporting provided by Medicines Australia.');?></p>
          </a>
        </li>
        <li class="sheet">
          <a href="https://medicinesaustralia.com.au/code-of-conduct/">
        <h4><?php print t('Medicines Australia Code of Conduct - Current Edition');?></h4>
        <p><?php print t('Medicines Australia’s Code of Conduct sets the standards for the ethical marketing and promotion of prescription pharmaceutical products in Australia.');?></p>
          </a>
        </li>
      </ul>
    </div>
  </div>

</div> <!-- end reporting-period -->


<div class="popup" id="mobile-notice">
  <h2><?php print t('For best results, please use landscape mode on your mobile device.');?></h2>
</div>
<div class="popup" id="transparency-report-success">
  <h2><?php print t('Your query has been submitted.');?></h2>
</div>
<div class="popup" id="transparency-report-nomail-success">
  <h2><?php print t('Thank you for updating your transparency report information.');?></h2>
</div>
<?php print drupal_render_children($form); ?>
