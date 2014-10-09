<?php 
	get_header(); 
?>	
<div class="b-page">
    <div class="container">
        <div class="row">
            <aside class="span4 b-sidebar">
				<?php
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('left_sidebar') ) : endif; 
				?>
            </aside>
            <div class="span8">
	<?php 
				if ( have_posts() ) :				
					if(is_author()){
?>
					<h1 class="b-page__title"><?php echo get_category_by_slug($parent)->name; ?></h1>
<?php
					} else {
					$category = get_the_category();
					$cat_tree = get_category_parents($category[0]->term_id, FALSE, ':', TRUE);
					$top_cat = explode(':',$cat_tree);
					$parent = $top_cat[0];
?>
					<h1 class="b-page__title"><?php echo get_category_by_slug($parent)->name; ?></h1>
<?php					
					}
				?>
                
				<?php 
				while (have_posts()) : the_post();  
					$authorId = get_the_author_meta('ID');
				?>
                <article class="b-aitem">
                        <div class="row b-aitem__header">
                            <img class="b-aitem__photo" src="<?php echo get_avatar_url($authorId, 150); ?>" alt=""/>
                            <div class="b-aitem__detalis">
                                <h2 class="b-aitem__title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <span class="b-aitem__autor">By <a href="<?php echo get_author_posts_url($authorId); ?>"><?php echo get_the_author(); ?></a></span>
                                <span class="b-aitem__date"><?php the_time('d.m.Y'); ?></span>
                            </div>
                        </div>
                        <div class="b-text b-aitem__text">
                            <p><?php echo get_the_excerpt(); ?><a class="b-aitem__more" href="<?php echo get_permalink();?>">больше</a></p>
                        </div>
                </article>
				<?php 
					endwhile;
					else :
						echo wpautop( '<h1 class="b-page__title">Пока в данном разделе нет материалов</h1>' );
					endif;
					if (function_exists('wp_pagenavi')) {
						wp_pagenavi(); 
					} else {
						echo '<div>Установите <a target="blank" href="https://wordpress.org/plugins/wp-pagenavi/">Плагин пагинатора</a></div>';
					}
				?>
            </div>
        </div>
    </div>
</div>
<?php
	get_footer(); 
?>