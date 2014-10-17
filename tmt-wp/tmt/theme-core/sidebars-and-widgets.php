<?php
/* Register Sidebar */
if ( function_exists('register_sidebar') ){
	register_sidebar(array('name'=>'Сайдбар для статических страниц',
	'id' => 'left_sidebar',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>'
	));

	register_sidebar(array('name'=>'Сайдбар для записей',
		'id' => 'post_sidebar',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>'
	));
	
	register_sidebar(array('name'=>'Сайдбар архивов',
		'id' => 'archive_sidebar',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>'
	));
}
function categoryList($categories, $current, $parent = 0, $level = ""){
	if ($parent != 0) $level .= '- ';
	foreach ($categories as $cat) {
		if ($cat->parent != $parent) continue;
		$selected = ($cat->term_id == $current) ? 'selected="selected"' : '';
		echo '<option value="'.$cat->term_id.'" '.$selected.'>'.$level.''.$cat->name.'</option>';
		categoryList($categories, $current, $cat->term_id, $level);
	}	
}  

/* Виджет категории */
class Cat_Widget extends WP_Widget {
	  function Cat_Widget() {
		$widgets_opt = array('description'=>'');
		parent::WP_Widget(false,$name= "Виджет \"Сегменты\"",$widgets_opt);
	  }
  
  function form($instance) {
    global $post;
    
	$widgettitle = esc_attr(isset($instance['widgettitle']) ? $instance['widgettitle'] : '');
    $widgetcategories = isset($instance['widgetcategories']) ? $instance['widgetcategories'] : '';
	$categories = get_categories(array('hide_empty' => 0));
	
  ?>
	<p>
		<label for="widgettitle">Заголовок</small>
		<input id="<?php echo $this->get_field_id('widgettitle'); ?>" name="<?php echo $this->get_field_name('widgettitle'); ?>" type="text" class="widefat" value="<?php echo $widgettitle;?>" /></label></p>  
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('widgetcategories'); ?>">Категории</label> 
			<select name="<?php echo $this->get_field_name('widgetcategories'); ?>"  id="<?php echo $this->get_field_id('widgetcategories'); ?>">
			<?php categoryList($categories, $widgetcategories); ?>
			</select>
		</label>
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
	$widgetcategories = apply_filters('widgetcategories', $instance['widgetcategories']);
	
				echo str_replace('class="', 'class="b-catlist__widget ', $before_widget);;
				
				echo $widgettitle != "" ? $before_title.$widgettitle.$after_title : "";
				$categories = get_categories(array('child_of' => $widgetcategories));
?>
                    <div class="b-catlist <?php echo is_category($widgetcategories) || cat_is_ancestor_of($widgetcategories, get_queried_object()->term_id) || (is_single() && has_category($widgetcategories)) ? 'open' : '';?>">
                        <div class="b-catlist__header"><a href="<?php echo get_category_link($widgetcategories); ?>"><?php echo get_cat_name($widgetcategories); ?></a></div>
                        <ul class="b-catlist__list">
<?php
					foreach ($categories as $cat) {
						is_category($cat->term_id) || ( is_single() && has_category($cat->term_id)) ? $carrClass = 'current' : $carrClass = '';
						echo '<li class="b-catlist__item '.$carrClass.'"><a href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a></li>';
					}
?>
                        </ul>
                    </div>
<?php
				echo $after_widget; 
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("Cat_Widget");'));

/* Виджет Теги */
class AwTag_Widget extends WP_Widget {
	  function AwTag_Widget() {
		$widgets_opt = array('description'=>'Выводит список категорий');
		parent::WP_Widget(false,$name= "Виджет \"Категории\"",$widgets_opt);
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
	if(is_single()){
		$category = get_the_category();
		$cat_tree = get_category_parents($category[0]->term_id, FALSE, ':', TRUE);
		$top_cat = explode(':',$cat_tree);
		$parent = $top_cat[0];	
		$parentId= get_category_by_slug($parent)->term_id;
		
		$tags = get_category_tags(array('categories'=>$parentId));
	} else {
		$tags = get_category_tags(array('categories'=>get_queried_object()->term_id));
	}
	
?>
	<ul class="b-tag">
<?php
	/*!isset($_GET['tag']) ? $all = 'current' : $all = '';
	$url = strtok($_SERVER["REQUEST_URI"],'?');
	echo '<li class="b-tag__item '.$all.'"><a href="'.$url.'">Все</a></li>';*/
	
	foreach ($tags as $tag) {
		$slug = get_term( $tag->tag_id, 'post_tag' )->slug;
		isset($_GET['tag']) && $_GET['tag'] == $slug ? $current = 'current' : $current = '';
		if(is_single()){
			echo '<li class="b-tag__item '.$current.'"><a href="'.get_category_link($parentId).'?tag='.$slug.'">'.$tag->tag_name.'</a></li>';
		} else {
			echo '<li class="b-tag__item '.$current.'"><a href="'.$url.'?tag='.$slug.'">'.$tag->tag_name.'</a></li>';
		}
		
	}
	
?>					
	</ul>
<?php
	echo $after_widget; 
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("AwTag_Widget");'));
?>