<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php //include_title() ?>
	<title><?php echo __('Mobi - Mobile Ads') ?></title>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>

	<script type="text/javascript">
	ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='/images/inadminpanel/images/plus.gif' class='statusicon' />", "<img src='/images/inadminpanel/images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
  </script>
  </head>
  <body>
  <div id="main_container">
	<div class="header">
    	<div class="logo"><a href="#"><img src="" alt="" title="" border="0" /></a></div>
        <div class="right_header"><?php echo __('Welcome')." ".$sf_user->getGuardUser()->getFirstName() ?> | <a href="<?php echo url_for('sf_guard_signout') ?>" class="logout"><?php echo __('Logout') ?></a></div>
	</div>
	<div class="main_content">
		<div class="menu">
        <ul>
        <li><a class="current" href="<?php echo url_for('homepage') ?>"><?php echo __('Home') ?></a></li>
        <li><a>Manage Categories<!--[if IE 7]><!--></a><!--<![endif]-->
            <ul>
                <li><a href="<?php echo url_for('category/index') ?>" title=""><?php echo __('Categories Index') ?></a></li>
            </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]-->
        </li>
         </ul>
         </div>
	<div class="center_content">
    <div class="left_content">
    		<div class="sidebar_search">
            <form>
            <input type="text" name="" class="search_input" value="search keyword" onclick="this.value=''" />
            <input type="image" class="search_submit" src="/images/inadminpanel/images/search.png" />
            </form>            
            </div>
            <div class="sidebarmenu">
            
                <a class="menuitem submenuheader" href=""><?php echo __('Categories') ?></a>
                <div class="submenu">
                    <ul>
                    <li><a href="<?php echo url_for('category/index') ?>"><?php echo __('Categories Index') ?></a></li>
                    </ul>
                </div>
                
                <a class="menuitem_green" href="<?php echo url_for('user/index') ?>"><?php echo __('Your Personal Data') ?></a>
                
            </div>
		</div>
	
		 <div class="right_content"> 

			<?php echo $sf_content ?>

		 </div>
      </div>
	<div class="clear"></div>
	</div> <!--end of main content-->

	<div class="footer">
		<div class="left_footer">MOBILE ADS | Powered by <a href="http://uah.es">UAH</a></div>
    	<div class="right_footer"><a href="http://uah.es"><img src="" alt="" title="" border="0" /></a></div>
    </div>
</div>
  </body>
</html>
