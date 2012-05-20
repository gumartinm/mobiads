<h2><?php echo __('Company Category Index') ?></h2>

<?php include_partial('category/list', array('company_categories' => $companyCategories)) ?>

<a href="<?php echo url_for('category/new') ?>" class="bt_green"><span class="bt_green_lft"></span><strong><?php echo __('Create new Category') ?></strong><span class="bt_green_r"></span></a>
