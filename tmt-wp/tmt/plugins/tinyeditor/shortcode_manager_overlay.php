<?php

	$wp_load_location_array = array();
	$wp_load_location_array[] = "../../../../../../../wp-load.php";
	$wp_load_location_array[] = "../../../../../../wp-load.php";
	$wp_load_location_array[] = "../../../../../wp-load.php";
	$wp_load_location_array[] = "../../../../wp-load.php";
	$wp_load_location_array[] = "../../../wp-load.php";
	$wp_load_location_array[] = "../../wp-load.php";
	$wp_load_location_array[] = "../wp-load.php";
	
	$wp_load_file_found = false;
	
	foreach($wp_load_location_array as $wp_load_location)
	{
		if(file_exists($wp_load_location))
		{
    		require_once($wp_load_location);
    		$wp_load_file_found = true;
		}
	}
	
	//Uncomment the following 3 lines line if you need to manually set the location of your wp-load.php file
	//$wp_load_location = "PATH/TO/YOUR/WP-LOAD.PHP";
	//require_once($wp_load_location);
	//$wp_load_file_found = true;
	
	if(!$wp_load_file_found)
	{
		//Buggerations - Can't find the wp-load.php file. If this happens, comment out lines 3 - 30 of this file. Then, 
		//you'll need to add: require_once('LOCATION TO YOUR WP-LOAD.PHP FILE')
		wp_die('<h3>Unable to find your wp-load.php file</h3><p>It looks like you have a cunning WordPress setup and, unfortunately, I can not find your wp-load.php file.</p><p>To fix this, please edit the "add_shortcode.php" file which you will find in this theme\'s "/inc/js" folder. Uncomment lines 24, 25 and 26 and edit lines 24 with the location of you wp-load.php file.</p><p>Finally, save the file, then try again. Then, by magic, the world will be a better place. And this shortcode manager will work.</p>');
	}
	

?>

