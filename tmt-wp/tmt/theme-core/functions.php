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
	
	// Disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		if(post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
}
add_action('admin_init', 'df_disable_comments_post_types_support');

// Close comments on the front-end
function df_disable_comments_status() {
	return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);

// Hide existing comments
function df_disable_comments_hide_existing_comments($comments) {
	$comments = array();
	return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);

// Remove comments page in menu
function df_disable_comments_admin_menu() {
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');

// Redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect() {
	global $pagenow;
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url()); exit;
	}
}
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');

// Remove comments metabox from dashboard
function df_disable_comments_dashboard() {
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'df_disable_comments_dashboard');

// Remove comments links from admin bar
function df_disable_comments_admin_bar() {
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
}
add_action('init', 'df_disable_comments_admin_bar');

function category_label() {
  global $wp_taxonomies;
  $labels = &$wp_taxonomies['category']->labels;
  $labels->name = __('Сегменты');
  $labels->singular_name = __('Сегменты');
  $labels->search_items = __('Искать');
  $labels->all_items = __('Все');
  $labels->parent_item = __('Родительский сегмент');
  $labels->parent_item_colon = __('Родительский сегмент:');
  $labels->edit_item = __('Изменить');
  $labels->view_item = __('Посмотреть');
  $labels->update_item = __('Обновить');
  $labels->add_new_item = __('Добавить');
  $labels->new_item_name = __('Новый');
}
add_action( 'init', 'category_label' );

function tag_label() {
  global $wp_taxonomies;
  $labels = &$wp_taxonomies['post_tag']->labels;
  $labels->name = __('Категории');
  $labels->singular_name = __('Категории');
  $labels->search_items = __('Искать');
  $labels->all_items = __('Все');
  $labels->parent_item = __('Родительская категория');
  $labels->parent_item_colon = __('Родительская категория:');
  $labels->edit_item = __('Изменить');
  $labels->view_item = __('Посмотреть');
  $labels->update_item = __('Обновить');
  $labels->add_new_item = __('Добавить');
  $labels->new_item_name = __('Новая');
}
add_action( 'init', 'tag_label' );

function edit_admin_menus() {
    global $menu;
    global $submenu;
    $submenu["edit.php"][15][0] = 'Сегменты';
	$submenu["edit.php"][16][0] = 'Категории';
}
add_action( 'admin_menu', 'edit_admin_menus' );

//Удаляем стандартный метабокс с тегами
function remove_page_excerpt_field() {
	remove_meta_box( 'tagsdiv-post_tag' , 'post' , 'normal' ); 
}
add_action( 'admin_menu' , 'remove_page_excerpt_field' );


new Tag_Checklist( 'post_tag', 'post' ); 
 
/**
 * Use checkbox term selection for non-hierarchical taxonomies
 *
 * @author Hugh Lashbrooke
 * @link http://www.hughlashbrooke.com/wordpress-use-checkbox-term-selection-for-non-hierarchical-taxonomies/
 */
class Tag_Checklist {
 
    private $taxonomy;
  private $post_type;
 
	function __construct( $taxonomy, $post_type ) {
		$this->taxonomy = $taxonomy;
		$this->post_type = $post_type;
 
		// Remove default taxonomy meta box
		add_action( 'admin_menu', array( $this, 'remove_meta_box' ) );
 
		// Add new meta box
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
 
		// Handle Ajax call for adding new term
		add_action( 'wp_ajax_add-' . $this->taxonomy , '_wp_ajax_add_non_hierarchical_term' );
 
	}
 
	/**
	 * Remove default meta box
	 * @return void
	 */
	public function remove_meta_box() {
		remove_meta_box('tagsdiv-' . $this->taxonomy, $this->post_type, 'normal');
	}
 
	/**
	 * Add new metabox
	 * @return void
	 */
	public function add_meta_box() {
		$tax = get_taxonomy( $this->taxonomy );
		add_meta_box( 'taglist-' . $this->taxonomy, $tax->labels->name, array( $this, 'metabox_content' ), $this->post_type, 'side', 'core' );
	}
 
