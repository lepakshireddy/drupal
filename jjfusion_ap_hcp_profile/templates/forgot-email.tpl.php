<?php

/**
 * @file
 * Forgot email template.
 */

global $theme;
?>
<?php print render($form['forgot-email-markup']); ?>
<fieldset>
    <div class="col">
         <?php print render($form['lastName']); ?>   
    </div>
</fieldset>
<fieldset>	
    <div class="col">
      
      <?php print render($form['securityQuestions'][0]); ?>
      
    </div>
    <div class="col">
      
      <?php print render($form['securityQuestions'][1]); ?>
    </div>
</fieldset>

<fieldset>

    <?php print render($form['Submit']); ?>

</fieldset>
<?php print drupal_render_children($form); ?>
