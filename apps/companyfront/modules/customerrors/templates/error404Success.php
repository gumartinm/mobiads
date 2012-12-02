<center><?php echo image_tag('/sf/sf_default/images/icons/cancel48.png', array('alt' => 'page not found', 'size' => '48x48')) ?></center>
<h1><center>Oops! Page Not Found</center></h1>
<h1><center>The server returned a 404 response.</center></h1>

<table align="center">
    <tbody>
        <tr>
        <td>
            <a href="javascript:history.go(-1)"class="bt_red"><span class="bt_red_lft"></span><strong><?php echo __('Back to previous page') ?></strong><span class="bt_red_r"></span></a>
        </td>
        <td>
            <a href="<?php echo url_for('@homepage') ?>" class="bt_green"><span class="bt_green_lft"></span><strong><?php echo __('Go to Homepage') ?></strong><span class="bt_green_r"></span></a>
        </td>
        </tr>
    </tbody>
</table>