	/**
	 * Generate metabox content
	 * @param  obj $post Post object
	 * @return void
	 */
	public function metabox_content( $post ) {
        $taxonomy = $this->taxonomy;
        $tax = get_taxonomy( $taxonomy );
		?>
		<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">
 
			<ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">
				<li class="tabs"><a href="#<?php echo $taxonomy; ?>-all"><?php echo $tax->labels->all_items; ?></a></li>
				<li class="hide-if-no-js"><a href="#<?php echo $taxonomy; ?>-pop"><?php _e( 'Most Used' ); ?></a></li>
			</ul>
 
			<div id="<?php echo $taxonomy; ?>-pop" class="tabs-panel" style="display: none;">
				<ul id="<?php echo $taxonomy; ?>checklist-pop" class="categorychecklist form-no-clear" >
					<?php $popular_ids = wp_popular_terms_checklist( $taxonomy ); ?>
				</ul>
			</div>
 
		    <div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
		    	<input type="hidden" name="tax_input[<?php echo $taxonomy; ?>][]" value="0" />
				<?php
				if( class_exists( 'Walker_Tag_Checklist' ) ) {
					$walker = new Walker_Tag_Checklist;
				}
				?>
		       <ul id="<?php echo $taxonomy; ?>checklist" data-wp-lists="list:<?php echo $taxonomy; ?>" class="categorychecklist form-no-clear">
					<?php wp_terms_checklist($post->ID, array( 'taxonomy' => $taxonomy, 'popular_cats' => $popular_ids , 'walker' => $walker ) ) ?>
				</ul>
		   </div>
			<!--<?php if ( current_user_can($tax->cap->edit_terms) ) : ?>
				<div id="<?php echo $taxonomy; ?>-adder" class="wp-hidden-children">
					<h4>
						<a id="<?php echo $taxonomy; ?>-add-toggle" href="#<?php echo $taxonomy; ?>-add" class="hide-if-no-js">
							<?php
								/* translators: %s: add new taxonomy label */
								printf( __( '+ %s' ), $tax->labels->add_new_item );
							?>
						</a>
					</h4>
					<p id="<?php echo $taxonomy; ?>-add" class="category-add wp-hidden-child">
						<label class="screen-reader-text" for="new<?php echo $taxonomy; ?>"><?php echo $tax->labels->add_new_item; ?></label>
						<input type="text" name="new<?php echo $taxonomy; ?>" id="new<?php echo $taxonomy; ?>" class="form-required form-input-tip" value="<?php echo esc_attr( $tax->labels->new_item_name ); ?>" aria-required="true"/>
						<input type="button" id="<?php echo $taxonomy; ?>-add-submit" data-wp-lists="add:<?php echo $taxonomy ?>checklist:<?php echo $taxonomy ?>-add" class="button category-add-submit" value="<?php echo esc_attr( $tax->labels->add_new_item ); ?>" />
						<?php wp_nonce_field( 'add-'.$taxonomy, '_ajax_nonce-add-'.$taxonomy, false ); ?>
						<span id="<?php echo $taxonomy; ?>-ajax-response"></span>
					</p>
				</div>
			<?php endif; ?>-->
		</div>
		<?php
	}
}
 
