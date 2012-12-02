<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#office_City_Region_country_id').change(function() {
            $.post('<?php echo url_for('office/chosencountry') ?>', { 'countryId': $(this).val() },
                function(data){
                    $('#office_City_region_id').empty();
                    $('#office_City_region_id').removeAttr('disabled');
                    $('#office_City_region_id').append($("<option></option>").attr("value", "").text(""));
                    $.each(data, function(value, key) {
                        $('#office_City_region_id').append($("<option></option>").attr("value", value).text(key));
                    });
            }, "json");
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#office_City_region_id').change(function() {
            $.post('<?php echo url_for('office/chosenregion') ?>', { 'regionId': $(this).val() },
                function(data){
                    $('#office_city_id').empty();
                    $('#office_city_id').removeAttr('disabled');
                    $('#office_city_id').append($("<option></option>").attr("value", "").text(""));
                    $.each(data, function(value, key) {
                        $('#office_city_id').append($("<option></option>").attr("value", value).text(key));
                    });
            }, "json");
        });
    });
</script>

<script type="text/javascript">
    var alreadyOpened = false;

    $(document).ready(function(){
        $('#office_longitude').click(function() {
            if (!window.alreadyOpened) {
                window.alreadyOpened = true;
                var longitude = document.getElementById('office_longitude');
                var latitude = document.getElementById('office_latitude');
                var adMapURL = 'http://localhost/companyfront_dev.php/admap/officemap?latitude='+latitude.value+'&longitude='+longitude.value;
                newwindow=window.open(adMapURL, '', 'menubar=no,height=600,width=600');
                if (window.focus) {
                    newwindow.focus()
                }
            }
        });
    });

    $(document).ready(function(){
        $('#office_latitude').click(function() {
            if (!window.alreadyOpened) {
                window.alreadyOpened = true;
                var longitude = document.getElementById('office_longitude');
                var latitude = document.getElementById('office_latitude');
                var adMapURL = 'http://localhost/companyfront_dev.php/admap/officemap?latitude='+latitude.value+'&longitude='+longitude.value;
                newwindow=window.open(adMapURL, '', 'menubar=no,height=600,width=600');
                if (window.focus) {
                    newwindow.focus()
                }
            }
        });
    });

</script>



<form action="<?php echo url_for('office/'.($form->getObject()->isNew() ? 'create' : 'update').'?page='.$page.'&sort='.$sort.(!$form->getObject()->isNew() ? '&id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <fieldset>
  <legend><?php echo __('OFFICE') ?></legend>
  <table>
    <tbody> 
        <?php echo $form->renderGlobalErrors() ?>
        <?php echo $form->renderHiddenFields(false) ?>
        <?php echo $form['City']['Region']['country_id']->renderRow(array('class' => 'validate-selection'))?>
        <?php echo $form['City']['region_id']->renderRow(array('class' => 'validate-selection'))?>
        <?php echo $form['city_id']->renderRow(array('class' => 'validate-selection')) ?>
        <?php echo $form['office_street_address']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['office_zip']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['longitude']->renderRow(array('class' => 'required')) ?>
        <?php echo $form['latitude']->renderRow(array('class' => 'required')) ?>
    <tbody>
  </table>
  </fieldset>
  <table align="right">
        <tbody>
            <tr>
            <td>
                <a href="<?php echo url_for('office/index?page='.$page.'&sort='.$sort) ?>" class="bt_red"><strong><?php echo __('Back to list') ?></strong></a>
            </td>
            <td>
                <input type="submit" value="<?php echo __('Save') ?>" class="NFButton">
            </td>
            </tr>
        </tbody>
   </table>
</form>

<div id="map_canvas" style="width:100%; height:40%"></div>
