<?php
/* Register Sidebar */
if ( function_exists('register_sidebar') ){
	register_sidebar(array('name'=>'Левый сайдбар',
	'id' => 'left_sidebar',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>'
	));

}
function categoryList($categories, $current, $parent = 0, $level = ""){
	if ($parent != 0) $level .= '- ';
	foreach ($categories as $cat) {
		if ($cat->parent != $parent) continue;
		$selected = in_array( $cat->term_id, $current) ? 'selected="selected"' : '';
		echo '<option value="'.$cat->term_id.'" '.$selected.'>'.$level.''.$cat->name.'</option>';
		categoryList($categories, $current, $cat->term_id, $level);
	}	
}  

/* Виджет категории */
class Cat_Widget extends WP_Widget {
	  function Cat_Widget() {
		$widgets_opt = array('description'=>'Выводит подрубрики выбраной рубрики');
		parent::WP_Widget(false,$name= "Виджет \"Рубрики\"",$widgets_opt);
	  }
  
  function form($instance) {
    global $post;
    
	$widgettitle = isset($instance['widgettitle']) ? $instance['widgettitle'] : '';
    $widgetcategories = isset($instance['widgetcategories']) ? $instance['widgetcategories'] : '';
	$categories = get_categories(array('hide_empty' => 0));
	
  ?>
	<p>
		<label for="widgettitle">Заголовок</small>
		<input id="<?php echo $this->get_field_id('widgettitle'); ?>" name="<?php echo $this->get_field_name('widgettitle'); ?>" type="text" class="widefat" value="<?php echo $widgettitle;?>" /></label></p>  
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('widgetcategories'); ?>">Категории</label> 
			<select size="10" name="<?php echo $this->get_field_name('widgetcategories'); ?>[]"  id="<?php echo $this->get_field_id('widgetcategories'); ?>" multiple="multiple">
			<?php categoryList($categories, $widgetcategories); ?>
			</select>
		</label>
	</p>
    <?php
  } 
  
  function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['widgetcategories'] = $new_instance['widgetcategories'];
        return $instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
	$widgettitle = apply_filters('widgettitle', $instance['widgettitle']);	
	$widgetcategories = apply_filters('widgetcategories', $instance['widgetcategories']);
	
				echo $before_widget;
				echo $widgettitle != "" ? $before_title.$widgettitle.$after_title : "";
				foreach ($widgetcategories as $cat => $val) {
				$categories = get_categories(array('child_of' => $val));
?>
                    <div class="b-catlist <?php echo is_category($val) || cat_is_ancestor_of($val, get_queried_object()->term_id) ? 'open' : '';?>">
                        <div class="b-catlist__header"><a href="<?php echo get_category_link($val); ?>"><?php echo get_cat_name($val); ?></a></div>
                        <ul class="b-catlist__list">
<?php
					foreach ($categories as $cat) {
						is_category($cat->term_id) ? $carrClass = 'current' : $carrClass = '';
						echo '<li class="b-catlist__item '.$carrClass.'"><a href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a></li>';
					}
?>
                        </ul>
                    </div>
<?php
				}
				echo $after_widget; 
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("Cat_Widget");'));

/* Виджет Теги */
class AwTag_Widget extends WP_Widget {
	  function AwTag_Widget() {
		$widgets_opt = array('description'=>'Выводит список тегов');
		parent::WP_Widget(false,$name= "Виджет \"Теги\"",$widgets_opt);
	  }
  
  function form($instance) {
    global $post;
    
	$widgettitle = esc_attr(isset($instance['widgettitle']) ? $instance['widgettitle'] : '');
	
  ?>
	<p>
		<label for="widgettitle">Заголовок</small>
		<input id="<?php echo $this->get_field_id('widgettitle'); ?>" name="<?php echo $this->get_field_name('widgettitle'); ?>" type="text" class="widefat" value="<?php echo $widgettitle;?>" /></label></p>  
	</p>
    <?php
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
	$widgettitle = apply_filters('widgettitle', $instance['widgettitle']);	
	//Выводило виджет только при активном пункте рубрики.
	//if(!get_queried_object()->parent) return;
	echo $before_widget;
	echo $widgettitle != "" ? $before_title.$widgettitle.$after_title : "";
	$tags = get_category_tags(array('categories'=>get_queried_object()->term_id));
?>
	<ul class="b-tag">
<?php
	!isset($_GET['tag']) ? $all = 'current' : $all = '';
	$url = strtok($_SERVER["REQUEST_URI"],'?');
	echo '<li class="b-tag__item '.$all.'"><a href="'.$url.'">Все</a></li>';
	
	foreach ($tags as $tag) {
		$slug = get_term( $tag->tag_id, 'post_tag' )->slug;
		isset($_GET['tag']) && $_GET['tag'] == $slug ? $current = 'current' : $current = '';
		echo '<li class="b-tag__item '.$current.'"><a href="'.$url.'?tag='.$slug.'">'.$tag->tag_name.'</a></li>';
	}
	
?>					
	</ul>
<?php
	echo $after_widget; 
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("AwTag_Widget");'));
?>