<?php 

$themename  = "ТМТ консалтинг";
$shortname  = "artwebwpte";
$theme_dir = get_bloginfo('template_directory');
		
/* parsed shortcodes in widget */
add_filter('widget_text', 'do_shortcode');

// Автоматическая вставка параграфов выкл
//remove_filter('the_content', 'wpautop');
//remove_filter ('the_content',  'wptexturize');

/* Add Javascript For Admin Theme */
function artwebwpte_admin_add_javascripts() {
	global $theme_dir;
		//wp_enqueue_script('jquery.tools.min', $theme_dir.'/js/tabs/jquery.tools.min.js', array('jquery'), '0.5');
		//wp_enqueue_script('jquery-ui-1.8.10.custom.min', $theme_dir.'/js/jquery-ui/js/jquery-ui-1.8.10.custom.min.js', array('jquery'), '0.5');
		wp_enqueue_script('j_script', $theme_dir.'/js/adminjs/j_script.js', array('jquery'), '0.5');
		wp_enqueue_script('jslider_depend', $theme_dir.'/js/adminjs/jquery.dependClass.js', false, "1.0");
		wp_enqueue_script('jslider', $theme_dir.'/js/adminjs/jquery.slider-min.js', false, "1.0");
		wp_enqueue_script("iphone_checkboxes", $theme_dir.'/js/adminjs/iphone-style-checkboxes.js', false, "1.0");
}
if (is_admin()) {
  add_action( 'wp_print_scripts', 'artwebwpte_admin_add_javascripts' );
}

//post and page Thumbnail
		add_theme_support( 'post-thumbnails' );
		
/* Register Nav Menu Features For Wordpress 3.0 */
register_nav_menus( array(
	'topnav' => __( 'Основное меню')
) );

function artwebwpte_content($content) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}
	return $new_content;
}

function new_excerpt_more($more) {
	return '';
}
add_filter('excerpt_more', 'new_excerpt_more');

function eg_add_rewrite_rules() {
    global $wp_rewrite;
 
    $new_rules = array(
        '(cat)/(.+?)/(tag)/(.+?)/?$' => 'index.php?' . $wp_rewrite->preg_index(1) . '=' . $wp_rewrite->preg_index(2) . '&' . $wp_rewrite->preg_index(3) . '=' . $wp_rewrite->preg_index(4),
        '(cat)/(.+)/?$' => 'index.php?' . $wp_rewrite->preg_index(1) . '=' . $wp_rewrite->preg_index(2)
    );
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
add_action( 'generate_rewrite_rules', 'eg_add_rewrite_rules' );

function get_category_tags($args) {
	global $wpdb;
	$tags = $wpdb->get_results
	("
		SELECT DISTINCT terms2.term_id as tag_id, terms2.name as tag_name, null as tag_link
		FROM
			".$wpdb->prefix."posts as p1
			LEFT JOIN ".$wpdb->prefix."term_relationships as r1 ON p1.ID = r1.object_ID
			LEFT JOIN ".$wpdb->prefix."term_taxonomy as t1 ON r1.term_taxonomy_id = t1.term_taxonomy_id
			LEFT JOIN ".$wpdb->prefix."terms as terms1 ON t1.term_id = terms1.term_id,

			wp_posts as p2
			LEFT JOIN ".$wpdb->prefix."term_relationships as r2 ON p2.ID = r2.object_ID
			LEFT JOIN ".$wpdb->prefix."term_taxonomy as t2 ON r2.term_taxonomy_id = t2.term_taxonomy_id
			LEFT JOIN ".$wpdb->prefix."terms as terms2 ON t2.term_id = terms2.term_id
		WHERE
			t1.taxonomy = 'category' AND p1.post_status = 'publish' AND terms1.term_id IN (".$args['categories'].") AND
			t2.taxonomy = 'post_tag' AND p2.post_status = 'publish'
			AND p1.ID = p2.ID
		ORDER by tag_name
	");
	$count = 0;
	foreach ($tags as $tag) {
		$tags[$count]->tag_link = get_tag_link($tag->tag_id);
		$count++;
	}
	return $tags;
}


//buttons tinymce
function enable_more_buttons($buttons) {
	$buttons[] = 'hr';
	$buttons[] = 'sub';
	$buttons[] = 'sup';
	$buttons[] = 'fontselect';
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'cleanup';
	$buttons[] = 'styleselect';
	return $buttons;
}
add_filter("mce_buttons_3", "enable_more_buttons");

/*
* Получаем только ссылку на аватар
*/
function get_avatar_url($user_id, $size) {
    $avatar_url = get_avatar($user_id, $size);
    $regex = '/(^.*src="|" w.*$)/';
    return preg_replace($regex, '', $avatar_url);
}
//сообщение об ошибке ввода логина или пароля
function autorization_secure() {
  return "Something worng, username or password!";
}
	add_filter('login_errors', 'autorization_secure');

//hide version
	remove_action('wp_head', 'wp_generator');
	/*
class ik_walker extends Walker_Nav_Menu{		
	//start of the sub menu wrap
	function start_lvl(&$output, $depth) {
		$output .= '<div class="b-header__subNav">
						<div class="container">
							<div class="row-fluid">
								<div class="span11">
									<ul class="b-header__subNavlist">';
	}
 
	//end of the sub menu wrap
	function end_lvl(&$output, $depth) {
		$output .= '
						</ul>
					</div>
				</div>
			</div>
		</div>';
	}
 
	//add the description to the menu item output
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
 
		$class_names = $value = '';
 
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
 
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
 
		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
 
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
 
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		if(strlen($item->description)>2){ $item_output .= '<br /><span class="sub">' . $item->description . '</span>'; }
		$item_output .= '</a>';
		$item_output .= $args->after;
 
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}	
	*/
?>