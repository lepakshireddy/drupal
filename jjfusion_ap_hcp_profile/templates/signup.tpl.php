<?php

/**
 * @file
 * Signup template.
 */

global $theme;
?>



  <header>
      <?php if(isset($_SESSION['userdestination']) && $_SESSION['userdestination'] != '') {?>
        <p style="padding: 0px 0px 10px; margin: 0px; font-weight: 400; font-size: 18px;"><?php echo t('Please login to Janssen Pro to access your content. If you do not have a Janssen Pro account, please register below.');?></p>
      <?php }?>
<?php print render($form['header']); ?>
</header>
<?php if($form['currentStep']['#value'] == 1): ?>  
  <div class="col" id="register-step-col-left">
    <img style="width:100%" src="<?php print base_path() . drupal_get_path('theme', $theme);?>/images/video.jpg" />
  </div>
  <div class="col" id="register-step-col-right">
  
<?php endif; ?>  
  <div class="register-form-wrapper">
<?php print render($form['title']); ?>
<fieldset class="register-fields">	
    <?php if($form['currentStep']['#value'] > 1 && $form['currentStep']['#value'] < 5): ?><div class="col"><?php
    endif; ?>    
        <?php print render($form['userProfile']['step2']['registrationCode']); ?>
        <?php print render($form['userProfile']['step2']['firstName']); ?>
        <?php print render($form['userProfile']['step2']['lastName']); ?>
        <?php print render($form['userProfile']['step2']['email']); ?>
        <?php print render($form['userProfile']['step2']['therapyArea']); ?>
        
        <?php print render($form['userProfile']['step3']['role']); ?>
        <?php print render($form['userProfile']['step3']['otherRole']); ?>
        <?php print render($form['userProfile']['step3']['specialty']); ?>
        <?php print render($form['userProfile']['step3']['otherSpecialty']); ?>
        <?php print render($form['userProfile']['step3']['practiceName']); ?>
        <?php print render($form['userProfile']['step3']['addressLine1']); ?>
        <?php print render($form['userProfile']['step3']['addressLine2']); ?>
        
        <?php print render($form['userProfile']['step4']['securityQuestions'][0]['question']); ?>
        <?php print render($form['userProfile']['step4']['securityQuestions'][0]['answer']); ?>
        
        <?php print render($form['userProfile']['step5']['emailSubscribe']); ?>
        <?php print render($form['userProfile']['step5']['consent']); ?>
    <?php if($form['currentStep']['#value'] > 1 && $form['currentStep']['#value'] < 5): ?></div><?php
    endif; ?>
    <?php if($form['currentStep']['#value'] > 1 && $form['currentStep']['#value'] < 5): ?><div class="col"><?php
    endif; ?>
        <?php print render($form['userProfile']['step1']['haveRegCode']); ?>
        
        <?php print render($form['userProfile']['step2']['password']); ?>
        <?php print render($form['userProfile']['step2']['confirm_password']); ?>
        <?php print render($form['userProfile']['step2']['country']); ?>
        <?php print render($form['userProfile']['step2']['gradYear']); ?>
        <?php print render($form['userProfile']['step2']['state']); ?>
        <?php print render($form['userProfile']['step2']['postCode']); ?>
        
        <?php print render($form['userProfile']['step3']['country']); ?>
        <?php print render($form['userProfile']['step3']['suburb']); ?>
        <?php print render($form['userProfile']['step3']['state']); ?>    
        <?php print render($form['userProfile']['step3']['postCode']); ?>
        <?php print render($form['userProfile']['step3']['phone']); ?>
        <?php print render($form['userProfile']['step3']['fax']); ?>
        <?php print render($form['userProfile']['step3']['websiteUrl']); ?>
        
        <?php print render($form['userProfile']['step4']['securityQuestions'][1]['question']); ?>
        <?php print render($form['userProfile']['step4']['securityQuestions'][1]['answer']); ?>
    <?php if($form['currentStep']['#value'] > 1 && $form['currentStep']['#value'] < 5): ?></div><?php
    endif; ?>
</fieldset>
<fieldset class="validate">
    <div class="validating"><?php print t('Validating...'); ?></div>
</fieldset>
<fieldset>
    <?php print render($form['next']); ?>
    <?php print render($form['submit']); ?>
    <?php print render($form['prev']); ?>        
    <div class="ajax-loader">&nbsp;</div>
</fieldset>
<?php print drupal_render_children($form); ?>
  </div>

<?php unset($_SESSION['step1_repeat']);  ?>
<?php if($form['currentStep']['#value'] == 1): ?>    </div><?php
endif; ?>
