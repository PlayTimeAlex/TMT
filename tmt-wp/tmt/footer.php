        <footer class="b-footer">
            <div class="container">
                <div class="row">
                    <div class="span8">
                        <div class="row">
                            <div class="span3">
                                <img class="b-footer__logo" src="<?php bloginfo('template_directory');?>/images/content/tmt-logo.png" alt="TMT"/>
                            </div>
                            <div class="span5">
							<?php if (has_nav_menu('topnav')){
								wp_nav_menu( array(
									'theme_location' => 'topnav',
									'container'=>'div', 
									'container_class' => 'b-footer__nav',
									'sort_column' => 'menu_order',
									'depth' =>1	
								) );
							}?>
                            </div>
                            <div class="span4">
                                <div class="b-tel b-tel_small b-tel_yellow"><strong>Наш телефон</strong><span class="b-tel__number"><span class="b-tel__code"><?php echo get_option('artwebwpte_header_phone_cod');?></span> <?php echo get_option('artwebwpte_header_phone');?></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="b-created">
                            Сайт разрабатывается в <a target="_blank" href="//mymediapro.ru" title="Создание сайтов">Mymediapro.ru</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
		<?php wp_footer(); 
			$fscripts = get_option('artwebwpte_fscripts');
			if ($fscripts) echo stripslashes($fscripts); 
		?>			
		<?php wp_footer(); ?>
    </body>
</html>
