<?php

/**
 * @file
 * User login template.
 */
?>
<h3><?php print t('Log in'); ?></h3>
            <a class="close" href="#"><?php print t('close');?></a>
            <fieldset>
              <?php print render($form['name']); ?>
              <div class="help-btn-wrapper">
                <?php print render($form['pass']); ?>
                
                <a class="help" href="/hcp-forgot-password" title="<?php print t('Forgot your password?');?><br><?php print t('Click the icon to reset it.');?>"><?php print t('Help');?></a>
              </div>
              <?php print render($form['actions']['submit']); ?>
              <a class="forgot-password" href="/hcp-forgot-password"><?php print t('Forgot password'); ?></a>
            </fieldset>
            <?php print drupal_render_children($form); ?>
