<h2><?php echo __('Your Personal Data') ?></h2>

<table id="rounded-corner">
  <tbody>
    <tr>
      <td><?php echo __('First Name: ') ?></td>
      <td><?php echo $sf_guard_user->getFirstName() ?></td>
    </tr>
    <tr>
      <td><?php echo __('Last Name: ') ?></td>
      <td><?php echo $sf_guard_user->getLastName() ?></td>
    </tr>
    <tr>
      <td><?php echo __('Email Address: ') ?></td>
      <td><?php echo $sf_guard_user->getEmailAddress() ?></td>
    </tr>
    <tr>
      <td><?php echo __('Last Login') ?></td>
      <td><?php echo $sf_guard_user->getLastLogin() ?></td>
    </tr>
    <tr>
      <td><?php echo __('Language') ?></td>
      <td><?php echo $sf_guard_user->getLanguage()->getLanguageName() ?></td>
    </tr>
  </tbody>
</table>

  <a href="<?php echo url_for('user/edit') ?>" class="bt_green"><span class="bt_green_lft"></span><strong><?php echo __('Edit Your Data') ?></strong><span class="bt_green_r"></span></a>