<style type="text/css">
	html
	{
		min-height: 571px;
	}
	
	body
	{
		margin: 0; padding: 15px; background-color: #F1F1F1;color: #999;font: 11px "Lucida Grande", "Helvetica Neue", Helvetica, Arial, sans-serif; line-height: 1.5;
	}
	
	a.cancel-button
	{
		-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;text-decoration: none;display: inline-block;padding: 4px 15px;border: 1px solid rgb(213,213,213);border-bottom-color: rgb(230,226,226);color: #aeaeae;text-shadow: 0 1px 0 white;background: rgb(232,232,232);background: -webkit-gradient(linear,left top,left bottom,color-stop(.2, rgb(243,243,243)),color-stop(1, rgb(230,230,230)));background: -moz-linear-gradient(center top,rgb(243,243,243) 20%,rgb(230,230,230) 100%);-webkit-box-shadow: inset 0 1px 0 hsla(0,100%,100%,.5), inset 0 0 2px hsla(0,100%,100%,.1),0 1px 0 hsla(0, 100%, 100%, .7);-moz-box-shadow: inset 0 1px 0 hsla(0,100%,100%,.5),inset 0 0 2px hsla(0,100%,100%,.1),0 1px 0 hsla(0, 100%, 100%, .7);box-shadow: inset 0 1px 0 hsla(0,100%,100%,.5),inset 0 0 2px hsla(0,100%,100%,.1),0 1px 0 hsla(0, 100%, 100%, .7);-webkit-background-clip: padding-box;
	}
	
	a.cancel-button:hover
	{
		border: 1px solid rgb(173,173,173);
	}
	
	input.button-primary, a.group_select
	{
		display: inline-block; padding: 4px 15px;border: 1px solid #4081af;border-bottom-color: #20559a;color: white;text-align: center;text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);text-decoration: none;-webkit-border-radius: 15px;-moz-border-radius: 15px;border-radius: 15px;background: rgb(35,127,215);background: -webkit-gradient(linear,left top,left bottom,color-stop(.2, rgb(82,168,232)),color-stop(1, rgb(46,118,207)));background: -moz-linear-gradient(center top,rgb(82,168,232) 20%,rgb(46,118,207) 100%);-webkit-box-shadow: inset 0 1px 0 hsla(0,100%,100%,.3), inset 0 0 2px hsla(0,100%,100%,.3), 0 1px 2px hsla(0, 0%, 0%, .29);-moz-box-shadow: inset 0 1px 0 hsla(0,100%,100%,.3), inset 0 0 2px hsla(0,100%,100%,.3), 0 1px 2px hsla(0, 0%, 0%, .29);box-shadow: inset 0 1px 0 hsla(0,100%,100%,.3), inset 0 0 2px hsla(0,100%,100%,.3), 0 1px 2px hsla(0, 0%, 0%, .29);-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;
	}
	
	input.button-primary:hover, a.group_select:hover
	{
	    background: rgb(0,115,210);
	    background: -webkit-gradient(
	        linear,
	        left top,
	        left bottom,
	        color-stop(.2, rgb(62,158,229)),
	        color-stop(1, rgb(22,102,202))
	    );
	    background: -moz-linear-gradient(
	        center top,
	        rgb(62,158,229) 20%,
	        rgb(22,102,202) 100%
	    );
	    
	    -webkit-background-clip: padding-box;
	}
	
	input.button-primary:active, a.group_select:active
	{
		border-color: #20559a;
    
	    -webkit-box-shadow: inset 0 0 7px hsla(0,0%,0%,.3),
	                        0 1px 0 hsla(0, 100%, 100%, 1);
	    -moz-box-shadow: inset 0 0 7px hsla(0,0%,0%,.3),
	                    0 1px 0 hsla(0, 100%, 100%, 1);
	    box-shadow: inset 0 0 7px hsla(0,0%,0%,.3),
	                0 1px 0 hsla(0, 100%, 100%, 1);
	        
	    -webkit-background-clip: padding-box;
	}
	
	a.disabled
	{
		-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;text-decoration: none;display: inline-block;padding: 4px 15px;border: 1px solid rgb(213,213,213) !important;border-bottom-color: rgb(230,226,226) !important;color: #aeaeae !important;text-shadow: 0 1px 0 white !important;background: rgb(232,232,232) !important;background: -webkit-gradient(linear,left top,left bottom,color-stop(.2, rgb(243,243,243)),color-stop(1, rgb(230,230,230))) !important;background: -moz-linear-gradient(center top,rgb(243,243,243) 20%,rgb(230,230,230) 100%) !important;-webkit-box-shadow: inset 0 1px 0 hsla(0,100%,100%,.5), inset 0 0 2px hsla(0,100%,100%,.1),0 1px 0 hsla(0, 100%, 100%, .7) !important;-moz-box-shadow: inset 0 1px 0 hsla(0,100%,100%,.5),inset 0 0 2px hsla(0,100%,100%,.1),0 1px 0 hsla(0, 100%, 100%, .7) !important;box-shadow: inset 0 1px 0 hsla(0,100%,100%,.5),inset 0 0 2px hsla(0,100%,100%,.1),0 1px 0 hsla(0, 100%, 100%, .7) !important;-webkit-background-clip: padding-box !important;
	}
	
	div.wrap
	{
		overflow: hidden;
		height: 610px;
	}
	
	ul
	{
		list-style-type: none;
		list-style-position: inside;
		margin: 0;
		padding: 0;
	}
	
	ul li
	{
		float: left;
		margin-right: 3%;
	}
	
	div.as-results ul li
	{
		float: none;
	}
	
	#vertical_tabs, #horizontal_tabs, #accordion, #friendly_slider
	{
		position: relative;
	}
	
	
	
	#tab3 ul li
	{
		overflow: hidden;
		margin-bottom: 20px;
	}
	
		.chosen_shortcode_options select
		{
			width: 100px !important;
		}
		
		.chosen_shortcode_options label
		{
			display: block;
			float: left;
			width: 150px;
		}
	
	
	/* Tabs Styling */
	ul.tabs {
		margin: 0;
		padding: 0;
		float: left;
		list-style: none;
		height: 32px;
		border-bottom: 1px solid #999;
		border-left: 1px solid #999;
		width: 640px;
	}
	ul.tabs li {
		float: left;
		margin: 0;
		padding: 0;
		height: 31px;
		line-height: 31px;
		border: 1px solid #999;
		border-left: none;
		margin-bottom: -1px;
		background: #e0e0e0;
		overflow: hidden;
		position: relative;
		width: auto;
	}
	ul.tabs li a {
		text-decoration: none;
		color: #000;
		display: block;
		font-size: 1.2em;
		padding: 0 10px;
		border: 1px solid #fff;
		outline: none;
	}
	ul.tabs li a:hover {
		background: #ccc;
	}	
	html ul.tabs li.active, html ul.tabs li.active a:hover  {
		background: #fff;
		border-bottom: 1px solid #fff;
	}
	
	li.selected_items
	{
		float: right !important;
		right: 1px;
		border-left: 1px solid #999 !important;
		border-right: 1px solid #999 !important;
	}
	
	li.selected_items a
	{
		padding-right: 40px !important;
	}
	
	li.selected_items span
	{
		 -moz-border-radius: 5px 5px 5px 5px;
		 -webkit-border-radius: 5px 5px 5px 5px;
		 border-radius: 5px 5px 5px 5px;
	    background: none repeat scroll 0 0 #222;
	    color: white;
	    display: block;
	    font-size: 9px;
	    height: 16px;
	    line-height: 16px;
	    padding: 1px 3px;
	    position: absolute;
	    right: 10px;
	    text-align: center;
	    text-shadow: 0 1px 0 #555555;
	    top: 7px;
	    width: 16px;
	}
	
	.tab_container
	{
		border: 1px solid #999;
		border-top: none;
		clear: both;
		float: left; 
		width: 578px;
		height: 539px;
		background: #fff;
		-moz-border-radius-bottomright: 5px;
		-khtml-border-radius-bottomright: 5px;
		-webkit-border-bottom-right-radius: 5px;
		-moz-border-radius-bottomleft: 5px;
		-khtml-border-radius-bottomleft: 5px;
		-webkit-border-bottom-left-radius: 5px;
		overflow: auto;
	}
	.tab_content
	{
		padding: 0 20px;
		overflow: hidden;
	}
	
	.tab_content .list_of_shortcodes
	{
		width: 28%;
		margin-right: 2%;
		padding: 2%;
		float: left;
		margin-top: 25px;
	}
	
		.tab_content .list_of_shortcodes ol
		{
			margin: 0;
			padding: 0;
			list-style-type: none;
		}
		
			.tab_content .list_of_shortcodes ol li a
			{
				text-decoration: none;
				color: rgb(120,120,120);
				display: block;
				margin-bottom: 10px;
				
			}
			
	p.note
	{
		padding: 10px 0;
		border-top: 1px solid rgb(230,230,230);
		border-bottom: 1px solid rgb(230,230,230);
		margin-top: 40px;
	}
	
	p.main_note
	{
		padding:15px;
		margin: 30px 0;
		border: 1px solid rgb(255,255,255);
		background: rgb(250,250,250);
	}
	
	.tab_content .chosen_shortcode_options
	{
		width: 60%;
		float: left;
		padding: 2%;
		min-height: 460px;
		background: rgb(245,245,245);
		border: 1px solid rgb(200,200,200);
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border-radius: 5px;
		margin-top: 25px;
		color: rgb(40,40,40);
	}
	
	
	#inner_wrap
	{
		overflow: hidden;
	}
	
	#insert_and_cancel
	{
		padding: 10px 0 0;
	}
	
	/* Column Icons */
	
	h3
	{
		font: italic normal normal 18px/24px Georgia,"Times New Roman","Bitstream Charter",Times,serif;
		margin: 0 0 10px 0;
		padding: 0;
		text-shadow: rgba(255, 255, 255, 1) 0 1px 0;
		color: #464646;
	}
	
	input[type="text"]
	{
		border: 1px solid #DFDFDF;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
		color: #666;
		font-size: 12px;
		margin: 4px 0;
		padding: 3px;
		line-height: 15px;
		width: 250px;
		display: block;
	}
	
	hr
	{
		margin: 15px 0;
		border: 1px dotted #C8C8C8;
		color: white;
		line-height: 1;
	}
	
	.columns_generator_list{
		width:100%;
		overflow:hidden;
	}
	
	.columns_generator_list li{
		float:none;
	}
	
