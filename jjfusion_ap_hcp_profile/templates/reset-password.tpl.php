<?php

/**
 * @file
 * Reset passeword template.
 */
?>
<div class="register-form-wrapper">
    <header>
                <h2><?php print t('Please enter a new password');?></h2>
                <a class="reg-back" href="/"><?php print t('Back');?></a>
        
    </header>
    <fieldset>
    <?php print render($form['password']); ?>
    <?php print render($form['confirm_password']); ?>
</fieldset>
<fieldset class="controls">
    <?php print render($form['Submit']); ?>
</fieldset>
<?php print drupal_render_children($form); ?>
</div>
