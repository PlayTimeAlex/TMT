<!DOCTYPE html>
<html>
    <head>
        <title><?php if (is_home () ) { bloginfo('name'); echo " - "; bloginfo('description'); 
} elseif (is_category() ) {single_cat_title(); echo " - "; bloginfo('name');
} elseif (is_single() || is_page() ) {single_post_title(); echo " - "; bloginfo('name');
} elseif (is_search() ) {bloginfo('name'); echo " результаты поиска: "; echo wp_specialchars($s);
} else { wp_title('',true); }?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=1012">
        <link rel="icon" type="image/vnd.microsoft.icon" href="<?php bloginfo('template_directory');?>/favicon.ico">
        <link rel="stylesheet" href="<?php bloginfo('template_directory');?>/css/style.min.css" media="all"/>
		<link rel="shortcut icon" href="<?php bloginfo('template_directory');?>/favicon.ico" type="image/x-icon" /> 
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <!--[if lte IE 8 ]><script type="text/javascript">window.location.href="<?php bloginfo('template_directory');?>/ie8min/index.html";</script><![endif]-->
		<?php wp_head(); ?>
		<script src="<?php bloginfo('template_directory');?>/js/all.min.js"></script>
    </head>
    <body>
        <header class="b-header">
            <div class="container">
                <div class="row">
                    <div class="span2">
                        <a class="b-header__logo" href="<?php echo bloginfo('url'); ?>"><img src="<?php bloginfo('template_directory');?>/images/content/tmt-logo.png" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>"/></a>
                    </div>
                    <div class="span6">
						<?php if (has_nav_menu('topnav')){
							wp_nav_menu( array(
								'theme_location' => 'topnav',
								'container'=>'nav', 
								'container_class' => 'b-nav',
								'sort_column' => 'menu_order',
								'depth' =>1	
							) );
						}?>
                    </div>
                    <div class="span4">
                        <div class="b-tel b-tel_icon">Наш телефон<span class="b-tel__number"><span class="b-tel__code"><?php echo get_option('artwebwpte_header_phone_cod');?></span> <?php echo get_option('artwebwpte_header_phone');?></span></div>
                    </div>
                </div>
            </div>
        </header>