if( ! function_exists( '_wp_ajax_add_non_hierarchical_term' ) ) {
    /**
   * Mod of _wp_ajax_add_hierarchical_term to handle non-hierarchical taxonomies
	 * @return void
	 */
	function _wp_ajax_add_non_hierarchical_term() {
		$action = $_POST['action'];
		$taxonomy = get_taxonomy( substr( $action, 4 ) );
		check_ajax_referer( $action, '_ajax_nonce-add-' . $taxonomy->name );
		if ( !current_user_can( $taxonomy->cap->edit_terms ) )
			wp_die( -1 );
		$names = explode( ',', $_POST['new'.$taxonomy->name] );
		$parent = 0;
		if ( $taxonomy->name == 'category' )
			$post_category = isset( $_POST['post_category'] ) ? (array) $_POST['post_category'] : array();
		else
			$post_category = ( isset( $_POST['tax_input'] ) && isset( $_POST['tax_input'][$taxonomy->name] ) ) ? (array) $_POST['tax_input'][$taxonomy->name] : array();
		$checked_categories = array_map( 'absint', (array) $post_category );
		$popular_ids = wp_popular_terms_checklist( $taxonomy->name, 0, 10, false );
 
		// Set up custom walker
		$walker = false;
		if( class_exists( 'Walker_Tag_Checklist' ) ) {
			$walker = new Walker_Tag_Checklist;
		}
 
		foreach ( $names as $tax_name ) {
			$tax_name = trim( $tax_name );
			$category_nicename = sanitize_title( $tax_name );
			if ( '' === $category_nicename )
				continue;
			if ( ! $cat_id = term_exists( $tax_name, $taxonomy->name, $parent ) )
				$cat_id = wp_insert_term( $tax_name, $taxonomy->name, array( 'parent' => $parent ) );
			if ( is_wp_error( $cat_id ) )
				continue;
			else if ( is_array( $cat_id ) )
				$cat_id = $cat_id['term_id'];
			$checked_categories[] = $cat_id;
			if ( $parent ) // Do these all at once in a second
				continue;
			ob_start();
			$args = array(
				'taxonomy' => $taxonomy->name,
				'selected_cats' => $checked_categories,
				'popular_cats' => $popular_ids,
				'checked_ontop' => true
			);
			if( $walker ) {
				$args['walker'] = $walker;
			}
			wp_terms_checklist( 0, $args );
			$data = ob_get_contents();
			ob_end_clean();
			$add = array(
				'what' => $taxonomy->name,
				'id' => $cat_id,
				'data' => str_replace( array("\n", "\t"), '', $data ),
				'position' => -1
			);
			
		}

		$x = new WP_Ajax_Response( $add );
		$x->send();
	}
}

/**
 * Mod of WP's Walker_Category_Checklist class
 */
class Walker_Tag_Checklist extends Walker {
    var $tree_type = 'tag';
  var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');
 
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent<ul class='children'>\n";
	}
 
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}
 
	function start_el( &$output, $tax_term, $depth, $args, $id = 0 ) {
		extract($args);
		if ( empty($taxonomy) )
			$taxonomy = 'tag';
 
		if ( $taxonomy == 'tag' )
			$name = 'post_tag';
		else
			$name = 'tax_input['.$taxonomy.']';
 
		$class = in_array( $tax_term->term_id, $popular_cats ) ? ' class="popular-category"' : '';
		$output .= "\n<li id='{$taxonomy}-{$tax_term->term_id}'$class>" . '<label class="selectit"><input value="' . $tax_term->slug . '" type="checkbox" name="'.$name.'[]" id="in-'.$taxonomy.'-' . $tax_term->term_id . '"' . checked( in_array( $tax_term->term_id, $selected_cats ), true, false ) . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' . esc_html( apply_filters('the_category', $tax_term->name )) . '</label>';
	}
 
	function end_el( &$output, $tax_term, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}

/** Удаляем все стандартные виджеты **/
unregister_widget('WP_Widget_Text');
 
/** Удаляем выборочные виджеты **/
function unregister_default_widgets() {
     unregister_widget('WP_Widget_Pages');
     unregister_widget('WP_Widget_Calendar');
     unregister_widget('WP_Widget_Archives');
     unregister_widget('WP_Widget_Links');
     unregister_widget('WP_Widget_Meta');
     unregister_widget('WP_Widget_Search');
     unregister_widget('WP_Widget_Text');
     unregister_widget('WP_Widget_Categories');
     unregister_widget('WP_Widget_Recent_Posts');
     unregister_widget('WP_Widget_Recent_Comments');
     unregister_widget('WP_Widget_RSS');
     unregister_widget('WP_Widget_Tag_Cloud');
     unregister_widget('Twenty_Eleven_Ephemera_Widget');
 }
 add_action('widgets_init', 'unregister_default_widgets', 11);
?>