<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php $path = sfConfig::get('sf_relative_url_root', preg_replace('#/[^/]+\.php5?$#', '', isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : (isset($_SERVER['ORIG_SCRIPT_NAME']) ? $_SERVER['ORIG_SCRIPT_NAME'] : ''))) ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="/favicon.ico" />
    <title>Mobi - Mobile Ads</title>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/css/inadminpanel/style.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/css/inadminpanel/niceforms-default.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/css/jquery.treeTable.css" />
  </head>

  <body>
  <div id="main_container">
    <div class="header_login">
        <div class="logo"><a href="#"><img src="" alt="" title="" border="0" /></a></div>
    </div>
    <div class="login_form">
        <center><img alt="page not found" src="<?php echo $path ?>/sf/sf_default/images/icons/tools48.png" height="48" width="48" /></center>
<h1><center>Oops! An Error Occurred</center></h1>
<h1><center>The server returned a "<?php echo $code ?> <?php echo $text ?>".</center></h1>

<table align="center">
    <tbody>
        <tr>
        <td>
            <a href="javascript:history.go(-1)"class="bt_red"><span class="bt_red_lft"></span><strong>Back to previous page</strong><span class="bt_red_r"></span></a>
        </td>
        <td>
            <a href="/companyfront.php/" class="bt_green"><span class="bt_green_lft"></span><strong>Go to Homepage</strong><span class="bt_green_r"></span></a>

        </td>
        </tr>
    </tbody>
</table>
    </div>  
    <div class="footer_login">
        <div class="left_footer_login">MOBILE ADS | Powered by <a href="http://uah.es">UAH</a></div>
        <div class="right_footer_login"><a href="http://uah.es"><img src="" alt="" title="" border="0" /></a></div>
    </div>

   </div>       
   </body>
</html>

