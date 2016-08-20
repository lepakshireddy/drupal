<?php

/**
 * @file
 * Update profile template.
 */
?>
  
<div class="col">
    <h3 class="blue"><?php print t('About me'); ?></h3>
    <div class="content">
        <?php if(isset($form['updateProfile']['title'])) { ?>
        <p class="title">
            <span><?php print render($form['updateProfile']['title']['#title']); ?></span>
            <?php print drupal_render($form['updateProfile']['title']); ?>
        </p>
        <?php }
        if(isset($form['updateProfile']['firstname'])) { ?>
        <p>
            <span><?php print render($form['updateProfile']['firstname']['#title']); ?></span>
            <?php print drupal_render($form['updateProfile']['firstname']); ?>
        </p>
        <?php }?>
        <p>
            <span><?php print render($form['updateProfile']['lastname']['#title']); ?></span>
            <?php print drupal_render($form['updateProfile']['lastname']); ?>
        </p>
        <div class="col">

            
            <p>
                <span><?php print render($form['updateProfile']['role']['#title']); ?></span>
                <?php print drupal_render($form['updateProfile']['role']); ?>
            </p>
            
            <fieldset>
                <?php print drupal_render($form['updateProfile']['therapyArea']); ?>
            </fieldset>
        </div>
        <div class="col">
            <p>
                <span><?php print render($form['updateProfile']['phone']['#title']); ?></span>
                <?php print drupal_render($form['updateProfile']['phone']); ?>
            </p>
        </div>
    </div>
</div>
<div class="col">
    <h3 class="blue"><?php print t('About my practice'); ?></h3>
    <div class="content">
        <p>
            <span><?php print render($form['updateProfile']['practiceName']['#title']); ?></span>
            <?php print drupal_render($form['updateProfile']['practiceName']); ?>
        </p>
        <p>
            <span><?php print render($form['updateProfile']['addressLine1']['#title']); ?></span>
            <?php print drupal_render($form['updateProfile']['addressLine1']); ?>
        </p>
        <p>
            <span><?php print render($form['updateProfile']['suburb']['#title']); ?></span>
            <?php print drupal_render($form['updateProfile']['suburb']); ?>
        </p>
        <div class="col">
            <p>
                <span><?php print render($form['updateProfile']['state']['#title']); ?></span>
                <?php print drupal_render($form['updateProfile']['state']); ?>
            </p>
        </div>
        <div class="col">
            <p>
                <span><?php print render($form['updateProfile']['postcode']['#title']); ?></span>
                <?php print drupal_render($form['updateProfile']['postcode']); ?>
            </p>
        </div>
    </div>
</div>
<div class="col">
    <h3 class="blue"><?php print t('Login Details'); ?></h3>
    <div class="content">
        <fieldset>
            <div class="col">
                <!-- <label for="current-password">Current password</label>
                <input type="password" name="current-password" id="current-password"> -->

                <?php print drupal_render($form['updateProfile']['new_email']); ?>
                

                    
            </div>
        </fieldset>
        <fieldset>
            <div class="col">
                <!-- <label for="current-password">Current password</label>
                <input type="password" name="current-password" id="current-password"> -->
                <?php print drupal_render($form['updateProfile']['password']); ?>
                

                    
            </div>
            <div class="col">
            
                <?php print drupal_render($form['updateProfile']['confirm_password']); ?>
                

                
            </div>
        </fieldset>
        <fieldset>
        
            <label for="security-question-2"><?php print t('Security question 1'); ?></label>

                <?php
                unset($form['updateProfile']['securityQuestions'][0]['question']['#title']);
                print drupal_render($form['updateProfile']['securityQuestions'][0]['question']);
                ?>


                <?php
                unset($form['updateProfile']['securityQuestions'][0]['answer']['#title']);
                print drupal_render($form['updateProfile']['securityQuestions'][0]['answer']);
                ?>
                
            <label for="security-question-2"><?php print t('Security question 2');?></label>
                <?php
                unset($form['updateProfile']['securityQuestions'][1]['question']['#title']);
                print drupal_render($form['updateProfile']['securityQuestions'][1]['question']);
                ?>

<?php
unset($form['updateProfile']['securityQuestions'][1]['answer']['#title']);
print drupal_render($form['updateProfile']['securityQuestions'][1]['answer']);
?>
        
        </fieldset>
    </div>
</div>
<div class="preferences col">
    <h3 class="blue"><?php print t('My email preferences');?></h3>
    <div class="content">

        <fieldset>

<?php print drupal_render($form['updateProfile']['emailSubscribe']); ?>
        </fieldset>
        <fieldset class="account-email">
<?php print drupal_render($form['updateProfile']['accountEmail']); ?>
        </fieldset>
    <?php print drupal_render($form['updateProfile']['consent']); ?>
   </div>
</div>
<fieldset class="controls">
    <?php print drupal_render($form['submit']); ?>
<?php print drupal_render_children($form); ?>
</fieldset>
