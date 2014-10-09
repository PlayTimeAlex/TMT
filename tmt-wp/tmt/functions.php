<?php
require_once ('theme-core/functions.php');
require_once ('theme-core/admin-options.php');
require_once ('theme-core/admin-interface.php');
require_once ('theme-core/sidebars-and-widgets.php');

function mytheme_add_admin() {
	global $themename, $shortname, $options;
	if ( isset($_GET['page']) AND $_GET['page'] == basename(__FILE__) ) {
		if ( 'save' == $_REQUEST['action'] ) {
				foreach ($options as $value) {
					update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
				foreach ($options as $value) {

	if( isset( $_REQUEST[ $value['id'] ] )  && $value['type'] != 'image') { 
		if($value['id'] != $shortname."_sidebar0")
		{
			//if sortable type
			if($value['type'] == 'sortable')
			{
				$sortable_array = serialize($_REQUEST[ $value['id'] ]);
				
				$sortable_data = $_REQUEST[ $value['id'].'_sort_data'];
				$sortable_data_arr = explode(',', $sortable_data);
				$new_sortable_data = array();
				
				foreach($sortable_data_arr as $key => $sortable_data_item)
				{
					$sortable_data_item_arr = explode('_', $sortable_data_item);
					
					if(isset($sortable_data_item_arr[0]))
					{
						$new_sortable_data[] = $sortable_data_item_arr[0];
					}
				}
				
				update_option( $value['id'], $sortable_array );
				update_option( $value['id'].'_sort_data', serialize($new_sortable_data) );
			}
			else
			{
				update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
			}
		}
		elseif(isset($_REQUEST[ $value['id'] ]) && !empty($_REQUEST[ $value['id'] ]))
		{
			//get last sidebar serialize array
			$current_sidebar = get_option($shortname."_sidebar");
			$current_sidebar[ $_REQUEST[ $value['id'] ] ] = $_REQUEST[ $value['id'] ];

			update_option( $shortname."_sidebar", $current_sidebar );
		}
	} 
	else if(isset($_FILES[ $value['id'] ])) {
	
		if(is_writable(TEMPLATEPATH.'/cache') && !empty($_FILES[$value['id']]['name']))
		{
		    $current_time = time();
		    $target = TEMPLATEPATH.'/cache/'.$current_time.'_'.basename( $_FILES[$value['id']]['name']);
		    $current_file = TEMPLATEPATH.'/cache/'.get_option($value['id']);

		    if(move_uploaded_file($_FILES[$value['id']]['tmp_name'], $target)) 
		    {
		    	if(file_exists($current_file) && !is_dir($current_file))
		    	{
			    	unlink($current_file);
			    }
		     	update_option( $value['id'], $current_time.'_'.basename( $_FILES[$value['id']]['name'])  );
		    }
		}
	}
	else 
	{ 
		delete_option( $value['id'] );
	} 
}
				foreach ($options as $value) {
					if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
				header("Location: themes.php?page=functions.php&saved=true");
				die;
		} else if( 'reset' == $_REQUEST['action'] ) {
			foreach ($options as $value) {
				delete_option( $value['id'] ); }
			header("Location: themes.php?page=functions.php&reset=true");
			die;
		}
	}
	add_menu_page($themename." Options", $themename, 'administrator', basename(__FILE__), 'mytheme_add_admin');
	add_submenu_page('functions.php', $themename." Options", $themename, 'edit_themes', basename(__FILE__), 'mytheme_admin');
}
add_action('admin_menu', 'mytheme_add_admin');


//include editor plugin
	if(!function_exists('artweb_mce_settings_adjust_body_class'))
	{
		function artweb_mce_settings_adjust_body_class( $initArray )
		{
			$initArray['body_class'] = 'post_content';
			return $initArray;
		}
	}
	add_filter( 'tiny_mce_before_init', 'artweb_mce_settings_adjust_body_class' );
	
	function artweb_add_tinymce_button($buttons)
	{
	    array_push($buttons, "separator", "artweb");
	    return $buttons;   
	}
	function artweb_register_shortcode_overlay($plugin_array)
	{
	    $url = get_stylesheet_directory_uri().'/plugins/tinyeditor/editor_plugin.js';
	    $plugin_array["artweb"] = $url;
	    return $plugin_array;   
	}
	add_editor_style('css/editor-style.css');
	add_filter('mce_external_plugins', "artweb_register_shortcode_overlay");
	add_filter('mce_buttons', 'artweb_add_tinymce_button', 0);
?>