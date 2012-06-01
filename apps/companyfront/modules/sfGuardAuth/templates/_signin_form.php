<?php use_helper('I18N') ?>

<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" class="niceform">
  <fieldset>
  <legend>SIGN IN</legend>
  <table>
    <tbody>
        <?php echo $form->renderGlobalErrors() ?>
        <?php echo $form->renderHiddenFields(false) ?>
        <?php echo $form['username']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['password']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['remember']->renderRow()?>
    </tbody>
  </table>
  </fieldset>
  <table align="right">
    <tbody>
            <tr>
            <td>
                <input type="submit" value="<?php echo __('Log In', null, 'sf_guard') ?>" class="NFButton"/>
            </td>
            <td>
                <?php $routes = $sf_context->getRouting()->getRoutes() ?>
                <?php if (isset($routes['sf_guard_forgot_password'])): ?>
                    <a href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Forgot your password?', null, 'sf_guard') ?></a>
                <?php endif; ?>

                <?php if (isset($routes['register_index'])): ?>
                    &nbsp; <a href="<?php echo url_for('@register_index') ?>" class="bt_red"><strong><?php echo __('Want to register?', null, 'sf_guard') ?></strong></a>
                <?php endif; ?>
            </td>
            </tr>
        </tbody>

  </table>

</form>
