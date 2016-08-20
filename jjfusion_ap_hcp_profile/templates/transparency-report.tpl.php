<?php

/**
 * @file
 * Transparency report template.
 */
$params = drupal_get_query_parameters();
?>
<div class="intro-text">
  <p><?php print t('Medicines Australia has introduced in the 18th Edition of its Code of Conduct with transparency measures for the payment for services and education of healthcare professionals, such as GPs, specialists and pharmacists. Janssen is required to make a record of all payments to healthcare professionals including the payment category.');?></p>
  <p><?php print t('From October 1, 2015, Medicines Australia member companies will collect and report payments to healthcare professionals.');?></p>
  <p><?php print t('Payments will be reported when Medicines Australia member companies pay a healthcare professional for their expert service or when financial support is provided for education purposes, including airfares, accommodation and conference registration fees.');?></p>
  <p><?php print t('Janssen is required to report publicly the nature or purpose of each engagement, the date and value of the payment and information about the healthcare professional including their name and principal practice address.');?></p>
  <p><?php print t('Please review the payments Janssen has made to you throughout the current reporting period to ensure the information is correct.');?></p>
  <p><?php print t('Click on the <b>VIEW</b> button to see more details about your payment details.');?></p>
  <p><?php print t('This form should not be used to report an adverse drug experience. To report an adverse drug experience or other drug safety issues, please contact Janssen Drug Safety on <a href="tel:+61 2 9815 3260">+61 2 9815 3260</a> or <a href="mailto:LSO_AUST@its.jnj.com">LSO_AUST@its.jnj.com</a>');?></p>
</div>

<div class="reporting-period">
  
  <h3 class="blue">
    <?php print t('Reporting Period');?>
    <span>
      <?php print drupal_render($form['filter']);?>
    </span>
  </h3>

  <section>

    <ul class="reporting-list">
      <?php foreach($form['eventDetails']['#values'] as $key => $trans_report) { ?>
      <li>
        <div class="list-header">
          <div class="list-title"><?php print '<span>'; print $key + 1 . '.</span><span class="event-title-text">' . $trans_report['eventTitle'] . '</span>';?></div>
          <div class="list-date"><?php print ($trans_report['startDate'] != '' ? date("d/m/Y", strtotime($trans_report['startDate'])) : '') . ($trans_report['endDate'] != '' ? ' - ' . date("d/m/Y", strtotime($trans_report['endDate'])) : '');?></div>
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
                      <div class="query">Query Information <div class="help question-mark" title="<?php print t('If you have any questions about this Information please use the check box and submit an explanation in the text box  below.<br> We will respond to your query as quickly as possible.');?>">?</div></div>
                      <div class="consent">Publish by Name?<div class="help question-mark" title="<?php print t('Janssen respects your privacy rights and you can choose to withdraw your consent at any time, with no negative impact. If you choose to opt-out, we will disclose your payments on an aggregate and anonymous basis (it will not identify you).');?>">?</div></div>
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
          <?php }?>
                </ul>

                <div class="item-query submit-button">
                  <div class="query-buttons">
                    <div><?php print drupal_render($form[$trans_report['eventID']]['submit_' . $trans_report['eventID']]);?></div>
                  </div>
                </div>


            </div>
          </div>
        </div>
      </li>
      <?php }?>
    </ul>

  </section>

  <div class="divide-container">
    <div class="divide-left">
      <h1><?php print t('Preview Your Report');?></h1>
      <span><?php print t('Download a copy of your current Transfer of Value report.');?></span>
    </div>
    <div class="divide-right">
      <a href="/transparency-report-download?filter=<?php print $params['filter'];?>" class="download"><?php print t('Download PDF');?></a>
    </div>
  </div>

  <div class="page-links">
    <h2><?php print t('Questions about transparency');?></h2>
    <div class="links-container">
      <p><?php print t('Here are some additional resources about the Transfer of Value payments.');?></p>
    <p>&nbsp;</p>
    <p><?php print t('Some resources have been produced by independent organisations. These resources are provided for your information only. They may contain content Janssen does not endorse. Janssen is not responsible for the validity of the information on these resources.');?></p>
      <ul>
        <li class="website">
          <a href="https://medicinesaustralia.com.au/code-of-conduct/education-events-reports/">
        <h4><?php print t('Medicines Australia Transparency Reporting');?></h4>
        <p><?php print t('Information about Transparency Reporting provided by Medicines Australia.');?></p>
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
  <h2><?php print t('For the best experience, please use landscape mode on your mobile device or a desktop / laptop computer.');?></h2>
</div>
<div class="popup" id="transparency-report-success">
  <h2><?php print t('Your query has been submitted.');?></h2>
</div>
<?php print drupal_render($form['submitedBudget']); ?>
<?php print drupal_render_children($form); ?>