</style>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

<script type="text/javascript">
	
	function fg_create_shortcode(){
			
			var chosen_shortcode_type = jQuery("a.chosen_type").attr("title");
		
			
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */
						
			if(chosen_shortcode_type == "columns_generator"){
			
				//2 elements per tab, as well as the width
				var number_of_columns = jQuery('.columns_generator_list li').length;
				var column = '';
				var column_width = '';
				
				if(number_of_columns > 0){
				
					for(i=1;i<=number_of_columns;i++){
						
						column_width = jQuery('.columns_generator_list li#column-'+i+' .column_width').val();
						column += '<div class="span'+column_width+'"><p>Контент колонки</p></div>';

					}
				
					self.parent.send_to_editor('<div class="row">'+column+'</div><p>Остальной контент</p>');

				
				}
			
			}
			
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */
			
			if(chosen_shortcode_type == "buttons"){
			
				var button_style = jQuery("#button_style option:selected").attr("value");
				var button_text = jQuery("#button_text").attr("value");
				var button_link = jQuery("#button_link").attr("value");
				
				self.parent.send_to_editor("<a href='"+button_link+"' title='"+button_text+"' class='button "+button_style+"'>"+ button_text +"</a>");
			
			}			
			
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */
		
	}/* fg_create_shortcode() */
	
	jQuery(document).ready(function() {
 
		//Default Action
		jQuery(".tab_content").hide(); //Hide all content
		jQuery("ul.tabs li:first").addClass("active").show(); //Activate first tab
		jQuery(".tab_content:first").show(); //Show first tab content
		
		//On Click Event
		jQuery("ul.tabs li").click(function() {
			jQuery("ul.tabs li").removeClass("active"); //Remove any "active" class
			jQuery(this).addClass("active"); //Add "active" class to selected tab
			jQuery(".tab_content").hide(); //Hide all tab content
			var activeTab = jQuery(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
			jQuery(activeTab).fadeIn(); //Fade in the active content
			return false;
		});
		
		/* End tabs behaviour */
		
		/* Shortcode Options */
		jQuery(".chosen_shortcode_options div").hide();
		
		jQuery("a.shortcode_choice").click(function(){
		
			jQuery("a.shortcode_choice").removeClass("chosen_type");
			jQuery(this).addClass("chosen_type");
		
			jQuery(".chosen_shortcode_options div").removeClass("active_shortcode_options").hide();
			var tab_name = jQuery(this).attr("href");
			jQuery(tab_name).show().addClass("active_shortcode_options");
		
		});
		
		jQuery('#add_column').click(function(){
				
			//We're adding another vertical tab. First count the number we have already
			var number_of_tabs = jQuery('.columns_generator_list li').length;
			var one_more = number_of_tabs+1;
			
			//Add the markup for another tab
			jQuery('.columns_generator_list').append("<li id='column-"+ one_more +"'><p><strong>Колонка "+ one_more +"</strong></p><p>Ширина колонки</p><select class='column_width'><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option>								</select></li>");
			
		});	
	 
	});
	
	function fg_remove_this_tab(which){
	
		jQuery(which).parent().fadeOut('slow', function(){
			jQuery(which).parent().remove();
		});
	
	}
	
	
</script>


<div id="select_form">
    
    <div class="wrap">
    
    	<div id="inner_wrap">
    	
    		<ul class="tabs"> 
				<li><a href="#tab2"><?php _e("Колонки", "artweb"); ?></a></li> 				
		    </ul> 
		    
		    
		    <div class="tab_container">
		    
		    	<div class="tab_content" id="tab2">
		    		
		    		<div class="list_of_shortcodes">
		    		
		    			<ol>
		    				<li>
		    					<a class="shortcode_choice" href="#columns_generator" title="columns_generator">Колонки</a>
		    				</li>						
		    			</ol>
		    		
		    		</div><!-- .list_of_shortcodes -->
		    		
		    		<div class="chosen_shortcode_options">
					
		    			<div id="columns_generator">
							
		    				<h3>Генератор колонок</h3>
							<ul class='columns_generator_list'>
								<li id="column-1">
									<p><strong>Колонка 1</strong></p>
									<p>Ширина колонки</p>
									<select class="column_width">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>			
										<option value="10">11</option>	
										<option value="10">12</option>											
									</select>
								</li>
							</ul>
							<p>
								<input type="button" id="add_column" class="button-primary" value="+ <?php _e("Добавить колонку", "artweb"); ?>" />
							</p>
							<p class='note'>NOTE: Ширина всех колонок не должна превышать 12</p>
		    			</div>				
		    		
		    		</div><!-- .chosen_shortcode_options -->
		    		
		    	</div><!-- .tab_content -->
		    </div><!-- .tab_container -->
    	
    	</div><!-- #inner_wrap  -->
    	
	    <div id="insert_and_cancel">
                
            <div style="float: left;">
            	<input type="button" class="button-primary" value="Insert shortcode" onclick="fg_create_shortcode();"  />
            </div>
            
            <div style="float: right;">
            	<a class="cancel-button" href="#" onclick="self.parent.tb_remove(); return false;">Cancel</a>
            </div>
            
        </div>
    
        
    </div><!-- .wrap -->
    
</div><!-- #select_form -->