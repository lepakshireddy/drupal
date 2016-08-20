<?php

/**
 * @file
 * Forgot password template.
 */

global $theme;
?>

<h3><?php print render($form['forgot_password']['forgot-pass-markup']); ?></h3>
              <fieldset>
                <?php print render($form['forgot_password']['email']); ?>
              </fieldset>
              <fieldset class="controls">
                <?php print render($form['forgot_password']['Submit']); ?>
              </fieldset>
<?php print drupal_render_children($form); ?>
