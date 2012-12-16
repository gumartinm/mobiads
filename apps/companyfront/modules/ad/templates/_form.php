<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<script type="text/javascript">
    var alreadyOpened = false;
    var checkBoxes = 0;

    $(document).ready(function(){
        $('#ad_longitude').click(function() {
            if (!window.alreadyOpened) {
                window.alreadyOpened = true;
                var longitude = document.getElementById('ad_longitude');
                var latitude = document.getElementById('ad_latitude');
                var adMapURL = 'http://localhost/companyfront_dev.php/admap/admap?latitude='+latitude.value+'&longitude='+longitude.value;
                newwindow=window.open(adMapURL, '', 'menubar=no,height=600,width=600');
                if (window.focus) {
                    newwindow.focus()
                }
            }
        });
    });

    $(document).ready(function(){
        $('#ad_latitude').click(function() {
            if (!window.alreadyOpened) {
                window.alreadyOpened = true;
                var longitude = document.getElementById('ad_longitude');
                var latitude = document.getElementById('ad_latitude');
                var adMapURL = 'http://localhost/companyfront_dev.php/admap/admap?latitude='+latitude.value+'&longitude='+longitude.value;
                newwindow=window.open(adMapURL, '', 'menubar=no,height=600,width=600');
                if (window.focus) {
                    newwindow.focus()
                }
            }
        });
    });

    $(document).ready(function(){
        $('[id$=delete]').change(function(){
            var checkedBoxes = 0;
            $('[id$=delete]').each(function(data){
                if($(this).is(':checked')) {
                    checkedBoxes = checkedBoxes + 1;
                }
            });
            if (checkedBoxes == checkBoxes) {
                alert('The system always keeps one description for one ad even if you try to remove all of them. \n' +
                      'If you want to remove completely an ad you may do it from the Ads Index Web Page \n' +
                      'or just press the Back to list button which you can find on the bottom of this page.');
            }
        });
    });

    $(document).ready(function(){
        $('[id$=delete]').each(function(data){
            checkBoxes = checkBoxes + 1;
        });
    });

</script>

<form action="<?php echo url_for('ad/'.($form->getObject()->isNew() ? 'create' : 'update').'?page='.$page.(!$form->getObject()->isNew() ? '&id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <fieldset>
  <legend><?php echo __('PICTURE, GPS COORDINATES AND CATEGORY') ?></legend>
  <table>
    <tbody>
            <?php echo $form['company_categ_id']->renderRow(array('class' => 'validate-selection')) ?>
            <?php echo $form['company_categ_id']->renderError() ?>
            <?php echo $form['ad_mobile_image']->renderRow(array('class' => 'required')) ?>
            <?php echo $form['longitude']->renderRow(array('class' => 'required')) ?>
            <?php echo $form['longitude']->renderError() ?>
            <?php echo $form['latitude']->renderRow(array('class' => 'required')) ?>
            <?php echo $form['latitude']->renderError() ?>
    </tbody>
  </table>
  </fieldset>
  <fieldset>
  <legend class="optional"><?php echo __('INTERNATIONALIZATION') ?></legend>
  <table id="rounded-cornergus">
  <thead>
    <tr>
        <th> </th>
        <th scope="col" class="rounded-companygus"><?php echo __('Language') ?></th>
        <th scope="col" class="rounded-companygus"><?php echo __('Ad Name, Mobile Text and Link HTTP') ?></th>
        <th scope="col" class="rounded-q4gus"><?php echo __('Remove') ?></th>
    </tr>
  </thead>
  <tbody>
  <?php if (isset($form['new'])): ?>
     <tr>
    <td><?php echo __('New Entry:') ?></td>
    <td>
        <?php echo $form['new']['language_id']->render(array('class' => 'validate-selection')) ?>
        <?php echo $form['new']['language_id']->renderError() ?>
    </td>
    <td>
        <?php echo $form['new']['ad_name']->render(array('class' => 'required')) ?>
        <?php echo $form['new']['ad_name']->renderError() ?>
        <?php echo $form['new']['ad_mobile_text']->render(array('class' => 'required')) ?>
        <?php echo $form['new']['ad_mobile_text']->renderError() ?>
        <?php echo $form['new']['ad_link']->render(array('class' => 'required')) ?>
        <?php echo $form['new']['ad_link']->renderError() ?>
        <?php echo $form['new']['id'] ?>
        <?php echo $form['new']['id']->renderError() ?>
    </td>
    <td></td>
    </tr>
  <?php endif; ?>
  <?php foreach ($form['AdDescription'] as $adDescription): ?>
    <tr>
    <td><?php echo __('Current Entry:') ?></td>
    <td>
        <?php echo $adDescription['language_id']->render(array('class' => 'validate-selection')) ?>
        <?php echo $adDescription['language_id']->renderError() ?>
    </td>
    <td>
        <?php echo $adDescription['ad_name']->render(array('class' => 'required')) ?>
        <?php echo $adDescription['ad_name']->renderError() ?>
        <?php echo $adDescription['ad_mobile_text']->render(array('class' => 'required')) ?>
        <?php echo $adDescription['ad_mobile_text']->renderError() ?>
        <?php echo $adDescription['ad_link']->render(array('class' => 'required')) ?>
        <?php echo $adDescription['ad_link']->renderError() ?>
    </td>
    <td>
        <?php echo $adDescription['delete'] ?>
        <?php echo $adDescription['delete']->renderError() ?>
        <?php echo $adDescription['id'] ?>
        <?php echo $adDescription['id']->renderError() ?>
    </td>
    </tr> 
  <?php endforeach; ?>
  </tbody>
  </table>
  <?php echo $form->renderHiddenFields(false) ?>
  </fieldset>
  &nbsp;
  <table align="right">
        <tbody>
            <tr>
            <td>
                <a href="<?php echo url_for('ad/index?page='.$page) ?>" class="bt_red"><strong><?php echo __('Back to list') ?></strong></a>
            </td>
            <td>
                <input type="submit" value="<?php echo __('Update') ?>" class="NFButton">
            </td>
            </tr>
        </tbody>
   </table>
</form>
